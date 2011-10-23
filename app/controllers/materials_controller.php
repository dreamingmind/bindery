<?php
class MaterialsController extends AppController {

	var $name = 'Materials';

	function index() {
		$this->Material->recursive = 0;
		$this->set('materials', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid material', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('material', $this->Material->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Material->create();
			if ($this->Material->save($this->data)) {
				$this->Session->setFlash(__('The material has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The material could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid material', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Material->save($this->data)) {
				$this->Session->setFlash(__('The material has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The material could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Material->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for material', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Material->delete($id)) {
			$this->Session->setFlash(__('Material deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Material was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>