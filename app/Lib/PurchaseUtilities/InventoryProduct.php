<?php

/*
 * InventoryProduct Utility manages purchase of a product that has no options or variations
 * 
 * I'm expecting these to be Limited Editions where there is no variant version, 
 * shelf items and seconds where you get what I have.
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
	
	/**
	 * Calculate the price of a single unit of the product
	 * 
	 * Cart stores Price (for a unit) and Quanity. 
	 * Total (price * quantity) is a virtual field.
	 * 
	 * @return float
	 */
	public function calculatePrice() {
		// PSUEDO CODE ! ! ! DO NOT USE ******!!!!!!!!!!!***************!!!!!!!!!!!***************!!!!!!!!!!!***************!!!!!!!!!!!***************!!!!!!!!!!!*********
		return $this->data['amount'];
	}

	public function paypalCartUploadNode($index) {
		
	}

	/**
	 * 
	 * @param string $cartId ID of the Cart header record which links this new CartItem
	 */
	public function cartEntry($cartId) {
		$cart = array('CartItem' => array(
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : '',
				'cart_id' => $cartId,
				'product_name' => $this->data['item_number'] . ' - ' . $this->data['item_name'],
				'price' => $this->calculatePrice(),
				'quantity' => 1 // ******!!!!!!!!!!!********* PSUEDO CODE ! ! ! DO NOT USE ******!!!!!!!!!!!***************!!!!!!!!!!!***************!!!!!!!!!!!*********
			),
			'Supplement' => array(
				'type' => 'POST',
				'data' => serialize($this->data)
			)
		);
		return $cart;
	}

	public function updateQuantity($id, $qty) {
		
	}

	public function editEntry($id) {
		
	}

//put your code here
}

?>
