<?php
class RequestsController extends AppController {
    

	var $name = 'Requests';
        
        function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('request');
        }


	function index() {
		$this->Request->recursive = 0;
		$this->set('requests', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('request', $this->Request->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Request->create();
			if ($this->Request->save($this->data)) {
				$this->Session->setFlash(__('The request has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The request could not be saved. Please, try again.', true));
			}
		}
		$workshops = $this->Request->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid request', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Request->save($this->data)) {
				$this->Session->setFlash(__('The request has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The request could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Request->read(null, $id);
		}
		$workshops = $this->Request->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for request', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Request->delete($id)) {
			$this->Session->setFlash(__('Request deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Request was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
        function request(){
            $this->data['Request']['month']=$this->data['Request']['month']['month'];
            $this->data['Request']['year']=$this->data['Request']['year']['year'];
            $this->Request->save($this->data);
            $this->set('result',$this->data);
            $this->Email->from    = $this->company['email'];
            $this->Email->subject = 'Thanks for your Dreaming Mind Workshop date request';
            $body = <<< BOD
Thank you for you interest in Dreamng Mind Workshops.
    
Now, CHECK OUT THIS SIGNATURE!! It's new in \$this->company.

{$this->company['workshopSignature']}
BOD;

            if (isset($this->data['Request']['email'])){
                $this->Email->to      = $this->data['Request']['email'];
                $this->Email->send($body);
            }
            $this->Email->to      = $this->company['email'];
            $this->Email->send($body);
            
                
            //  validate data
            //  send email w/ php
            //  $this->setflash('Thanks for your info, we'll spam you for life')
            //  $this->referrer() to redirect to the page
        }

}
?>