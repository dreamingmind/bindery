<?php
class WorkshopSessionsController extends AppController {

	var $name = 'WorkshopSessions';

	function index() {
		$this->Session->recursive = 0;
		$this->set('sessions', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->WorkshopSession->setFlash(__('Invalid session'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('session', $this->WorkshopSession->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->WorkshopSession->create();
			if ($this->WorkshopSession->save($this->request->data)) {
				$this->WorkshopSession->setFlash(__('The session has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->WorkshopSession->setFlash(__('The session could not be saved. Please, try again.'));
			}
		}
		$workshops = $this->WorkshopSession->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->WorkshopSession->setFlash(__('Invalid session'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->WorkshopSession->save($this->request->data)) {
				$this->WorkshopSession->setFlash(__('The session has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->WorkshopSession->setFlash(__('The session could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->WorkshopSession->read(null, $id);
		}
		$workshops = $this->WorkshopSession->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->WorkshopSession->setFlash(__('Invalid id for session'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->WorkshopSession->delete($id)) {
			$this->WorkshopSession->setFlash(__('Session deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->WorkshopSession->setFlash(__('Session was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

        function edit_session($slug){
            $this->layout = 'noThumbnailPage';
            $article = $this->WorkshopSession->Workshop->ContentCollection->findWorkshopTarget(array('Content.slug' => $slug, 'Workshop.category_id' => $this->WorkshopSession->Workshop->Category->categoryNI['workshop']));
            $this->set('feature', $this->WorkshopSession->Workshop->workshops_all[$article[0]['Workshop']['id']]);

    }

        
}
?>