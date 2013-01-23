<?php
class CatalogsController extends AppController {

	var $name = 'Catalogs';

	function index() {
		$this->Catalog->recursive = 0;
		$this->set('catalogs', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid catalog', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('catalog', $this->Catalog->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Catalog->create();
			if ($this->Catalog->save($this->data)) {
				$this->Session->setFlash(__('The catalog has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The catalog could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid catalog', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Catalog->save($this->data)) {
				$this->Session->setFlash(__('The catalog has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The catalog could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Catalog->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for catalog', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Catalog->delete($id)) {
			$this->Session->setFlash(__('Catalog deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Catalog was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>