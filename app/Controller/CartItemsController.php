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
	
	public $components = array('Checkout');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	
	public function afterFilter() {
		parent::afterFilter();
//		$this->removalNotification();

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
		$cart_item = $this->CartItem->retrieve($id); // data to log the event

		$this->CartItem->unbindModel(array('belongsTo' => array('User')));
		if ($this->CartItem->delete()) {
			$this->Session->setFlash(__('The item was removed from your cart.'), 'f_success');
			$this->logRemoveCartItem($cart_item);
//			$this->redirect(array('action' => 'index'));
		} else {
			$this->Session->setFlash(__('The item was not removed from cart. Please try again.'), 'f_error');
		}
		// cart_item/remove calls from cart_ui go to the Purchases component 
		// which calls here for the actual record deletion. Always an ajax sequence
		if ($this->request->is('ajax')) {
			return;
		// but regular CRUD does its usual redirect
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}
	
	/**
	 * Handle an ajax call to remove a cart item
	 * 
	 * Delegate the process to the Purchases Component and 
	 * when it's done, render the result
	 * 
	 * @param string $id
	 */
	public function remove($id) {
		$this->Purchases->remove($id);
		
		if (!$this->Purchases->exists()) {
			$this->set('url', $this->Checkout->lastItemRedirect());
			$this->Session->setFlash('Your cart is empty.', 'f_emptyCart');
			$this->set('cartSubtotal', '0');
		} else {
			$this->set('cartSubtotal', $this->CartItem->cartSubtotal($this->Session));
		}
		$this->layout = 'ajax';
		$this->render("/Ajax/cart_remove_result");
	}
	

		/**
	 * Ajax process to change the quantity for a cart item [and its supplement]
	 * 
	 * @param string $id
	 * @param string $qty
	 * @throws NotFoundException
	 */
	public function updateQuantity($id = NULL, $qty = NULL) {
		if (!$this->CartItem->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$this->layout = 'ajax';
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Purchases->updateQuantity($id, $qty)) {
				// needs to return the item subtotal and the cart subtotal
				$this->set('itemTotal', $this->CartItem->itemTotal($id));
				$this->set('cartSubtotal', $this->CartItem->cartSubtotal());
			} else {
				$this->Session->setFlash(__('The change could not be saved. Please, try again.'), 'f_error');
			}
		}
		$this->render('update_cart');
	}


	/**
	 * Add to cart is in AppController so cart actions can be done anywhere
	 * 
	 * This seems flaky since it just loops over to PurchasesComponent->add() ============================================================= Sort me out!
	 */
	
	public function cancel() {
		dmDebug::ddd($this->request->data, 'response');
		dmDebug::ddd($this->request, 'request');
		die;
	}

	/**
	 * Save an item to the cart
	 * 
	 * This will set $new to the new item's ID
	 * and $cart to the collection of items in the cart
	 * This may be hooked up in a stupid way. CartController->addToCart() calls here ==============================================================sort me out!
	 */
	public function addToCart() {
		$this->Purchases->add();
	}
	
	public function updateCart() {
//		dmDebug::ddd($this->request->data, 'trd');
		$this->Purchases->updateItem();
		$this->render('add_to_cart');
	}
	
}
