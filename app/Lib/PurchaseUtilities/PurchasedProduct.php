<?php
App::uses('Material', 'Model');

/**
 * PurchasedProduct is the base class for the all product variants
 * 
 * The range of options and the way information is stored about 
 * products and services is highly variable. So one concrete implementation 
 * of this base class exists for each of the variants.
 *
 * @author dondrake
 */
abstract class PurchasedProduct {
	
	/**
	 * The form data submitted during the purchase of something
	 * 
	 * This is the submitted data for a new cart item request 
	 * and the unserialized Supplement record later when we 
	 * have a CartItem record (
	 * 
	 * @var array
	 */
	protected $data;
	
	/**
	 * The CartItem record field-level indexed
	 * 
	 * The ['CartItem'] index level will be stripped off
	 * 
	 * @var array
	 */
	protected $item;
	
	/**
	 * Id of the Supplement record attached to this->item
	 * 
	 * @var string
	 */
	protected $supplementId;
	/**
	 * The type of Product purchased
	 * 
	 * This value is stored in the Cart record and is used to determine 
	 * which Helper and Product Utility to use when operating on the item. 
	 * So if it says 'Custom' we would expect 
	 * View/Helper/PurchaseHelpers/CustomProductHelper and 
	 * Lib/PurchaseUtilities/CustomProduct to both exist.
 	 *
	 * @var string
	 */
	protected $type;
	
	/**
	 * The Session Component
	 *
	 * @var object
	 */
	protected $Session;

	/**
	 * Supplement Model
	 * 
	 * @var object
	 */
	protected $Supplement;
	
	/**
	 * The current cart
	 *
	 * @var array
	 */
	protected $cart;

	/**
	 * The current logged in User from the Session
	 *
	 * @var string|boolean A User id or FALSE
	 */
	protected $user_id = FALSE;
	
	/**
	 * The current Session id if there is no logged in user
	 *
	 * @var string|boolean The current session id or FALSE
	 */
	protected $sessionId = FALSE;
	
	/**
	 * The price lookup table from quickbooks Item List iff export
	 * 
	 * The list will have the full NAME as key and PRICE as value
	 *
	 * @var array
	 */
	protected $qbPrices;
	
	/**
	 * The price lookup table from quickbooks Item List iff export
	 * 
	 * The list will have the product code as key and PRICE as value
	 *
	 * @var array
	 */
	protected $qbCodePrices;


	/**
	 * Set properties for the concrete classes
	 * 
	 * Construct is suffering growing pains.
	 * First phase it recieved one data array,  the newly submitted specifications 
	 * for a product. There is no CartItem record, Supplement record or IDs for eiter
	 * Second phase, I needed to construct from the CartItem record and its Supplement 
	 * record, but the raw data array seen in First phase didn't exist.
	 * Third phase, arrive after an edit process. Now we have the spec'd data array again 
	 * and also have CartItem, Supplement and their IDs. This third case is not accounted 
	 * for in construct at all. It's finessed in the PurchasesComponent->updateItem().
	 * 
	 * ======== I've REM'd all references to these for testing. Looks ok so far =====================
	 * Also, I'm not sure Session is needed anymore! It's used in two places to aid in 
	 * maintaing cart ownership. Possibly there is a better way to handle this? Because 
	 * Cart ownership is a Cart record need and this class has to do with CartItem handling?
	 * 
	 * So work needs to be done here.
	 * __construct($mode, $data) would let me create three different constructor variants.
	 * 
	 * 
	 * @param type $data
	 */
	public function __construct($data) {
//		dmDebug::ddd($data, 'data');die;
		$this->type = str_replace('Product', '', get_class($this));

		// If we have an existing cart item, we'll need to expand the Supplement data
		if (isset($data['CartItem'])) {
			$this->Supplement = ClassRegistry::init('Supplement');
			$s = $this->Supplement->record_fromCartItem($data['CartItem']['id']);
			
			$this->supplementId = (isset($s['Supplement']['id'])) ? $s['Supplement']['id'] : FALSE;
			$this->data = (isset($s['Supplement']['data'])) ? unserialize($s['Supplement']['data']) : array();
			$this->item = $data['CartItem'];
			
		// otherwise, this is a new request and we just have the form describing the ordered product
		} else {
			$this->data = $data;
			$this->item = array();
			$this->supplementId = FALSE;
		}
		
		// either way, we'll bring the cart in for the user_id and possibly othe things
		$this->cart = ClassRegistry::init('Cart')->retrieve();
		$this->user_id = $this->cart['Cart']['user_id'];
		
		
//		debug($this->type, 'type');
//		debug($this->data, 'data');
//		debug($this->userId, 'userId');
//		debug($this->sessionId, 'sessionId');
	}
	
	/**
	 * Set and/or return the data property (current product specification array)
	 * 
	 * If the constructor is fixed, setting should be removed
	 * 
	 * @param array $data
	 * @return array
	 */
	public function data($data = FALSE) {
		if ($data) {
			$this->data = $data;
		}
		return $this->data;
	}
	
	/**
	 * Return the item property (CartItem record data)
	 * 
	 * @return array
	 */
	public function item() {
		return $this->item;
	}

//	/**
//	 * Tentative // 
//	 * May be better as an interface that be implemented. 
//	 * Then, for any given app, you could implement as many payment interfaces as you supported
//	 * 
//	 * When submitting a cart to paypal, some standard chunk of data will be needed. 
//	 * This could be the way to get that chunk.
//	 * 
//	 * @param int $index Paypal cart items get numbered. this is the number
//	 */
//	abstract public function paypalCartUploadNode($index);

	/**
	 * Given form data from the user, generate a trustworthy price for the item
	 * 
	 * Cart stores Price (for a unit) and Quanity. 
	 * Total (price * quantity) is a virtual field.
	 * 
	 * @return float The calculated price
	 */
	abstract protected function calculatePrice();
	
	/**
	 * Prepare data for saving in the Cart Model
	 * 
	 * @param string $cartId ID of the Cart header record which links this new CartItem
	 * @return array The data to save
	 */
	abstract public function cartEntry($cartId);
	
	/**
	 * Take the user to a page where they can re-specify the project details
	 * 
	 * @param string $id CartItem record id
	 */
	abstract public function editEntry($id);
	
	/**
	 * Allow user to change the ordered quantity for a cart item
	 * 
	 * @param string $id CartItem record id
	 * @param string $qty New quantity for the cart item
	 */
	abstract public function updateQuantity($id, $qty);

	/**
	 * Set up both versions of the price lookups
	 * 
	 * One is keyed with the full NAME, the other with just the item code (last name node)
	 * Sample name (Editions:Collab:KJ:Conversation:song)
	 */
	protected function lookup() {
		if (!isset($this->qbPrices) || !isset($this->qbCodePrices)) {
			$this->qbPrices = QBModel::priceList();
			$this->qbCodePrices = QBModel::priceList(TRUE);
		}
	}
	
	/**
	 * Given a qb item code or path, return the item price
	 * 
	 * Assume a full item path first. If not found, try a code only 
	 * lookup. If that's not found, return 0
	 * 
	 * @param string $key
	 * @return string
	 */
	protected function lookupPrice($key) {
		$this->lookup();
//		dmDebug::ddd($key, 'key');
//		dmDebug::ddd($this->qbPrices[$key], 'prices element');
//		dmDebug::ddd($this->qbCodePrices[$key], 'code element');
		if (isset($this->qbPrices[$key])) {
			return $this->qbPrices[$key];
		} elseif (isset($this->qbCodePrices[$key])) {
			return $this->qbCodePrices[$key];
		} else {
			return '0';
		}
	}

}

?>
