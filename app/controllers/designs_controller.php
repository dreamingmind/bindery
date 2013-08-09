<?php
class DesignsController extends AppController {

	var $name = 'Designs';

	function index() {
		$this->Design->recursive = 0;
		$this->set('designs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid design', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('design', $this->Design->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Design->create();
			if ($this->Design->save($this->data)) {
				$this->Session->setFlash(__('The design has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The design could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid design', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Design->save($this->data)) {
				$this->Session->setFlash(__('The design has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The design could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Design->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for design', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Design->delete($id)) {
			$this->Session->setFlash(__('Design deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Design was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>