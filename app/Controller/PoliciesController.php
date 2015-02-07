<?php
App::uses('AppController', 'Controller');

/**
 * Policies Controller
 *
 * @property Policy $Policy
 */
class PoliciesController extends AppController {

	/**
	 * Before filter
	 * 
	 * Set the choice lists for name and policy display rules
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('name_displays', $this->Policy->displayOptions());
		$this->set('policy_displays', $this->Policy->displayOptions());
		$this->set('parents', $this->Policy->parents());
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Policy->recursive = 0;
		$this->set('policies', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Policy->exists($id)) {
			throw new NotFoundException(__('Invalid policy'));
		}
		$options = array('conditions' => array('Policy.' . $this->Policy->primaryKey => $id));
		$this->set('policy', $this->Policy->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Policy->create();
			if ($this->Policy->save($this->request->data)) {
				$this->Session->setFlash(__('The policy has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The policy could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Policy->create();
		}
		$parentPolicies = $this->Policy->ParentPolicy->find('list');
		$this->set(compact('parentPolicies'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Policy->exists($id)) {
			throw new NotFoundException(__('Invalid policy'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Policy->save($this->request->data)) {
				$this->Session->setFlash(__('The policy has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The policy could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Policy.' . $this->Policy->primaryKey => $id));
			$this->request->data = $this->Policy->find('first', $options);
		}
		$parentPolicies = $this->Policy->parents();
		$this->set(compact('parentPolicies'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Policy->id = $id;
		if (!$this->Policy->exists()) {
			throw new NotFoundException(__('Invalid policy'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Policy->delete()) {
			$this->Session->setFlash(__('Policy deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Policy was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function testMe() {
//		dmDebug::ddd($this->helpers, 'helpers');
		dmDebug::ddd($this->Policy->policyRecord('Quote'), 'quote');
//		dmDebug::ddd($this->Policy->collection('General Order'), 'general order');
		dmDebug::ddd($this->company['vacation'], 'vacation');
	}
}
