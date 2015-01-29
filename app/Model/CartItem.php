<?php
App::uses('AppModel', 'Model');
App::uses('OrderItem', 'Model');
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
class CartItem extends OrderItem {
	
	public $useTable = 'order_items';

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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'counterCache' => 'wish_item_count',
			'counterScope' => "CartItem.state='Wish'", // this is the one that made it work for send-to-wishlist
			'fields' => '',
			'order' => ''
		),
		'Cart' => array(
			'className' => 'Cart',
			'foreignKey' => 'order_id',
			'counterCache' => 'order_item_count',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	public $hasOne = array(
		'Supplement' => array(
			'className' => 'Supplement',
			'foreignKey' => 'order_item_id',
			'dependent' => TRUE,
			'conditions' => 'Supplement.type = \'POST\'',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $virtualFields = array(
		'total' => 'CartItem.price * CartItem.quantity'
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
		$this->deleteIdCache($this->Cart->cartId(), $this->dataCacheConfig);
		$this->unbindModel(array('hasOne' => array('Supplement')));
		$this->updateCounterCache();

	}
	
	/**
	 * Cart deletions invalidate cart cache data. Delete them.
	 * 
	 * @param boolean $cascade
	 */
	public function beforeDelete($cascade = true) {
		parent::beforeDelete($cascade);
		$this->deleteIdCache($this->Cart->cartId(), $this->dataCacheConfig);
	}
	
	/**
	 * Get the indicated cart item
	 * 
	 * @param string $id id of the item to retrieve
	 * @return array
	 */
	public function retrieve($id) {
		try {
			return $this->find('first', array('conditions' => array('CartItem.id' => $id)));
		} catch (Exception $exc) {
			echo $exc->getTraceAsString();
		}
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
	public function cartSubtotal() {
		$this->data = $this->find('all', array(
			'conditions' => array('order_id' => $this->Cart->cartId()),
			'fields' => array(
				'SUM(price * quantity) AS subtotal'
			),
			'contain' => FALSE));
		return $this->data[0][0]['subtotal'];
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
		return array('CartItem' => array(
			'id' => $id,
			'total' => $total
		));
	}
	
	/**
	 * Move a cart item to the user's wish list
	 * 
	 * The 
	 * 
	 * @param string $id
	 * @return boolean
	 */
	public function wish($id) {
		$this->id = $id;
		$item_type = $this->field('type');
		return $this->saveAssociated(array(
			'CartItem' => array(
				'id' => $id,
				'order_id' => NULL,
				'state' => 'Wish',
				'type' => 'WishList'
			),
			'Supplement' => array(
				'type' => 'product_type',
				'data' => $item_type
			)
		));
	}


	/**
	 * Convert Items into an item array for paypal express checkout
	 * 
	 * DEPRECATED
	 * This is getting rewritten to the CartToolKitPP 
	 * where it will be a collaboration with the 
	 * $cart['toolkit'] object, Lib/CartToolKit
	 * 
	 * @return array
	 */
//	public function paypalClassicNvp() {
//		$cartId = $this->Cart->cartId();
//		$items = $this->find('all', array(
//			'conditions' => array('CartItem.order_id' => $cartId),
//			'contain' => false,
//		));
//		$nvp = array();
//		foreach ($items as $item) {
//			$nvp[] = array(
//				'name' => $item['CartItem']['product_name'],
////				'description' => $item['CartItem']['product_name'],
////				'tax' => $this->someTaxCalculator(),
//				'subtotal' => $item['CartItem']['price'],
//				'qty' => $item['CartItem']['quantity']
//			);
//		}
//		return $nvp;
//	}
}
