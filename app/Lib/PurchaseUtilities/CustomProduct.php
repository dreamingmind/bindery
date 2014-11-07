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
 *	// The sellected product and all relevant specifications
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
	
	/**
	 * Calculate the price of a single unit of the product
	 * 
	 * Cart stores Price (for a unit) and Quanity. 
	 * Total (price * quantity) is a virtual field.
	 * 
	 * @return float
	 */
	public function calculatePrice() {
		if (!isset($this->data[$this->product]) || !isset($this->data[$this->product]['product'])) {
			
		}
		$this->lookup(); // set the lookup properties
		
		// how many of this item was ordered
		$quantity = isset($this->data[$this->product]['quantity']) ? $this->data[$this->product]['quantity'] : 1;
		
		// the product field contains the code of the chosen product
		$price = $this->qbCodePrices[ strtoupper($this->data[$this->product]['product']) ];
		
		// options are yes/no radio buttons and the node is the full NAME from qb
		foreach ($this->data[$this->product] as $name => $choice)  {
			if (stristr($name, 'Option')) {
				if ($choice === '1') {
					$price += isset($this->qbPrices[$name]) ? $this->qbPrices[$name] : 0;
				}
			}
		}
		
		return $price;
		
		// no other price bits to cherry pick at this time
		
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
	 * @param string $cartId ID of the Cart header record which links this new CartItem
	 * @return array The data to save
	 */
	public function cartEntry($cartId) {
//		dmDebug::ddd($this->data[$this->product]['total'], 'orig tot');
		$cart = array('CartItem' => array(
				'id' => (isset($this->data[$this->product]['id'])) ? $this->data[$this->product]['id'] : '',
				'cart_id' => $cartId,
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : NULL,
				'product_name' => $this->data[$this->product]['description'],
				'price' => $this->calculatePrice(),
				'quantity' => $this->data[$this->product]['quantity']
			),
			'Supplement' => array(
				array(
					'type' => 'POST',
					'data' => serialize($this->data)
				)				
			)
		);
//		dmDebug::ddd($cart['CartItem']['price'], 'fin price');
		return $cart;
	}

	/**
	 * Record a simple quantity change in a cart record
	 */
	public function updateQuantity($id, $qty) {
		
	}

	public function editEntry($id) {
		
	}
}

?>
