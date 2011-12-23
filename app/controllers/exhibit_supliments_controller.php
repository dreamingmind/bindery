<?php
class ExhibitSuplimentsController extends AppController {

	var $name = 'ExhibitSupliments';

	function index() {
		$this->ExhibitSupliment->recursive = 0;
		$this->set('exhibitSupliments', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid exhibit supliment', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('exhibitSupliment', $this->ExhibitSupliment->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ExhibitSupliment->create();
			if ($this->ExhibitSupliment->save($this->data)) {
				$this->Session->setFlash(__('The exhibit supliment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exhibit supliment could not be saved. Please, try again.', true));
			}
		}
		$images = $this->ExhibitSupliment->Image->find('list');
		$exhibits = $this->ExhibitSupliment->Exhibit->find('list');
		$contents = $this->ExhibitSupliment->Content->find('list');
		$this->set(compact('images', 'exhibits', 'contents'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid exhibit supliment', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ExhibitSupliment->save($this->data)) {
				$this->Session->setFlash(__('The exhibit supliment has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exhibit supliment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ExhibitSupliment->read(null, $id);
		}
		$images = $this->ExhibitSupliment->Image->find('list');
		$exhibits = $this->ExhibitSupliment->Exhibit->find('list');
		$contents = $this->ExhibitSupliment->Content->find('list');
		$this->set(compact('images', 'exhibits', 'contents'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for exhibit supliment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ExhibitSupliment->delete($id)) {
			$this->Session->setFlash(__('Exhibit supliment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Exhibit supliment was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>