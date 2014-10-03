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
	
	private $cacheName = 'cart';

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
			'foreignKey' => 'supplement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	 * Does the logged in or anonomous user have a cart 
	 * 
	 * @param $Session Component or Helper
	 * @return boolean
	 */
	public function cartExists($Session) {
		$userId = $Session->read('Auth.User.id');
			if (is_null($userId)) {
				$cart = $this->find('first', array('conditions' => array('session_id' => $Session->id())));
			} else {
				$cart = $this->find('first', array('conditions' => array('user_id' => $userId)));
			}
			if (empty($cart)) {
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
	public function maintain(SessionComponent $Session, $oldSession) {
		
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
//			$this->cacheName = $this->cacheName . '-assoc';
		} // ---------------------------------------------
		
		// do the actual query in two parts
		// -----------------------------------------------
		$itemsAnon = $this->find('all', array(
			'conditions' => array(
				'session_id' => $sessionId,
				'user_id' => ''
			),
			'contain' => $deep
		));
//		dmDebug::logVars($this->getLastQuery(), 'anon find query for $userId='.$userId);

		$itemsUser = array();
		if (!is_null($userId)) {
			$itemsUser = $this->find('all', array(
				'conditions' => array(
					'user_id' => $userId,
					'OR' => array('session_id' => '', 'session_id IS NULL')

				),
				'contain' => $deep
			));
//			dmDebug::logVars($this->getLastQuery(), 'user find query for $userId='.$userId);
		}
		$items = array_merge($itemsAnon, $itemsUser);
		// -----------------------------------------------
		
		return $items;
	}
	
	/**
	 * Add the correct key values to the cache name
	 * 
	 * Cache is alway on the current id. If we're in the 
	 * middle of maitenance with an old session id, that 
	 * value will catch up before we're done.
	 * 
	 * @param string $name One of the cache-name properties
	 * @param object $Session Component or Helper
	 */
	private function keyedCacheName($name, $Session) {
		$userId = $Session->read('Auth.User.id');
		if (is_null($userId)) {
			$name = $name . '.S' . $Session->id();
		} else {
			$name = $name . '.U' . $userId;
		}
		return $name;
	}

	/**
	 * 
	 * 
	 * @param object $Session Component or Helper
	 * @param boolean $deep Contain associated data or not
	 * @return type
	 */
	public function fetch($Session, $deep = FALSE) {
		return $this->load($Session, FALSE, $deep);
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
	
}
