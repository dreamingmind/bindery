<?php
class DesignsController extends AppController {

	var $name = 'Designs';

	function index() {
		$this->Design->recursive = 0;
		$this->set('designs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid design'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('design', $this->Design->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Design->create();
			if ($this->Design->save($this->request->data)) {
				$this->Session->setFlash(__('The design has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The design could not be saved. Please, try again.'));
			}
		}
		$users = $this->Design->User->find('list');
		$supplements = $this->Design->Supplement->find('list');
		$this->set(compact('users', 'supplements'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid design'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Design->save($this->request->data)) {
				$this->Session->setFlash(__('The design has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The design could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Design->read(null, $id);
		}
		$users = $this->Design->User->find('list');
		$supplements = $this->Design->Supplement->find('list');
		$this->set(compact('users', 'supplements'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for design'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Design->delete($id)) {
			$this->Session->setFlash(__('Design deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Design was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>