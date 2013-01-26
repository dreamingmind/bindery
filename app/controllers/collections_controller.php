<?php
class CollectionsController extends AppController {

	var $name = 'Collections';

	function index() {
		$this->Collection->recursive = 0;
		$this->set('collections', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid collection', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('collection', $this->Collection->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Collection->create();
			if ($this->Collection->save($this->data)) {
				$this->Session->setFlash(__('The collection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Collection->Category->find('list');
		$this->set(compact('categories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid collection', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Collection->save($this->data)) {
				$this->Session->setFlash(__('The collection has been saved', true));
                    debug($this->data);die;
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Collection->read(null, $id);
		}
		$categories = $this->Collection->Category->find('list');
		$this->set(compact('categories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for collection', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Collection->delete($id)) {
			$this->Session->setFlash(__('Collection deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Collection was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>