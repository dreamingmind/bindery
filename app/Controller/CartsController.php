<?php
App::uses('AppController', 'Controller');
/**
 * Carts Controller
 *
 * @property Cart $Cart
 */
class CartsController extends AppController {
	
	public $helpers = array('PurchasedProduct');


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'add', 'edit', 'addToCart', 'delete', 'checkout');
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
		$this->set(compact('users'));
	}
	
//		if ($this->request->is('POST')) {
//			$this->layout = 'ajax';
//		}
//		
//		$key = $this->request->data['specs_key']; // this is the array node where the detail specs are listed
//
//		$data = array(
//			'Cart' => array(
//				'user_id' => $this->Auth->user('id'),
//				'session_id' => ($this->Auth->user('id') == NULL) ? $this->Session->id() : NULL,
//				'data' => serialize($this->request->data),
//				'design_name' => $this->request->data[$key]['description'],
//				'price' => rand(100, 300)
//			)
//		);
//		
//		$this->Cart->save($data);
//		$this->set('new', $this->Cart->id);
//		$this->set('cart', $this->Cart->fetch($this->Session));
//	}

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
		$this->set(compact('users'));
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
		$this->Cart->unbindModel(array('belongsTo' => array('User')));
		if ($this->Cart->delete()) {
			$this->Session->setFlash(__('The item was removed from your cart.'), 'f_success');
//			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('The item was not removed from cart. Please try again.'), 'f_error');
		}
		if ($this->request->is('ajax')) {
//			$this->returnAjax('flashOut');
			$this->layout = 'ajax';
			$this->newBadge();
			$this->set('cartBadge', $this->response->body());
			$this->render("/Ajax/cart_remove_result");
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function update_cart($id, $qty) {
		
	}


	/**
	 * Add to cart is in AppController so cart actions can be done anywhere
	 */
	public function addToCart() {
		parent::addToCart();
	}
	
	public function checkout() {
		$this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
		$this->set('cart', $this->Cart->fetch($this->Session, TRUE));
		$this->set('referer', $this->referer());
	}
	
}
