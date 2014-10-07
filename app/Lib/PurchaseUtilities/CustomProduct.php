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
	
	/**
	 * Let the parent set up important properties
	 * 
	 * type and data at the very least
	 * 
	 * @param type $data
	 */
	public function __construct($data) {
		parent::__construct($data);
		dmDebug::ddd(get_defined_vars(), 'vars');
	}
	
	public function calculatePrice() {
//		dmDebug::ddd($this->data, 'the data to calculate a price from');
	}

	public function paypalCartUploadNode($index) {
		
	}

	/**
	 * Prepare data for save to cart
	 * 
	 */
	public function cartEntry() {
		
		// this might be an update (based on an existing id)
		if (isset($this->data['Cart']['id']) && $this->data['Cart']['id'] != '') {
			$cart = $this->data;
			
		// no id means new form data we'll process into the correct records
		} else {
			$cart = array('Cart' => array(
				'type' => $this->type,
				'Suppliment' => array(
					'type' => 'POST',
					'data' => serialize($this->data)
				)
			));
		}
	}
}

?>
