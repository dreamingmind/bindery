<?php
App::uses('AppController', 'Controller');
/**
 * Carts Controller
 *
 * @property Cart $Cart
 */
class CartsController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'add', 'edit', 'addToCart');
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cart->recursive = 0;
		$this->set('carts', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cart->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
		$this->set('cart', $this->Cart->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cart->create();
			if ($this->Cart->save($this->request->data)) {
				$this->Session->setFlash(__('The cart has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart could not be saved. Please, try again.'));
			}
		}
		$users = $this->Cart->User->find('list');
		$supplements = $this->Cart->Supplement->find('list');
		$this->set(compact('users', 'supplements'));
	}
	
	public function addToCart() {
		$data = array(
			'Cart' => array(
				'user_id' => $this->Auth->user('id'),
				'phpsession_id' => ($this->Auth->user('id') == NULL) ? $this->Session->id() : NULL,
				'data' => date('r', time())
			)
		);
		
		$this->Cart->save($data);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cart->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cart->save($this->request->data)) {
				$this->Session->setFlash(__('The cart has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cart.' . $this->Cart->primaryKey => $id));
			$this->request->data = $this->Cart->find('first', $options);
		}
		$users = $this->Cart->User->find('list');
		$supplements = $this->Cart->Supplement->find('list');
		$this->set(compact('users', 'supplements'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cart->id = $id;
		if (!$this->Cart->exists()) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cart->delete()) {
			$this->Session->setFlash(__('Cart deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cart was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
