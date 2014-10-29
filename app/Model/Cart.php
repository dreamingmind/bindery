<?php
App::uses('AppModel', 'Model');
App::uses('Hash', 'Utilities');
/**
 * Cart Model
 * 
 * CART-VISITOR LINKING
 * ===================================================
 * Shopping cart are stored on either the session id or the user id 
 * depending on the logged in state of the user. AppController is managing 
 * the association of the cart items as the user's state changes. But Cart Model 
 * is playing a supporting role by taking care of the actual data changes in the table.
 * 
 * CART CACHING
 * ===================================================
 * Cart model is also using caches to reduce overhead. There should be no coupling 
 * of the cache outside this class. So just set the configs in bootstrap and you're good.
 * 
 * CART TABLE STRUCTURE
 * ===================================================
 * Specific field references are kept to a minimum to allow maximum flexibility in Cart 
 * table structure. The required fields are:
 *   - id
 *   - user_id
 *   - session_id
 * No assumptions are made about their values. 
 * 
 * CART ASSOCIATIONS
 * ===================================================
 * this->load assumes there is a belongsTo and hasMany property 
 * and in some circumstances uses these to contain associated data
 * 
 * DEPENDENCIES
 * ===================================================
 * Hash
 *
 * @property User $User
 * @property Session $Session
 * @property Supplement $Supplement
 */
