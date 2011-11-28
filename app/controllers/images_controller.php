<?php
class ImagesController extends AppController {

	var $name = 'Images';

	function index() {
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
            //read exif data and set exif fields
            $file = new File($this->data['Image']['img_file']['tmp_name']);
            $exif_data = exif_read_data($file->path);
            $this->data['Image']['height'] = $exif_data['COMPUTED']['Height'];
            $this->data['Image']['width'] = $exif_data['COMPUTED']['Width'];
            $this->data['Image']['picture_datetime'] = strtotime($exif_data['DateTime']);
            
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
    function multi_add($count=null) {
        if (!empty($this->data)) {
            //read exif data and set exif fields
//            $file = new File($this->data['Image']['img_file']['tmp_name']);
//            $exif_data = exif_read_data($file->path);
//            $this->data['Image']['height'] = $exif_data['COMPUTED']['Height'];
//            $this->data['Image']['width'] = $exif_data['COMPUTED']['Width'];
//            $this->data['Image']['picture_datetime'] = strtotime($exif_data['DateTime']);
            
            //Target the selected Upload directory
//            $this->Image->setImageDirectory($this->data['Image']['gallery']);
//            debug($this->Image); die;
            $success = TRUE;
            $message = null;
            foreach ($this->data as $val) {
                if (!$val['Image']['img_file']['name']==null) {
                    echo '<pre>';
                    print_r($val);
                    echo '</pre>';
                    die;
                    $this->Image->create();
                    if ($this->Image->save($val)) {
                        $message .= 'Saved ' . $this->Image->id . $val['Image']['img_file']['name'] . '. ';
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
//            die;   
//            $this->Image->create();
////            debug($this->data); die;
//        if ($this->Image->save($this->data)) {
//                $this->Session->setFlash(__('The image has been saved', true));
//                $this->redirect(array('action' => 'index'));
//            } else {
//                $this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
//            }
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
}
?>