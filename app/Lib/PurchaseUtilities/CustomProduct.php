<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomProduct
 *
 * @author dondrake
 */
class CustomProduct extends PurchasedProduct {
	
	public function __construct($data) {
		parent::__construct($data);
	}
	
	public function calculatePrice() {
//		dmDebug::ddd($this->data, 'the data to calculate a price from');
	}

	public function paypalCart($index) {
		
	}
}

?>
