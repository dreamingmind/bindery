<?php
class SessionsController extends AppController {

	var $name = 'Sessions';

	function index() {
		$this->Session->recursive = 0;
		$this->set('sessions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid session'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('session', $this->Session->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Session->create();
			if ($this->Session->save($this->request->data)) {
				$this->Session->setFlash(__('The session has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The session could not be saved. Please, try again.'));
			}
		}
		$workshops = $this->Session->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid session'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Session->save($this->request->data)) {
				$this->Session->setFlash(__('The session has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The session could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Session->read(null, $id);
		}
		$workshops = $this->Session->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for session'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Session->delete($id)) {
			$this->Session->setFlash(__('Session deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Session was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

        function edit_session($slug){
            $this->layout = 'noThumbnailPage';
            $article = $this->Session->Workshop->ContentCollection->findWorkshopTarget(array('Content.slug' => $slug, 'Workshop.category_id' => $this->Workshop->Category->categoryNI['workshop']));
            $this->set('feature', $this->Workshop->workshops_all[$article[0]['Workshop']['id']]);

    }

        
}
?>