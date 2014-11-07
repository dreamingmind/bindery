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
	 * Does the user have a Cart?
	 * 
	 * @param Session $Session
	 * @return boolean
	 */
	public function cartExists(Session $Session) {
		$cart = $this->find('first', array('conditions' => $this->cartConditions($Session)));
		return !empty($cart);
	}

	/**
	 * How many items are in the user's cart? may be zero
	 * 
	 * @param Session $Session
	 * @return int
	 */
	public function count(SessionComponent $Session) {
		return $this->field('Cart.order_item_count', $this->cartConditions($Session));
	}
	
	public function cartId(SessionComponent $Session) {
		return $this->field('Cart.id', $this->cartConditions($Session));
	}
	
	/**
	 * Create a new anonymous or user Cart record and return the id
	 * 
	 * @param SessionComponent $Session
	 * @return int The id of the new Cart record
	 */
	public function newCart(SessionComponent $Session) {
		$userId = $Session->read('Auth.User.id');
		$sessionId = $Session->id();
		if (is_null($userId)) {
			$this->data = array(
				'session_id' => $session_id, 
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
		return $this->id;
	}
	
	/**
	 * Looking at current session, decide whether to look for Cart on session_id or user_id
	 * 
	 * @param SessionComponent $Session
	 * @return array The conditions that will find the user's cart if it exists
	 */
	private function cartConditions(SessionComponent $Session) {
		$userId = $Session->read('Auth.User.id');
		$sessionId = $Session->id();
		if (is_null($userId)) {
			$conditions = array('Cart.session_id' => $sessionId);
		} else {
			$conditions = array('Cart.user_id' => $userId);
		}
		return $conditions;
	}

	/**
	 * Keep the Cart attached to the User
	 * 
	 * As the User navigates the site, the Session id may change 
	 * and their logged in status may change. Carts may be attached to 
	 * the Session or the User. This method will keep the proper 
	 * Cart items associated with the User as the site State changes
	 * https://github.com/dreamingmind/bindery/wiki/Shopping-Cart
	 * 
	 * @param object $Session Component or Helper
	 */
	public function maintain($Session, $oldSession) {
		
		$userId = $Session->read('Auth.User.id');
		$cart = $this->load($Session, $oldSession);
		
		if (!empty($cart)) {
//			dmDebug::logVars($items, 'items to transform');
	//		dmDebug::logVars($this->getLastQuery(), 'Cart->maintain find query for $userId='.$userId);
			if (is_null($userId)) {
				$i = Hash::insert($cart, 'Cart.session_id', $Session->id());
				$cart = Hash::insert($i, 'Cart.user_id', '');
			} else {
				$i = Hash::insert($cart, 'Cart.session_id', '');
				$cart = Hash::insert($i, 'Cart.user_id', $userId);
			}
//			dmDebug::logVars($items, 'items to save');
			$this->saveMany($cart);
		}
	}

	/**
	 * Common logic to get the current visitor's cart and items
	 * 
	 * this->maintenance puts the old session id from the cookie in 
	 * session id to get the user's last session otherwise the 
	 * current session will be the default. A search will also be 
	 * done for a cart on the user_id (possibly this user just logged 
	 * back in). All found items will be merged into a single cart 
	 * and the spare Cart record will be dumped. 
	 * 
	 * @param object $Session Component or Helper
	 * @param string $sessionId The session id if the current session is not wanted
	 * @param boolean $deep Contain related data or not
	 * @return array {n}.CartItem.field
	 */
	private function load($Session, $sessionId = FALSE, $deep = FALSE) {

		// prepare all the conditional parameters
		// -----------------------------------------------
		$userId = $Session->read('Auth.User.id');
		if (!$sessionId) {
			$sessionId = $Session->id();
		}
		if ($deep) {
			$contain =  array('User', 'CartItem' => array('Session'));
			$cacheName = $this->cacheName($this->cacheDeepData, $Session);
		} else {
			$contain = array('CartItem');
			$cacheName = $this->cacheName($this->cacheData, $Session);
		}
		// ---------------------------------------------
		
		// if the cache is expired do the actual query in two parts.
		// Its possible the user has been making a cart,  
		// and now has just logged back in, gaining access to an earlier 
		// cart they had been accumulating. Every thing must be gathered 
		// and merged together in a single cart. One Cart record must die.
		// -----------------------------------------------
		if (!$cart = Cache::read($cacheName, $this->dataCacheConfig)) {
			$cartAnon = $this->find('first', array(
				'conditions' => array(
					'Cart.session_id' => $sessionId,
					'Cart.user_id' => ''
				),
				'contain' => $contain
			));
//		dmDebug::ddd($this->getLastQuery(), 'anon find query for $userId='.$userId);

			$cartUser = array();
			if (!is_null($userId)) {
				$cartUser = $this->find('first', array(
					'conditions' => array(
						'Cart.user_id' => $userId,
						'OR' => array('Cart.session_id' => '', 'Cart.session_id IS NULL')
									),
					'contain' => $contain
				));
//			dmDebug::ddd($this->getLastQuery(), 'user find query for $userId='.$userId);
			}
			
			if (!empty($cartAnon) && !empty($cartUser)) {
				// move anonymous items onto the user cart
				Hash::insert($cartAnon, 'CartItem.{n}.order_id', $cartUser['Cart']['id']);
				// merge the items into a single array
				$cartUser['CartItem'] = array_merge($cartAnon['CartItem'], $cartUser['CartItem']);
				// only login will cause this rare event and in that case we'll be in the midst 
				// of maintenance(). So we can leave the save of CartItems to that method.
				
				// delete the anonymous heaader record now leaving its items behind for later update
				$this->delete($cartAnon['id'], FALSE);
				$cart = $cartUser;
			} else {
				// one of them is empty. don't know which
				$cart = array_merge($cartAnon, $cartUser);
			}
//			dmDebug::ddd($cart, 'cart');
			if (!empty($cart)) {
				Cache::write($cacheName, $cart, $this->dataCacheConfig);
				Cache::write($this->cacheName($this->cacheCount, $Session), count($cart['Cart']['order_item_count']), $this->countCacheConfig);
			}			
			// -----------------------------------------------
		}		
//		dmDebug::ddd($items, 'items');
		
		return $cart;
	}
	
	/**
	 * Add the correct key values to the cache name
	 * 
	 * During afterSave, neither the Session nor ansufficient data array 
	 * may be present. It this happens, try using fetchItem to beef up 
	 * $this->data and get this back on track.
	 * 
	 * @param string $name One of the cache-name properties
	 * @param object|array $keySource Component or Helper | data array
	 */
	private function cacheName($name, $keySource) {
		if (is_object($keySource)){
			
			$userId = $keySource->read('Auth.User.id');
			
			if (is_null($userId)) {
				$name =  "$name.S{$keySource->id()}";
			} else {
				$name =  "$name.U{$userId}";
			}
		} else {
			
			if (empty($keySource['CartItem']['CartItem.user_id'])) {
					$name =  "$name.S{$keySource['CartItem']['CartItem.session_id']}";
			} else {
				$name =  "$name.U{$keySource['CartItem']['CartItem.user_id']}";
			}
		}
		return $name;
	}
}
