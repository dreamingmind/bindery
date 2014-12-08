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
	
	protected $key;
	protected $fields;
	protected $productName;
	
	public function __construct($Session, $data) {
		parent::__construct($Session, $data);
		$this->decomposeData();
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
		
//		$this->data['Edition'] = unserialize($this->data['Edition'][1]['content']);
		$cart = array('CartItem' => array(
				'id' => (isset($this->fields['id'])) ? $this->fields['id'] : '',
				'order_id' => $cartId,
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : NULL,
				'blurb' => $this->blurb(),
				'product_name' => $this->name(),
				'options' => $this->fields['project_description'],
				'price' => $this->calculatePrice(),
				'quantity' => intval($this->fields['quantity']) < 1 ? 1 : $this->fields['quantity']
			),
			'Supplement' => array(
				array(
					'type' => 'POST',
					'data' => serialize($this->data)
				)				
			)
		);
//		dmDebug::ddd($this->data, 'this data');
//		dmDebug::ddd($cart, 'cart');
		return $cart;
	}

	public function editEntry($id) {
		
	}

	public function paypalCartUploadNode($index) {
		
	}

	public function updateQuantity($id, $qty) {
		
	}
	
	private function decomposeData() {
		$p = array_keys($this->data);
		$this->key = $p[0];
		$this->productName = ucwords(str_replace('-', ' ', $this->key));
		$this->fields = $this->data[$this->key];
	}

	/** array(
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
	private function name() {
		$name = ($this->fields['project_name'] != '') ? "{$this->fields['project_name']} ($this->productName)" : $this->productName;
		return $name;
	}
	
	private function blurb() {
		$blurb = array(
			"<span class=\"alert\">REQUIRES QUOTE</span>\n",
			($this->fields['time_frame'] != '') ? '- Time frame: ' . $this->fields['time_frame'] : '',
			($this->fields['budget'] != '') ? '- Budget: ' . $this->fields['budget'] : ''
		);
		return trim(implode("\n", $blurb), "\n");
	}
}
