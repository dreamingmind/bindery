<?php
class CopiesController extends AppController {

	var $name = 'Copies';

	function index() {
		$this->Copy->recursive = 0;
		$this->set('copies', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid copy'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('copy', $this->Copy->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Copy->create();
			if ($this->Copy->save($this->request->data)) {
				$this->Session->setFlash(__('The copy has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The copy could not be saved. Please, try again.'));
			}
		}
		$editions = $this->Copy->Edition->find('list');
		$this->set(compact('editions'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid copy'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Copy->save($this->request->data)) {
				$this->Session->setFlash(__('The copy has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The copy could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Copy->read(null, $id);
		}
		$editions = $this->Copy->Edition->find('list');
		$this->set(compact('editions'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for copy'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Copy->delete($id)) {
			$this->Session->setFlash(__('Copy deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Copy was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>