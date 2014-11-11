<?php
App::uses('AppController', 'Controller');
App::uses('OrderItemsController', 'Controller');
/**
 * Carts Controller
 *
 * @property Cart $Cart
 */
class CartItemsController extends AppController {
	
	public $helpers = array('PurchasedProduct');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CartItem->recursive = 0;
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
		if (!$this->CartItem->exists($id)) {
			dmDebug::ddd('this', 'this');
			throw new NotFoundException(__('Invalid cart'));
		}
		$options = array('conditions' => array('Cart.' . $this->CartItem->primaryKey => $id));
		$this->set('cart', $this->CartItem->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cart->create();
			if ($this->CartItem->save($this->request->data)) {
				$this->Session->setFlash(__('The cart has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart could not be saved. Please, try again.'));
			}
		}
		$users = $this->CartItem->User->find('list');
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
//				'product_name' => $this->request->data[$key]['description'],
//				'price' => rand(100, 300)
//			)
//		);
//		
//		$this->CartItem->save($data);
//		$this->set('new', $this->CartItem->id);
//		$this->set('cart', $this->CartItem->fetch($this->Session));
//	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CartItem->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CartItem->save($this->request->data)) {
				$this->Session->setFlash(__('The cart has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cart could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cart.' . $this->CartItem->primaryKey => $id));
			$this->request->data = $this->CartItem->find('first', $options);
		}
		$users = $this->CartItem->User->find('list');
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
		$this->CartItem->id = $id;
		if (!$this->CartItem->exists()) {
			throw new NotFoundException(__('Cart Item does not exist'));
		}
		$this->request->onlyAllow('post', 'delete');
		$this->CartItem->unbindModel(array('belongsTo' => array('User')));
		if ($this->CartItem->delete()) {
			$this->Session->setFlash(__('The item was removed from your cart.'), 'f_success');
//			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('The item was not removed from cart. Please try again.'), 'f_error');
		}
		if ($this->request->is('ajax')) {
			$this->layout = 'ajax';
			$this->newBadge();
			$this->set('cartSubtotal', $this->CartItem->cartSubtotal($this->Session));
			$this->render("/Ajax/cart_remove_result");
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}
	
	/**
	 * Ajax process to change the quantity for a cart item
	 * 
	 * @param string $id
	 * @param string $qty
	 * @throws NotFoundException
	 */
	public function update_cart($id = NULL, $qty = NULL) {
		if (!$this->CartItem->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$this->layout = 'ajax';
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->CartItem->data = $this->CartItem->retrieve($id);
			$this->CartItem->data['CartItem']['quantity'] = $qty;
			
			if ($this->CartItem->save($this->CartItem->data)) {
				// needs to return the item subtotal and the cart subtotal
				$this->set('itemTotal', $this->CartItem->itemTotal($id));
				$this->set('cartSubtotal', $this->CartItem->cartSubtotal());
			} else {
				$this->Session->setFlash(__('The change could not be saved. Please, try again.'));
			}
		}
		$this->render('update_cart');
	}


	/**
	 * Add to cart is in AppController so cart actions can be done anywhere
	 * 
	 * This seems flaky since it just loops over to PurchasesComponent->add() ============================================================= Sort me out!
	 */
//	public function addToCart() {
//		parent::addToCart();
//	}
	
	public function cancel() {
		dmDebug::ddd($this->request->data, 'response');
		dmDebug::ddd($this->request, 'request');
		die;
	}


}
