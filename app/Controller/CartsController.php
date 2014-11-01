<?php
App::uses('AppController', 'Controller');
/**
 * Carts Controller
 *
 * @property Cart $Cart
 */
class CartsController extends AppController {
	
	public $helpers = array('PurchasedProduct');
	
	public $components = array('PayPal');


	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'view', 'add', 'edit', 'addToCart', 'delete', 'checkout', 'update_cart', 'pay');
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
			$this->layout = 'ajax';
			$this->newBadge();
			$this->set('cartSubtotal', $this->Cart->cartSubtotal($this->Session));
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
		if (!$this->Cart->exists($id)) {
			throw new NotFoundException(__('Invalid cart'));
		}
		$this->layout = 'ajax';
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Cart->data = $this->Cart->fetchItem($id);
			$this->Cart->data['Cart']['quantity'] = $qty;
			
			if ($this->Cart->save($this->Cart->data)) {
				// needs to return the item subtotal and the cart subtotal
				$this->set('itemTotal', $this->Cart->itemTotal($id));
				$this->set('cartSubtotal', $this->Cart->cartSubtotal($this->Session));
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
	public function addToCart() {
		parent::addToCart();
	}
	
	/**
	 * Transfer to the first 'checkout' process page
	 */
	public function checkout() {
		$this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
		$this->set('cart', $this->Cart->fetch($this->Session, TRUE));
		$this->set('referer', $this->referer());
	}
	
	public function pay($method) {
		switch ($method) {
			case 'paypal':
				$form = 
				'<form style="display: none;"
				action="https://www.paypal.com/cgi-bin/webscr" 
				method="post"> 
					<input type="hidden" name="add" value="1"> 
					<input type="hidden" name="cmd" value="_cart">
					<input type="hidden" name="business" value="ddrake@dreamingmind.com">
					<input type="hidden" name="item_name" value="Limited Edition">
					<input type="hidden" name="item_number" value="Jabberwocky">
					<input type="hidden" name="amount" value="35">
					<input type="hidden" name="return" value="http://localhost/bindery2.0/carts/paypal_ipn/return"> 
					<input type="hidden" name="cancel_return" value="http://localhost/bindery2.0/carts/paypal_ipn/cancel"> 
					<input type="hidden" name="bn" value="PP-ShopCartBF"> 
					<input id="doBuy" type="image" 
						src="gal_nav_images/tinyaddcart.jpg" 
						border="0" name="submit" 
						alt="Add to Cart">
				Jabberwocky, $35
				</form>' ;
//				$post = array(
//					'add' => '1', 
//					'cmd' => '_cart',
//					'business' => 'ddrake@dreamingmind.com',
//					'item_name' => 'Limited Edition',
//					'item_number' => 'Jabberwocky',
//					'amount' => '35',
//					'return' => 'http://dreamingmind.com/index.php', 
//					'cancel_return' => 'http://dreamingmind.com/index.php',
//					'bn' => 'PP-ShopCartBF'
//				);
//				$Http = new HttpSocket();
//				$Http->post("https://www.sandbox.paypal.com/cgi-bin/webscr", $post);
				echo $form;
				exit();
		}
	}
	
	public function paypal_ipn($process) {
		debug($process);
		debug($this->request);
		debug($this->PayPal);
		debug($this->response);
		die;
	}
}
