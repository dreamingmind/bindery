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
			$this->Session->setFlash(__('Invalid diagram'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('diagram', $this->Diagram->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Diagram->create();
			if ($this->Diagram->save($this->request->data)) {
				$this->Session->setFlash(__('The diagram has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagram could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid diagram'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Diagram->save($this->request->data)) {
				$this->Session->setFlash(__('The diagram has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The diagram could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Diagram->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for diagram'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Diagram->delete($id)) {
			$this->Session->setFlash(__('Diagram deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Diagram was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>