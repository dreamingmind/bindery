 <?php
class WorkshopsController extends AppController {

	var $name = 'Workshops';
        /**
         * @var string $result_ImagePath picks the size of image in search result blocks
         */

        
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('upcoming');
        }
        
        function upcoming(){
//        debug($this->Workshop);die;
            $this->set('upcoming', $this->Workshop->workshops_upcoming);
            $this->set('potential',  $this->Workshop->workshops_potential);
            $this->set('now', $this->Workshop->workshops_now);
//            $this->set('result_imagePath');
            $this->layout = 'noThumbnailPage';
        }

	function index() {
		$this->Workshop->recursive = 0;
		$this->set('workshops', $this->paginate('Workshop'));
                debug($this->viewVars['workshops']);die;
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid workshop', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('workshop', $this->Workshop->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Workshop->create();
			if ($this->Workshop->save($this->data)) {
				$this->Session->setFlash(__('The workshop has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The workshop could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid workshop', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Workshop->save($this->data)) {
				$this->Session->setFlash(__('The workshop has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The workshop could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Workshop->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for workshop', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Workshop->delete($id)) {
			$this->Session->setFlash(__('Workshop deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Workshop was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>