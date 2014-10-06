<?php
App::uses('AppController', 'Controller');
/**
 * Parts Controller
 *
 * @property Part $Part
 */
class PartsController extends AppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		if ($this->Auth->user('id')) {
			$this->Auth->allow('index', 'view', 'add', 'edit', 'modify');
		}
	}

	/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Part->recursive = 0;
		$this->set('parts', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Part->exists($id)) {
			throw new NotFoundException(__('Invalid part'));
		}
		$options = array('conditions' => array('Part.' . $this->Part->primaryKey => $id));
		$this->set('part', $this->Part->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Part->create();
			if ($this->Part->save($this->request->data)) {
				$this->Session->setFlash(__('The part has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The part could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Part->exists($id)) {
			throw new NotFoundException(__('Invalid part'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Part->save($this->request->data)) {
				$this->Session->setFlash(__('The part has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The part could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Part.' . $this->Part->primaryKey => $id));
			$this->request->data = $this->Part->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Part->id = $id;
		if (!$this->Part->exists()) {
			throw new NotFoundException(__('Invalid part'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Part->delete()) {
			$this->Session->setFlash(__('Part deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Part was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function modify() {
		if ($this->request->is('post')) {
			$this->Part->saveMany($this->request->data);
		}
		$products = $this->Part->find('all', array(
			'conditions' => array('code LIKE' => '%2%.%2%'),
			'fields' => array('code', 'name', 'price')
		));
		
		foreach ($products as $index => $product) {
//			$products[$index]['Part']['code'] = str_replace('.3', '.8', $product['Part']['code']);
//			$products[$index]['Part']['code'] = str_replace('88', '86', $product['Part']['code']);
//			$products[$index]['Part']['name'] = str_replace('3.75 x 6.75', '8.5 x 11', $product['Part']['name']);
		}
		$this->request->data = $products;
//		dmDebug::ddd($this->request->data, 'data');
	}
}
