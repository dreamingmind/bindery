<?php
class DiagramsController extends AppController {

	var $name = 'Diagrams';
        
        var $layout = 'noThumbnailPage';

	function index() {
		$this->Diagram->recursive = 0;
		$this->set('diagrams', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid diagram', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('diagram', $this->Diagram->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Diagram->create();
			if ($this->Diagram->save($this->data)) {
				$this->Session->setFlash(__('The diagram has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagram could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid diagram', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Diagram->save($this->data)) {
				$this->Session->setFlash(__('The diagram has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagram could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Diagram->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for diagram', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Diagram->delete($id)) {
			$this->Session->setFlash(__('Diagram deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Diagram was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>