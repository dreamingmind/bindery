<?php
class EditionsController extends AppController {

	var $name = 'Editions';

	function index() {
		$this->Edition->recursive = 0;
		$this->set('editions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid edition'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('edition', $this->Edition->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Edition->create();
			if ($this->Edition->save($this->request->data)) {
				$this->Session->setFlash(__('The edition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The edition could not be saved. Please, try again.'));
			}
		}
		$collections = $this->Edition->Collection->find('list', array(
                    'fields' => array('Collection.id', 'Collection.heading'),
                    'conditions' => array('Collection.category_id' => 1474) // art category
                ));
		$this->set(compact('collections'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid edition'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Edition->save($this->request->data)) {
				$this->Session->setFlash(__('The edition has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The edition could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Edition->read(null, $id);
		}
		$collections = $this->Edition->Collection->find('list');
		$this->set(compact('collections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for edition'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Edition->delete($id)) {
			$this->Session->setFlash(__('Edition deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Edition was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>