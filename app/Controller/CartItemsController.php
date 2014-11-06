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
//				'design_name' => $this->request->data[$key]['description'],
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
			$this->CartItem->data = $this->CartItem->fetchItem($id);
			$this->CartItem->data['Cart']['quantity'] = $qty;
			
			if ($this->CartItem->save($this->CartItem->data)) {
				// needs to return the item subtotal and the cart subtotal
				$this->set('itemTotal', $this->CartItem->itemTotal($id));
				$this->set('cartSubtotal', $this->CartItem->cartSubtotal($this->Session));
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
		$this->set('cart', $this->CartItem->fetch($this->Session, TRUE));
		$this->set('referer', $this->referer());
	}
	
	public function pay($method) {
		switch ($method) {
			case 'paypal':
				$data = array(
					'transaction' => array(
						'amount' => array(
							'total'    => '400',
							'currency' => 'USD'//,
//							'details'  => array(
//								'subtotal' => '',
//								'tax'      => '',
//								'shipping' => ''
//							)
						),
						'description' => 'This is the total for your cart'
					),
					'return_urls' => array( // We must set these for Paypal payments, they are required fields
						'cancel_url' => 'http://localhost/bindery2.0/carts/cancel',
						'return_url' => 'http://localhost/bindery2.0/carts/complete'
					)
				);
				$response = $this->Paypal->createPaypalPayment($data, 'sale');
//				debug($response);die;
//object(stdClass) {
//	id => 'PAY-6L8318935M590390UKRK375I'
//	status => 'created'
//	created => '2014-11-01 22:24:05'
//	modified => '2014-11-01 22:24:05'
//	payment_method => 'paypal'
//	type => 'sale'
//	payer => object(stdClass) {
//		billing_address => object(stdClass) {
//			line1 => ''
//			line2 => ''
//			city => ''
//			country_code => ''
//			postal_code => ''
//			state => ''
//		}
//		credit_card => object(stdClass) {
//			number => ''
//			type => ''
//			expire_month => ''
//			expire_year => ''
//			first_name => ''
//			last_name => ''
//		}
//		id => null
//		email => null
//	}
//	approval_url => 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-5CX17020FE758673D'
//	transaction => object(stdClass) {
//		amount => object(stdClass) {
//			total => '400.00'
//			currency => 'USD'
//			details => object(stdClass) {
//				subtotal => '400.00'
//			}
//		}
//		description => 'This is the total for your cart'
//		sale => object(stdClass) {
//			id => ''
//			parent_id => ''
//		}
//		authorization => object(stdClass) {
//			id => ''
//			created => ''
//		}
//	}
//	error => object(stdClass) {
//		code => false
//	}
//}				
				if ($response->status === 'created') {
					//$response->approval_url
//					$HTTP = new HttpSocket();
					$this->redirect($response->approval_url);
					exit();
				} else {
					exit();
				}
		}
	}
	
	public function complete() {
//		dmDebug::ddd($this->request->data, 'response');
//		dmDebug::ddd($this->request, 'request');
		$data = array(
			'payment_id' => $this->request->query['paymentId'],
			'id' => $this->request->query['PayerID'],
			'token' => $this->request->query['token']
		);
		debug($this->Paypal->executePaypalPayment($data));
//		query => array(
//		'paymentId' => 'PAY-3VD75761JB929982RKRK3IVQ',
//		'token' => 'EC-3KV968207T8081018',
//		'PayerID' => 'E53U4PCQSMGWS'
//		)
		
//		object(stdClass) {
		//	id => 'PAY-4JT180622J636930CKRK3W5Q'
		//	status => 'approved'
		//	created => '2014-11-01 22:04:54'
		//	modified => '2014-11-01 22:05:33'
		//	payment_method => 'paypal'
		//	type => 'sale'
		//	payer => object(stdClass) {
		//		billing_address => object(stdClass) {
		//			line1 => ''
		//			line2 => ''
		//			city => ''
		//			country_code => ''
		//			postal_code => ''
		//			state => ''
		//		}
		//		credit_card => object(stdClass) {
		//			number => ''
		//			type => ''
		//			expire_month => ''
		//			expire_year => ''
		//			first_name => ''
		//			last_name => ''
		//		}
		//		id => null
		//		email => 'janespratt@dreamingmind.com'
		//	}
		//	approval_url => ''
		//	transaction => object(stdClass) {
		//		amount => object(stdClass) {
		//			total => '400.00'
		//			currency => 'USD'
		//			details => object(stdClass) {
		//				subtotal => '400.00'
		//			}
		//		}
		//		description => 'This is the total for your cart'
		//		sale => object(stdClass) {
		//			id => '5FJ53383391210626'
		//			parent_id => 'PAY-4JT180622J636930CKRK3W5Q'
		//		}
		//		authorization => object(stdClass) {
		//			id => ''
		//			created => ''
		//		}
		//	}
		//	error => object(stdClass) {
		//		code => false
		//	}
		//}
		die;
	}

	public function cancel() {
		dmDebug::ddd($this->request->data, 'response');
		dmDebug::ddd($this->request, 'request');
		die;
	}


}
