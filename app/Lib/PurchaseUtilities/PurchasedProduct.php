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
	
	protected $data;
	
	public function __construct($data) {
		$this->data = $data;
	}

		/**
	 * Given form data from the user, generate a trustworthy price for the item
	 * 
	 * @return float The calculated price
	 */
	abstract public function calculatePrice();

	/**
	 * Tentative
	 * 
	 * When submitting a cart to paypal, some standard chunk of data will be needed. 
	 * This could be the way to get that chunk.
	 * 
	 * @param int $index Paypal cart items get numbered. this is the number
	 */
	abstract public function paypalCart($index);
}

?>
