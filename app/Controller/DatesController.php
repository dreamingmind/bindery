<?php
class DatesController extends AppController {

	var $name = 'Dates';

	function index() {
		$this->Date->recursive = 0;
		$this->set('dates', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid date'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('date', $this->Date->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Date->create();
			if ($this->Date->save($this->request->data)) {
				$this->Session->setFlash(__('The date has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The date could not be saved. Please, try again.'));
			}
		}
		$sessions = $this->Date->Session->find('list');
		$this->set(compact('sessions'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid date'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Date->save($this->request->data)) {
				$this->Session->setFlash(__('The date has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The date could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Date->read(null, $id);
		}
		$sessions = $this->Date->Session->find('list');
		$this->set(compact('sessions'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for date'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Date->delete($id)) {
			$this->Session->setFlash(__('Date deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Date was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>