class Cart extends AppModel {
	
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
	public $hasMany = array(
		'Supplement' => array(
			'className' => 'Supplement',
			'foreignKey' => 'cart_id',
			'dependent' => TRUE,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $virtualFields = array(
		'total' => 'Cart.price * Cart.quantity'
	);


	/**
	 * After save the validity of the carts cache data is uncertain. Delete them
	 * 
	 * After some simple saves, neither the Session nor ansufficient data array 
	 * may be present. It this happens, try using fetchItem() to beef up 
	 * $this->data and get this back on track. But if $this->data has either 
	 * [Cart][user_id] or [Cart][session_id] it should be ok.
	 * 
	 * 
	 * @param boolean $created
	 */
	public function afterSave($created) {
		parent::afterSave($created);
		$this->clearCache($this->data);
	}
	
	/**
	 * Cart deletions invalidate cart cache data. Delete them.
	 * 
	 * @param boolean $cascade
	 */
	public function beforeDelete($cascade = true) {
		parent::beforeDelete($cascade);
		$tmp = $this->find('first', array(
			'conditions' => array(
				'id' => $this->id
			),
			'fields' => array('user_id', 'session_id')
		));
		$this->clearCache($tmp);
	}
	
	/**
	 * Clear all cart caches
	 * 
	 * @param array $data
	 */
	private function clearCache($data) {
		Cache::delete($this->cacheName($this->cacheData, $data), $this->dataCacheConfig);
		Cache::delete($this->cacheName($this->cacheDeepData, $data), $this->dataCacheConfig);
		Cache::delete($this->cacheName($this->cacheCount, $data), $this->countCacheConfig);
	}
		
	/**
	 * Does the logged in or anonomous user have a cart 
	 * 
	 * @param $Session Component or Helper
	 * @return boolean
	 */
	public function cartExists($Session) {
		if (empty($this->count($Session))) {
			return FALSE;
		} else {
			return TRUE;
		}
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
		$items = $this->load($Session, $oldSession);
		
		if (!empty($items)) {
//			dmDebug::logVars($items, 'items to transform');
	//		dmDebug::logVars($this->getLastQuery(), 'Cart->maintain find query for $userId='.$userId);
			if (is_null($userId)) {
				$i = Hash::insert($items, '{n}.Cart.session_id', $Session->id());
				$items = Hash::insert($i, '{n}.Cart.user_id', '');
			} else {
				$i = Hash::insert($items, '{n}.Cart.session_id', '');
				$items = Hash::insert($i, '{n}.Cart.user_id', $userId);
			}
//			dmDebug::logVars($items, 'items to save');
			$this->saveMany($items);
		}
	}
	
	/**
	 * Common logic to get the current visitor's cart items
	 * 
	 * this->maintenance puts the old session id from the cookie in 
	 * session id to get the user's last session
	 * 
	 * @param object $Session Component or Helper
	 * @param string $sessionId The session id if the current session is not wanted
	 * @param boolean $deep Contain related data or not
	 * @return array {n}.Cart.field
	 */
	private function load($Session, $sessionId = FALSE, $deep = FALSE) {

		// prepare all the conditional parameters
		// -----------------------------------------------
		$userId = $Session->read('Auth.User.id');
		if (!$sessionId) {
			$sessionId = $Session->id();
		}
		if ($deep) {
			$contain = array_keys(array_merge($this->belongsTo, $this->hasMany));
			$cacheName = $this->cacheName($this->cacheDeepData, $Session);
		} else {
			$contain = FALSE;
			$cacheName = $this->cacheName($this->cacheData, $Session);
		}
		// ---------------------------------------------
		
		// do the actual query in two parts
		// if necessary due to expired cache
		// -----------------------------------------------
		if (!$items = Cache::read($cacheName, $this->dataCacheConfig)) {
			$itemsAnon = $this->find('all', array(
				'conditions' => array(
					'session_id' => $sessionId,
					'user_id' => ''
				),
				'contain' => $contain
			));
//		dmDebug::ddd($this->getLastQuery(), 'anon find query for $userId='.$userId);

			$itemsUser = array();
			if (!is_null($userId)) {
				$itemsUser = $this->find('all', array(
					'conditions' => array(
						'user_id' => $userId,
						'OR' => array('session_id' => '', 'session_id IS NULL')
									),
					'contain' => $contain
				));
//			dmDebug::ddd($this->getLastQuery(), 'user find query for $userId='.$userId);
			}
			$items = array_merge($itemsAnon, $itemsUser);
			Cache::write($cacheName, $items, $this->dataCacheConfig);
			Cache::write($this->cacheName($this->cacheCount, $Session), count($items), $this->countCacheConfig);
			// -----------------------------------------------
		}		
//		dmDebug::ddd($items, 'items');
		
		return $items;
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
			
			if (empty($keySource['Cart']['user_id'])) {
					$name =  "$name.S{$keySource['Cart']['session_id']}";
			} else {
				$name =  "$name.U{$keySource['Cart']['user_id']}";
			}
		}
		return $name;
	}

	/**
	 * Fetch the count of items in the cart
	 * 
	 * @param object $Session
	 * @return int
	 */
	public function count($Session) {
		$cacheName = $this->cacheName($this->cacheCount, $Session);
		if(!$count = Cache::read($cacheName, $this->dataCacheConfig)){
			$count = count($this->load($Session));
		}
		return $count;
	}
	
	/**
	 * Get the data for the cart belonging to this Session
	 * 
	 * @param object $Session Component or Helper
	 * @param boolean $deep Contain associated data or not
	 * @return type
	 */
	
	public function fetch($Session, $deep = FALSE) {
		return $this->load($Session, FALSE, $deep);
	}
	
	/**
	 * Retrieve a single item (don't cache)
	 * 
	 * Among other uses, this can help make afterSave cache destruction 
	 * operate properly. It's easy to not have the Session available after a 
	 * save, and possibly, not even sufficient data to identify which 
	 * caches to clear. Getting this full record can fix this problem.
	 * 
	 * @param string $id
	 * @param boolean $deep
	 * @return array
	 */
	public function fetchItem($id, $deep = FALSE) {
		if ($deep) {
			$contain = array_keys(array_merge($this->belongsTo, $this->hasMany));
		} else {
			$contain = FALSE;
		}
		return $this->find('first', array(
			'conditions' => array(
				'Cart.id' => $id
			),
			'contain' => $contain
		));
	}

	/**
	 * Remove all the cart items for this user/session
	 * 
	 * @todo What kind of error trapping do we need here?
	 *		Possibly, we could just go, and if a second 'load'
	 *		is non-empty, we can set an alternate flash message?
	 * @param object $Session Component or Helper
	 */
	public function clear($Session) {
		
		$items = $this->load($Session);
		
		if (!empty($items)) {
			foreach ($items as $item) {
				$this->delete($id);
			}
		}
		$this->Session->setFlash('Your cart is empty.');
	}
	
	/**
	 * Calculate and return the subtotal of items in a cart
	 * 
	 * @param object $Session
	 * @return float
	 */
	public function cartSubtotal($Session) {
		$this->data = $this->load($Session);
		$subtotal = 0;
		foreach ($this->data as $item) {
			$subtotal += $item['Cart']['total'];
		}
		return $subtotal;
	}
	
	/**
	 * Return the price * quantity of a single cart item
	 * 
	 * @param string $id
	 * @return float
	 */
	public function itemTotal($id) {
		$this->id = $id;
		$total = $this->field('total');
		return array('Cart' => array(
			'id' => $id,
			'total' => $total
		));
	}
}
