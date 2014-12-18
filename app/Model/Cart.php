<?php
App::uses('AppModel', 'Model');
App::uses('Order', 'Model');
/**
 * Cart Model manages orders table records to act as cart header records
 * 
 * Some external process must send the Session in. 
 * PurchasesComponent can do this job.
 * 
 * Provides access to cart existance, count, id, and the cart itself 
 * as well as manintain attachement of the cart to the visitor/user. 
 * 
 * @todo Write cache usage patterns
 * @property User $User
 * @property Collection $Collection
 * @property OrderItem $OrderItem
 */
class Cart extends Order {

	public $useTable = 'orders';
	
	/**
	 * Session component
	 * 
	 * Must be sent in by some controller or component since models can't 
	 * normal access this class. PurchasesComponent->startup() is doing the job.
	 *
	 * @var object SessionComponent
	 */
	public $Session;
	
	/**
	 * Base name for cart data cache
	 * 
	 * Will have a key value appended to make it specific to a single cart
	 *
	 * @var string 
	 */
	protected $dataCache = 'cart';
	
	/**
	 * Name of the Cache config responsible for cart data storage
	 *
	 * @var string 
	 */
	protected $dataCacheConfig = 'cart';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Shipping' => array(
			'className' => 'AddressModule.Address',
			'foreignKey' => 'ship_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Billing' => array(
			'className' => 'AddressModule.Address',
			'foreignKey' => 'bill_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CartItem' => array(
			'className' => 'CartItem',
			'foreignKey' => 'order_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Payment' => array (
			'className' => 'Payment',
			'foreignKey' => 'order_id',
			'dependent' => true,
		)
	);
	
	public function afterSave($created) {
		parent::afterSave($created);
		$this->deleteIdCache($this->cartId(), $this->dataCacheConfig);
	}


	/**
	 * Does the visitor/user have a Cart?
	 * 
	 * @return boolean
	 */
	public function cartExists() {
		$cart = $this->find('first', array('conditions' => $this->cartConditions(), 'contain' => FALSE));
		return !empty($cart);
	}

	/**
	 * How many items are in the visitor/user's cart? may be zero
	 * 
	 * @return int
	 */
	public function count() {
		return $this->field('Cart.order_item_count', $this->cartConditions());
	}
	
	/**
	 * Return the id of the visitor/user's cart
	 * 
	 * @return null|string
	 */
	public function cartId() {
		return $this->field('Cart.id', $this->cartConditions());
	}
	
	/**
	 * Retrieve the visitor/user's cart or create one
	 * 
	 * @param SessionComponent $Session
	 * @return int The id of the new Cart record
	 */
	public function retrieve() {
		$conditions = $this->cartConditions();
		try {
			if ($this->readIdCache($this->cartId())) {
				return $this->cachedData;
			}
			if (!$this->cartExists()) {
				
				$userId = $this->Session->read('Auth.User.id');
				if (is_null($userId)) {
					$this->data = array(
						'session_id' => $this->Session->id(), 
						'state' => 'Cart'
					);
				} else {
					$this->data = $this->makeUserCartData(array());
					$this->data['state'] = 'Cart';
				}
				$this->create($this->data);
//				dmDebug::ddd($this->data, 'this data just saved');
				$this->save($this->data);
//				dmDebug::ddd($this->validationErrors, 'errors');
			}
//			dmDebug::ddd($this->Session->id(), 'session id');
			
//			$cacheName = $this->cacheName($this->cacheData, $Session);
			$cart = $this->find('first', array(
				'conditions' => $this->cartConditions(), 
				'contain' => array(
					'CartItem' => array(
						'Supplement' => array(
							'fields' => array('Supplement.id', 'Supplement.order_item_id', 'Supplement.type', 'Supplement.data')
						)
					))));
			
			foreach ($cart['CartItem'] as $index => $item) {
				if (isset($cart['CartItem'][$index]['Supplement']['data'])) {
					$cart['CartItem'][$index]['Supplement']['data'] = unserialize($cart['CartItem'][$index]['Supplement']['data']);
				}
			}
			$this->writeIdCache($cart['Cart']['id'], $cart);
			return $cart;
		} catch (Exception $exc) {
			echo $exc->getFile() . ' Line: ' . $exc->getLine();
			echo $exc->getMessage();
			echo $exc->getTraceAsString();
		}
	}
	
	public function getContactData() {
		return $this->find('first', array(
			'fields' => array('id', 'name', 'email', 'phone'),
			'conditions' => $this->cartConditions(),
			'contain' => FALSE
		));
	}


	/**
	 * Set all known user data point in a new or evolving Cart record
	 * 
	 * If a new Cart is made for a logged in User, or an anonymous 
	 * user logs in with a cart, many pieces of User data become 
	 * available for the Cart record. Move them in, including default 
	 * Billing and Shipping addresses if they exist. Then return the 
	 * array for inclusion with other cart data and eventual save.
	 * 
	 * Address records are save here if they get created. Links go in the data
	 * 
	 * @param array $data The Cart data with fields at the first level
	 * @return array The Cart data with fields at the first level
	 */
	private function makeUserCartData($data){
		$userId = $this->Session->read('Auth.User.id');
		$data['user_id'] = $userId;
		$data['phone'] = $this->Session->read('Auth.User.phone');
		$data['email'] = $this->Session->read('Auth.User.email');
		$data['name'] = $this->Session->read('Auth.User.first_name') . ' ' . $this->Session->read('Auth.User.last_name');
		if ($data['name'] === ' ') {
			$data['name'] = $this->Session->read('Auth.User.username');
		}
		$data['ship_id'] = $this->Session->read('Auth.User.ship_id');
		$data['bill_id'] = $this->Session->read('Auth.User.bill_id');

		$Address = ClassRegistry::init('AddressModule.Address');

		if (!is_null($id = $this->Session->read('Auth.User.ship_id'))) {
			if (!empty($Address->duplicate($id))) {
				$addressId = $Address->data['Address']['id'];
				$data['ship_id'] = $addressId;
				$Address->link($addressId, 'User', $userId);
				$Address->type($addressId, 'shipping');
			}

		}
		if (!is_null($id = $this->Session->read('Auth.User.bill_id'))) {
			if (!empty($Address->duplicate($id))) {
				$addressId = $Address->data['Address']['id'];
				$data['bill_id'] = $addressId;
				$Address->link($addressId, 'User', $userId);
				$Address->type($addressId, 'billing');
			}
		}
		return $data;
	}
			

	/**
	 * Looking at current session, create the conditions array to look for Cart on the right key
	 * 
	 * @param SessionComponent $Session
	 * @return array The conditions that will find the user's cart if it exists
	 */
	private function cartConditions() {
		$userId = $this->Session->read('Auth.User.id');
		if (!$userId == NULL) {
			$id_type = 'user_id';
			$id = $userId;
		} else {
			$id_type = 'session_id';
			$id = $this->Session->id();
		}
		return array(
			"Cart.$id_type" => $id, 
			'OR' => array (
				array('Cart.state' => CART_STATE),
				array('Cart.state' => CHECKOUT_STATE)
			));
	}

	/**
	 * Keep the Cart attached to the User
	 * 
	 * This is only called if:
	 * Either the session stored in the users cookie does not match the 
	 * current session, or the user just logged in (which changes the session). 
	 * Move the old cart to the new session or to the user as needed. 
	 * And if the user had a previous cart, merge with this one. Oh, and 
	 * handle the fact that any of these presumed carts might not exist.
	 * 
	 * https://github.com/dreamingmind/bindery/wiki/Shopping-Cart
	 * 
	 * @param string $oldSesson The session that is dying and which might contain a cart
	 */
	public function maintain($oldSession) {
		
		$userId = $this->Session->read('Auth.User.id');
		if (!is_null($userId)) {
			$userCart = $this->fetchCart($userId, 'user_id');
		}
		$anonymousCart = $this->fetchCart($oldSession, 'session_id');
		
		if (!empty($anonymousCart)) {
			if (!empty($userCart)) {
			// both anon cart and user cart exist
				
				// move anonymous items onto the user cart
				Hash::insert($anonymousCart, 'CartItem.{n}.order_id', $userCart['Cart']['id']);
				// merge the items into a single array
				$userCart['CartItem'] = array_merge($anonymousCart['CartItem'], $anonymousCart['CartItem']);
				// delete the anonymous heaader record now leaving its items behind for later update
				$this->delete($anonymousCart['Cart']['id'], FALSE);
				$cart = $userCart;
				
			} elseif (!is_null($userId)) {
			// anon cart, no user cart, but now logged in
				$this->data = $anonymousCart; // id of the cart to modify
				$this->data['Cart'] = $this->makeUserCartData($this->data['Cart']); // add all the new user data
				$this->data['Cart']['session_id'] = NULL; // unhook from session
				$this->data = Hash::insert($this->data, 'CartItem.{n}.user_id', $userId);
				
				$cart = $this->data;
				
			} else {
			// anon cart needs to move to new anon session

				// move the existing anonymous cart to the new anonymous session
				Hash::insert($anonymousCart, 'Cart.id', $this->Session->id());
				$cart = $anonymousCart;
			}

			// new cart record created rather than move of anon cart to user
			$this->saveAssociated($cart);
		} else {
			// there wasn't any cart or there was only a user cart which we just left alone
		}
	
	}

	/**
	 * Get a cart on a specific key
	 * 
	 * During maintanance, we can't rely on agorithms to find the current 
	 * cart key. Instead we go through a pattern that retrieves old carts and 
	 * migrates them to the current key. This find lets us specify these keys
	 * 
	 * @param string $id id key value to search for
	 * @param string $id_type user_id or session_id (id key to search on)
	 * @param boolean $deep set containment level
	 * @return array
	 */
	private function fetchCart($id, $id_type = 'user_id') {
		$conditions =  array(
			"Cart.$id_type" => $id, 
			'OR' => array (
				array('Cart.state' => CART_STATE),
				array('Cart.state' => CHECKOUT_STATE)
			));
		try {
			$cart = $this->find('first', array('conditions' => $conditions, 'contain' => array('CartItem')));
		} catch (Exception $exc) {
			echo $exc->getFile() . ' Line: ' . $exc->getLine();
			echo $exc->getMessage();
			echo $exc->getTraceAsString();
		}
		return $cart;
	}
	
	public function cartSubtotal($id = NULL) {
		if (is_null($id)) {
			$id = $this->cartId();
		}
		return $this->CartItem->cartSubtotal($id);
	}
	
	public function tax() {
		return '0.00';
	}
	
	public function shipping() {
		return '0.00';
	}
	
	public function summary() {
//		$tot = $this->tax + $this->shipping() + $this->cartSubtotal();
		$i = $this->count() === 1 ? 'item' : 'items';
		return "{$this->count()} $i in your cart.";
		
	}
	
	public function state($state) {
		$this->data = array('Cart' => array(
			'Cart.id' => $this->cartId(),
			'Cart.state' => $state
		));
		$this->save($this->data);
	}
}
