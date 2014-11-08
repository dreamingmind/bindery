<?php
App::uses('AppModel', 'Model');
App::uses('Order', 'Model');
/**
 * Order Model
 *
 * @property User $User
 * @property Collection $Collection
 * @property OrderItem $OrderItem
 */
class Cart extends Order {

	public $useTable = 'orders';
	
	public $Session;
	
	/**
	 * Base name for cart data cache
	 * 
	 * Will have a key value appended to make it specific to a single cart
	 *
	 * @var string 
	 */
	private $cacheData = 'cart';
	
	/**
	 * Base name for cart and associated data cache
	 * 
	 * Will have a key value appended to make it specific to a single cart
	 *
	 * @var string 
	 */
	private $cacheDeepData = 'cart-assoc';
	
	/**
	 * Base name for cart's item-count cache
	 * 
	 * Will have a key value appended to make it specific to a single cart
	 *
	 * @var string 
	 */
	private $cacheCount = 'cart-count';

	/**
	 * Name of the Cache config responsible for cart data storage
	 *
	 * @var string 
	 */
	private $dataCacheConfig = 'cart';

	/**
	 * Name of the Cache config responsible for cart item-coun storage
	 *
	 * @var string 
	 */
	private $countCacheConfig = 'cart-count';

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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		)
	);
	
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
		try {
			if (!$this->cartExists()) {
				$userId = $Session->read('Auth.User.id');
				if (is_null($userId)) {
					$this->data = array(
						'session_id' => $Session->id(), 
						'state' => 'Cart'
					);
				} else {
					$this->data = array(
						'user_id' => $user_id,
						'phone' => $Session->read('Auth.User.phone'),
						'email' => $Session->read('Auth.User.email'),
						'name' => $Session->read('Auth.User.name'),
						'state' => 'Cart'
					);
				}
				$this->create($this->data);
				$this->save();
			}
//			$cacheName = $this->cacheName($this->cacheData, $Session);
			return $this->find('first', array('conditions' => $this->cartConditions(), 'contain' => array('CartItem')));
		} catch (Exception $exc) {
			echo $exc->getFile() . ' Line: ' . $exc->getLine();
			echo $exc->getMessage();
			echo $exc->getTraceAsString();
		}
	}
	
	/**
	 * Looking at current session, decide whether to look for Cart on session_id or user_id
	 * 
	 * @param SessionComponent $Session
	 * @return array The conditions that will find the user's cart if it exists
	 */
	private function cartConditions() {
		$userId = $this->Session->read('Auth.User.id');
		if (is_null($userId)) {
			$id_type = 'user_id';
			$id = $userId;
		} else {
			$id_type = 'user_id';
			$id = $this->Session->id();
		}
		return array(
			"Cart.$id_type" => $id, 
			'OR' => array (
				'Cart.state' => CART_STATE,
				'Cart.state' => CHECKOUT_STATE_STATE
			));
	}

	/**
	 * Keep the Cart attached to the User
	 * 
	 * This is only called if:
	 * Either the session stored in the users cookie does not match the 
	 * current session, or the user just logged in (which changes the session). 
	 * Move the cart to the new session or to the user as needed. 
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
				
				// move anonymous items onto the user cart
				Hash::insert($anonymousCart, 'CartItem.{n}.order_id', $cartUser['Cart']['id']);
				// merge the items into a single array
				$userCart['CartItem'] = array_merge($anonymousCart['CartItem'], $anonymousCart['CartItem']);
				// delete the anonymous heaader record now leaving its items behind for later update
				$this->delete($anonymousCart['id'], FALSE);
				$cart = $cartUser;
				
			} else {
				// move the existing anonymous cart to the new anonymous session
				Hash::insert($anonymousCart, 'Cart.id', $this->Session->id());
				$cart = $anonymousCart;
			}

			$this->saveAssociated($cart);
		} else {
			// there wasn't any cart or there was only a user cart which we just left alone
		}
	
	}

	/**
	 * example of how caching was done
	 * 
	 */
	private function loadx($Session, $sessionId = FALSE, $deep = FALSE) {

		if (!$cart = Cache::read($cacheName, $this->dataCacheConfig)) {
//			dmDebug::ddd($cart, 'cart');
			if (!empty($cart)) {
				Cache::write($cacheName, $cart, $this->dataCacheConfig);
				Cache::write($this->cacheName($this->cacheCount, $Session), count($cart['Cart']['order_item_count']), $this->countCacheConfig);
			}			
		}		
		return $cart;
	}
	
	/**
	 * Get a cart on a specific key
	 * 
	 * @param string $id id key value to search for
	 * @param string $id_type user_id or session_id (id key to search on)
	 * @param boolean $deep set containment level
	 * @return array
	 */
	private function fetchCart($id, $id_type = 'user_id', $deep = FALSE) {
		$conditions =  array(
			"Cart.$id_type" => $id, 
			'OR' => array (
				'Cart.state' => CART_STATE,
				'Cart.state' => CHECKOUT_STATE
			));
		if ($deep) {
			$contain =  array('User', 'CartItem' => array('Session'));
			$cacheName = $this->cacheName($this->cacheDeepData);
		} else {
			$contain = array('CartItem');
			$cacheName = $this->cacheName($this->cacheData);
		}
		try {
			$cart = $this->find('first', array('conditions' => $conditions, 'contain' => $contain));
		} catch (Exception $exc) {
			echo $exc->getFile() . ' Line: ' . $exc->getLine();
			echo $exc->getMessage();
			echo $exc->getTraceAsString();
		}
		return $cart;
	}

	/**
	 * Add the correct key values to the cache name
	 * 
	 * @param string $name One of the cache-name properties
	 */
	private function cacheName($name) {
			
		$userId = $this->Session->read('Auth.User.id');

		if (is_null($userId)) {
			$name =  "$name.S{$this->Session->id()}";
		} else {
			$name =  "$name.U{$userId}";
		}

		return $name;
	}
}
