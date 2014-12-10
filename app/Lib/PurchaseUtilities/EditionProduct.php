<?php

/**
 * EditionProduct Utility manages purchase clicks on art purchases which are essentially stock items
 * 
 * Edition descriptions and blurbs are stored in a dedicated table. 
 * If an editions needs options, they will be supplemental data linked the record (hasMany Supplements). 
 * The edition record will carry a value used to look up its corresponding QB record which has current pricing. 
 * 
 * The process of creating a cart entry then, is a matter of looking up the various 
 * relevant records for creation of the cart record. 
 * 
 * Since no editions are expected to have options at this point, editing will be a trivial pass-through.
 * 
 * Subscription edition pattern unkown at this point ++++++++++++++++ !!!!!!!!!!!!!!!!!!!! ===============
 *
 * @author dondrake
 */
class EditionProduct extends PurchasedProduct {
	
	/**
	 * Calculate the price of a single unit of the product
	 * 
	 * The price is stored in qb.invitem
	 * 
	 * @return float
	 */
	protected function calculatePrice() {
		if (!isset($this->data['Edition']['item'])) {
			$this->data['Edition']['item'] = 'unknown';
		}
		// the product field contains the code of the chosen product
		$price = $this->lookupPrice($this->data['Edition']['item']);
		
		return $price;
		
		// no other price bits to cherry pick at this time
		
//		dmDebug::ddd($this->data, 'the data to calculate a price from');
	}

	/**
	 * Prepare data for save to cart
	 * 
	 * For Edition Products, the array of data describing the option 
	 * choices and details is stored as serialized Supplement data. 
	 * 
	 * @param string $cartId ID of the Cart header record which links this new CartItem
	 * @return array The data to save
	 */
	public function cartEntry($cartId) {
		$this->data['Edition'] = unserialize($this->data['Edition'][1]['content']);
		$cart = array('CartItem' => array(
				'id' => (isset($this->data['Edition']['id'])) ? $this->data['Edition']['id'] : '',
				'order_id' => $cartId,
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : NULL,
				'blurb' => $this->blurb(),
				'product_name' => $this->data['Edition']['name'],
				'price' => $this->calculatePrice(),
				'quantity' => isset($this->data['Edition']['quantity']) ? $this->data['Edition']['quantity'] : 1
			),
			'Supplement' => array(
				'type' => 'POST',
				'data' => serialize($this->data)
			)
		);
//		dmDebug::ddd($cart, 'cart');die;
		return $cart;
	}

	private function blurb() {
		$blurb = ($this->calculatePrice() == '0') ? '<span class="alert">PRICE TO BE DETERMINED</span>, listed price is incorrect. ' : '';
		return $blurb . $this->data['Edition']['blurb'];
	}

	public function editEntry($id) {
		
	}

	public function paypalCartUploadNode($index) {
		
	}

	public function updateQuantity($id, $qty) {
		
	}

}
