<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenericProduct
 *
 * @author dondrake
 */
class GenericProduct extends PurchasedProduct {
	
	protected $product;
	
	protected $productName;
	
	public function __construct($Session, $data) {
		parent::__construct($Session, $data);
//		$p = array_keys($this->data);
		$this->product = $this->data['edit_path'];
		$this->productName = ucwords(str_replace('-', ' ', $this->product));
	}

		protected function calculatePrice() {
		return '0';
	}

	/**
	 * array(
			'personal-publishing' => array(
				'name' => '',
				'email' => '',
				'project_name' => 'my totally custom project',
				'quantity' => '3',
				'time_frame' => '2nd week of January 2015',
				'budget' => '$600',
				'project_description' => 'This is the lengthy description of the project',
				'id' => ''
			),
			'generic' => 'generic'
		)
	 * @param type $cartId
	 */
	public function cartEntry($cartId) {
				$cart = array('CartItem' => array(
				'id' => (isset($this->item['id'])) ? $this->item['id'] : '',
				'order_id' => $cartId,
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : NULL,
				'blurb' => $this->blurb(),
				'product_name' => $this->name(),
				'options' => $this->data[$this->product]['project_description'],
				'price' => $this->calculatePrice(),
				'quantity' => intval($this->data[$this->product]['quantity']) < 1 ? 1 : $this->data[$this->product]['quantity']
			),
			'Supplement' => array(
				'type' => 'POST',
				'data' => serialize($this->data)
			),
			'Cart' => isset($this->data['Cart']) ? $this->data['Cart'] : array()

		);
//		dmDebug::ddd($this->data, 'this data');
//		dmDebug::ddd($cart, 'cart');
		return $cart;
	}
	
	public function product() {
		return $this->product;
	}

	public function editEntry($id) {
		
	}

//	public function paypalCartUploadNode($index) {
//		
//	}

	/**
	 * Record a simple quantity change in a cart record
	 */
	public function updateQuantity($id, $qty) {
		$this->data[$this->product]['quantity'] = $qty;
		$cart = array(
			'CartItem' => array(
				'id' => $id,
				'quantity' => $qty
			),
			'Supplement' => array(
				'id' => $this->supplementId,
				'data' => serialize($this->data)
			)
		);
		return $cart;
	}
	
	/**
	 * Construct the product name display value
	 * 
	 * @return string
	 */
	private function name() {
		$name = ($this->data[$this->product]['project_name'] != '') ? "{$this->data[$this->product]['project_name']} ($this->productName)" : $this->productName;
		return $name;
	}
	
	/**
	 * Construct the blurb dispaly value
	 * 
	 * A markdown string announcing the need for a quote 
	 * and the time frame and budget if provided
	 * 
	 * @return string
	 */
	private function blurb() {
		$blurb = array(
			"<span class=\"alert\">REQUIRES QUOTE</span>\n",
			($this->data[$this->product]['time_frame'] != '') ? '- Time frame: ' . $this->data[$this->product]['time_frame'] : '',
			($this->data[$this->product]['budget'] != '') ? '- Budget: ' . $this->data[$this->product]['budget'] : ''
		);
		return trim(implode("\n", $blurb), "\n");
	}
}
