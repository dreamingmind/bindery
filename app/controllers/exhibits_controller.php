<?php
/**
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.publishing.news_feed
 */
/**
 * Exhibit Controller
 * 
 * @package       bindery
 * @subpackage    bindery.publishing.news_feed
 */
class ExhibitsController extends AppController {

	var $name = 'Exhibits';

	function index() {
		$this->Exhibit->recursive = 0;
		$this->set('exhibits', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'exhibit'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('exhibit', $this->Exhibit->read(null, $id));
	}

	function add() {
            if (!empty($this->data)) {
                $this->Exhibit->create();
                if ($this->Exhibit->save($this->data)) {
                    $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'exhibit'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'exhibit'));
                }
            }
	}

	function edit($id = null) {
            if (!$id && empty($this->data)) {
                $this->Session->setFlash(sprintf(__('Invalid %s', true), 'exhibit'));
                $this->redirect(array('action' => 'index'));
            }
            if (!empty($this->data)) {
                if ($this->Exhibit->save($this->data)) {
                    $this->Session->setFlash(sprintf(__('The %s has been saved', true), 'exhibit'));
                    if (isset($this->data['button'])) {
                        $this->redirect(array('action' => 'edit', $this->data['button']));
                    } else {
                    $this->redirect(array('action' => 'index'));
                    }
                } else {
                    $this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'exhibit'));
                }
            }
		if (empty($this->data)) {
                    $this->data = $this->Exhibit->read(null, $id);
                    $this->set('neighbors', $this->Exhibit->find('neighbors', array('field'=>'id', 'value'=>$this->data['Exhibit']['id'])));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'exhibit'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Exhibit->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Exhibit'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Exhibit'));
		$this->redirect(array('action' => 'index'));
	}

function test(){
    debug($this->Exhibit);
}




        function ingest_images() {

            App::import('Core', array('File', 'Folder'));
            $saved = array();
            $failed_save = array();
            $missing_pic = array();
            $sourceDir = "img".DS."uploads".DS."x640y480";

            $folder = new Folder();
            $sourceD = $folder->cd(WWW_ROOT.$sourceDir);
            $source = $folder->read();
            $source = array_flip($source[1]);
            $orig = array_flip($source);
            $records = $this->Exhibit->find('all', array('fields'=>array('id','img_file'), 'conditions'=>array('img_file !='=>'', 'filesize <'=>1)));

            $baseData = array(
                'name'=>null,
                'type'=>'image/jpeg',
                'tmp_name'=>null,
                'error'=>1,
                'size'=>null);
               //debug($records);die;
            foreach($records as $key=>$val) {
                if(isset($source[$val['Exhibit']['img_file']]) && $val['Exhibit']['img_file']) {
//                    debug($source[$val['Exhibit']['img_file']]);
//                    debug($orig[$source[$val['Exhibit']['img_file']]]);
                    $file = new File(WWW_ROOT.$sourceDir.DS.$val['Exhibit']['img_file'], false);
                    $img_info = getimagesize(WWW_ROOT.$sourceDir.DS.$val['Exhibit']['img_file']);
                    $file->info();
                    if ($file->copy("img/exhibits/native".DS.$file->name, true)) {
                        $baseData['error']=0;
                        $baseData['tmp_name']="img/exhibits/native".DS.$file->name;
                    } else {
                        $this->Session->setFlash('There was a problem storing the tmp file');
                        return false;
                    }
                    if (strtolower($file->info['extension']) != 'jpeg' && strtolower($file->info['extension']) != 'jpg') {
                        $this->Session->setFlash('Not a jpeg. Improve your code.');
                        return false;
                    } else {
                        $baseData['name']=$file->name().'.'.$file->info['extension'];
                    }

                    if ($file->size() > 0) {
                        $baseData['size']=$file->size();
                    } else {
                        $this->Session->setFlash('Size was zero. Not so good.');
                        return false;
                    }

                    $val['Exhibit']['img_file'] = $baseData;
                    $val['Exhibit']['batch'] = true;
                    $val['Exhibit']['width'] = $img_info[0];
                    $val['Exhibit']['height'] = $img_info[1];

                    $this->Exhibit->create();
                    $data = $val;
                    if ($this->Exhibit->save($data)){
                        if (!isset($val['Exhibit'])){
                            debug($key);
                            debug($saved);die;
                        }
                        array_push($saved, $val['Exhibit']);
                        //unset($source[($val['Exhibit']['img_file'])]);
                    } else {
                        array_push($failed_save, $val['Exhibit']);
                    }
                    unset($file);
                } elseif (isset($val['Exhibit'])) {
                    array_push($missing_pic, $val['Exhibit']);
                }
            }
            $this->set('saved', $saved);
            $this->set('failed_save', $failed_save);
            $this->set('missing_pic', $missing_pic);
            $this->set('source',$source);
        }
}
?>