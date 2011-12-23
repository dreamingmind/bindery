<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
/**
 * Images Controller
 * 
 * @package       bindery
 * @subpackage    bindery.controller
 * @todo write populator that reads the current image collection and writes records for images that don't have them
 */
class ImagesController extends AppController {

	var $name = 'Images';
        
        /**
         * The search results
         * @var array $searchRecords
         */
        var $searchRecords = array();

	function index() {
            $this->paginate = array('order'=>array('Image.id'=> 'desc'));
		$this->Image->recursive = 0;
		$this->set('images', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('image', $this->Image->read(null, $id));
	}

    function add() {
        if (!empty($this->data)) {
            //debug($this->data); die;
            //read exif data and set exif fields
            
            $this->get_exif($this->data);
            
            //Target the selected Upload directory
//            $this->Image->setImageDirectory($this->data['Image']['gallery']);
//            debug($this->Image); die;
            
            $this->Image->create();
        if ($this->Image->save($this->data)) {
                $this->Session->setFlash(__('The image has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
            }
        }
    }
    
    /**
     * Create a layout to upload several images at once
     * @param type $count 
     */
    function multi_add($count=null) {
        if (!empty($this->data)) {
            //read exif data and set exif fields
            $success = TRUE;
            $message = null;
            foreach ($this->data as $val) {
                if (!$val['Image']['img_file']['name']==null) {
                    // set the target directory
                    //debug($val); die;
                    $this->Image->Behaviors->Upload->setImageDirectory('Image', 'img_file', 'img/'.$val['Image']['gallery']);
                    $this->Image->create();
                    if ($this->Image->save($val)) {
                        $message .= '<p>Saved ' . $this->Image->id . $val['Image']['img_file']['name'] . '.</p>';
                        $success && TRUE;
                    } else {
                        $message .= 'Failed ' . $val['Image']['img_file']['name'] . '. ';
                        $success && FALSE;
                    }
                }
            }
            if ($success) {
                $this->Session->setFlash(__($message, true));                    
                $this->redirect(array('action' => 'index'));                    
            }
                $this->Session->setFlash(__($message, true));                    
        }
    }

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid image', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Image->save($this->data)) {
				$this->Session->setFlash(__('The image has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Image->read(null, $id);
		}
	}
        
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for image', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Image->delete($id)) {
			$this->Session->setFlash(__('Image deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Image was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
        
        function search() {
            $this->searchRecords = $this->Image->find('all', array(
                'conditions'=>array('Image.alt LIKE'=> "%{$this->data['Image']['searchInput']}%")
            ));
            /**
             * make the search value available for inclusion in the
             * image grid columns/sizes form so requesting a re-layout 
             * doesn't loose the found set
             */
            $this->set('searchInput',$this->data['Image']['searchInput']);
//            debug($this->searchRecords); die;
            $this->image_grid();
            $this->render('image_grid');
        }
        
        function image_grid(){

            $this->layout = 'noThumbnailPage';
            // form data or default?
            if(isset($this->data)&&isset($this->data['Image']['columns'])){
                $column = $this->data['Image']['columns'];
                $size = $this->data['Image']['sizes'];
            } else {
                $column = 8;
                $size = 'x75y56';
            }
            /**
             * the layout settings need to be prepared for inclusion
             * in the layout search box as hidden fields so searches
             * won't keep jumping back to the default grid
             */
            $this->set('hidden', array(
                'columns'=>array('value'=>$column),
                'sizes'=>array('value'=>$size))
                );

            // make form drop-down lists
            $sizes = array();
            foreach($this->Image->actsAs['Upload']['img_file']['thumbsizes'] as $key=>$val) {
                $sizes[$key] = $key;
            }
            $this->set('size', $size);
            $this->set('column', $column);
            $this->set('columns', array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10));
            $this->set('sizes',$sizes);

            // get the pictures
            if ($this->searchRecords==null) {
                $this->searchRecords = $this->Image->find('all', array('contain'=>false));
            }
            $this->set('chunk', array_chunk($this->searchRecords, $column+1));
        }
        
        /**
         * Populate an Image records exif fields
         * If the record is a has a type=file format with uploaded
         * image data in the Image.img_file array, the uploading
         * file will be operated on. Providing a path will override
         * that or get data for a non-upload-style record
         * 
         * @todo Get some error trapping in here!
         * @param array &$record A standard one record data array
         * @param string $path Path to the image including the file name
         */
        function get_exif(&$record, $path=null) {
            
            if ($path == null) {
                $path = $record['Image']['img_file']['tmp_name'];
            }
            
            $file = new File($path);            
            $exif_data = exif_read_data($file->path);
//            debug($exif_data);die;
            $record['Image']['height'] = $exif_data['COMPUTED']['Height'];
            $record['Image']['width'] = $exif_data['COMPUTED']['Width'];
            $record['Image']['date'] = strtotime($exif_data['DateTime']);
            $record['Image']['mymetype'] = $exif_data['MimeType'];
            $record['Image']['size'] = $exif_data['FileSize'];
        }
        
}
?>