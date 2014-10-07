<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InventoryProduct
 *
 * @author dondrake
 */
class InventoryProduct extends PurchasedProduct {
	
	/**
	 * Set up standard properties and the key to the specs node in $data
	 * 
	 * @param object $Session The current Session Component
	 * @param array $data The data posted in the 'Add to cart' request
	 */
//	public function __construct($Session, $data) {
//		parent::__construct($Session, $data);
////		$this->product = $this->data['specs_key'];
////		debug($this->product, 'product');
//	}
	
	public function calculatePrice() {
		// PSUEDO CODE ! ! ! DO NOT USE
		return $this->data['amount'];
	}

	public function paypalCartUploadNode($index) {
		
	}

	public function cartEntry() {
		$cart = array('Cart' => array(
//				'id' => (isset($this->data[$this->product]['id'])) ? $this->data[$this->product]['id'] : '',
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : '',
				'session_id' => ($this->sessionId) ? $this->sessionId : '',
				'design_name' => $this->data['item_number'] . ' - ' . $this->data['item_name'],
				'price' => $this->calculatePrice()
			),
			'Supplement' => array(
				array(
					'type' => 'CMD-CART',
					'data' => serialize($this->data)
				)				
			)
		);
		return $cart;
	}

	public function updateQuantity($id, $qty) {
		
	}	//put your code here
}

?>
