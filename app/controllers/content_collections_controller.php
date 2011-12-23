<?php
class ContentCollectionsController extends AppController {

	var $name = 'ContentCollections';

	function index() {
		$this->ContentCollection->recursive = 0;
		$this->set('contentCollections', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid content collection', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contentCollection', $this->ContentCollection->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->ContentCollection->create();
			if ($this->ContentCollection->save($this->data)) {
				$this->Session->setFlash(__('The content collection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content collection could not be saved. Please, try again.', true));
			}
		}
		$galleries = $this->ContentCollection->Gallery->find('list');
		$dispatches = $this->ContentCollection->Dispatch->find('list');
		$contents = $this->ContentCollection->Content->find('list');
		$exhibits = $this->ContentCollection->Exhibit->find('list');
		$collections = $this->ContentCollection->Collection->find('list');
		$this->set(compact('galleries', 'dispatches', 'contents', 'exhibits', 'collections'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid content collection', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ContentCollection->save($this->data)) {
				$this->Session->setFlash(__('The content collection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content collection could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ContentCollection->read(null, $id);
		}
		$galleries = $this->ContentCollection->Gallery->find('list');
		$dispatches = $this->ContentCollection->Dispatch->find('list');
		$contents = $this->ContentCollection->Content->find('list');
		$exhibits = $this->ContentCollection->Exhibit->find('list');
		$collections = $this->ContentCollection->Collection->find('list');
		$this->set(compact('galleries', 'dispatches', 'contents', 'exhibits', 'collections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for content collection', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContentCollection->delete($id)) {
			$this->Session->setFlash(__('Content collection deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Content collection was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>