<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PriceValidator
 *
 * @author dondrake
 */
abstract class PurchasedProduct {
	
	/**
	 * The form data submitted during the purchase of something
	 * 
	 * @var array
	 */
	protected $data;
	
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
	 * The current logged in User from the Session
	 *
	 * @var string|boolean A User id or FALSE
	 */
	protected $userId = FALSE;
	
	/**
	 * The current Session id if there is no logged in user
	 *
	 * @var string|boolean The current session id or FALSE
	 */
	protected $sessionId = FALSE;
	
	/**
	 * Set properties for the concrete classes
	 * 
	 * @param type $data
	 */
	public function __construct($Session, $data) {
		$this->type = str_replace('Product', '', get_class($this));
		$this->data = $data;
		$this->Session = $Session;;
		$this->userId = $this->Session->read('Auth.User.id');
		if (!$this->userId) {
			$this->sessionId = $this->Session->id();
		}
//		debug($this->type, 'type');
//		debug($this->data, 'data');
//		debug($this->userId, 'userId');
//		debug($this->sessionId, 'sessionId');
	}

	/**
	 * Given form data from the user, generate a trustworthy price for the item
	 * 
	 * @return float The calculated price
	 */
	abstract public function calculatePrice();

	/**
	 * Tentative // 
	 * May be better as an interface that be implemented. 
	 * Then, for any given app, you could implement as many payment interfaces as you supported
	 * 
	 * When submitting a cart to paypal, some standard chunk of data will be needed. 
	 * This could be the way to get that chunk.
	 * 
	 * @param int $index Paypal cart items get numbered. this is the number
	 */
	abstract public function paypalCartUploadNode($index);
	
	/**
	 * Prepare data for saving in the Cart Model
	 * 
	 * @return array The data to save
	 */
	abstract public function cartEntry();
	
	abstract public function updateQuantity();


}

?>
