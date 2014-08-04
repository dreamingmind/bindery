<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.User
 */
/**
 * Requests Controller
 * 
 * Requests manages storage of data submitted by visitors through provided forms
 * on the Workshop landing page. The requests are Workshop date requests.
 * 
 * @package       bindery
 * @subpackage    bindery.User
 * @todo Can this module be generalized to store other user interaction data?
 * 
*/
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
			$this->Session->setFlash(__('Invalid request'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('request', $this->Request->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Request->create();
			if ($this->Request->save($this->request->data)) {
				$this->Session->setFlash(__('The request has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The request could not be saved. Please, try again.'));
			}
		}
		$workshops = $this->Request->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid request'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Request->save($this->request->data)) {
				$this->Session->setFlash(__('The request has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The request could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Request->read(null, $id);
		}
		$workshops = $this->Request->Workshop->find('list');
		$this->set(compact('workshops'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for request'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Request->delete($id)) {
			$this->Session->setFlash(__('Request deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Request was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        function request(){
            $this->request->data['Request']['month']=$this->request->data['Request']['month']['month'];
            $this->request->data['Request']['year']=$this->request->data['Request']['year']['year'];
            $this->Request->save($this->request->data);
            $this->set('result',$this->request->data);
            $this->Email->from    = $this->company['email'];
            $this->Email->subject = 'Thanks for your Dreaming Mind Workshop date request';
            $body = <<< BOD
Thank you for you interest in Dreamng Mind Workshops.
    
Now, CHECK OUT THIS SIGNATURE!! It's new in \$this->company.

{$this->company['workshopSignature']}
BOD;

            if (isset($this->request->data['Request']['email'])){
                $this->Email->to      = $this->request->data['Request']['email'];
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