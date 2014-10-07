<?php
/**
 * CustomProduct Utility manages /products/_product_/purchase data arrays
 * 
 * These are the classic product specifications arrays:
 * 
 * array(
 *	'button' => array(
 *		// button section fields -- may not have data in the future
 *	),
 * 
 *	'Size_5_5_x_8_5' => 'Size_5_5_x_8_5',
 *	// table row/column filter checkboxes - not relevant to product specifications
 *	'Ruled_Pages' => 'Ruled_Pages',
 * 
 *	// The sellected prodcut and all relevant specifications
 *	'Journal' => array(
 *		'product' => '888bl',
 *		// specification fields
 *		'endpapers' => '0'
 *	),
 * 
 *  // The key to the node that holds all the specification
 *	'specs_key' => 'Journal'
 * )
 *
 * @author dondrake
 */
class CustomProduct extends PurchasedProduct {
	
	/**
	 * The name of the product
	 * 
	 * This is the key into $this->data to find the chosen options
	 *
	 * @var string
	 */
	protected $product;

	/**
	 * Set up standard properties and the key to the specs node in $data
	 * 
	 * @param object $Session The current Session Component
	 * @param array $data The data posted in the 'Add to cart' request
	 */
	public function __construct($Session, $data) {
		parent::__construct($Session, $data);
		$this->product = $this->data['specs_key'];
//		debug($this->product, 'product');
	}
	
	public function calculatePrice() {
//		dmDebug::ddd($this->data, 'the data to calculate a price from');
	}

	public function paypalCartUploadNode($index) {
		
	}

	/**
	 * Prepare data for save to cart
	 * 
	 * For Custom Products, the array of data describing the option 
	 * choices and details is stored as serialized Supplement data. 
	 * 
	 * @return array The data to save
	 */
	public function cartEntry() {
		$cart = array('Cart' => array(
				'id' => (isset($this->data[$this->product]['id'])) ? $this->data[$this->product]['id'] : '',
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : '',
				'session_id' => ($this->sessionId) ? $this->sessionId : '',
				'design_name' => $this->data[$this->product]['description'],
				'price' => $this->calculatePrice()
			),
			'Supplement' => array(
				array(
					'type' => 'POST',
					'data' => serialize($this->data)
				)				
			)
		);
		return $cart;
	}

	public function updateQuantity() {
		
	}
}

?>
