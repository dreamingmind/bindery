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
		
		// radio buttons in the product grids were no reliably sending thier data in 
		// with the other form data. So, the radio click now sets the 'code' node 
		// and we move the value to it's proper home when the form is submitted. HACK.
		$this->data[$this->product]['product'] = $this->data[$this->product]['code'];
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
		
		// how many of this item was ordered
		$quantity = isset($this->data[$this->product]['quantity']) ? $this->data[$this->product]['quantity'] : 1;
		
		// the product field contains the code of the chosen product
		$price = $this->lookupPrice(strtoupper($this->data[$this->product]['product']) ); // these are 'code only' but were lowercased in the ui. won't match that way
//		dmDebug::ddd($this->data[$this->product]['product'], 'lookup product');
		if ($price < 1) {
			return $price; // price wasn't found 0 will translate to 'To Quote'
		}
//		$price = $this->qbCodePrices[ $this->data[$this->product]['product'] ];
		
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

//	public function paypalCartUploadNode($index) {
//		
//	}

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
				'id' => (isset($this->item['id'])) ? $this->item['id'] : '',
				'order_id' => $cartId,
				'type' => $this->type,
				'user_id' => ($this->userId) ? $this->userId : NULL,
				'product_name' => $this->name(),
				'blurb' => $this->blurb(),
				'options' => $this->options(),
				'price' => $this->calculatePrice(),
				'quantity' => $this->data[$this->product]['quantity']
			),
			'Supplement' => array(
				'id' => isset($this->supplementId) ? $this->supplementId : NULL,
				'type' => 'POST',
				'data' => serialize($this->data)
			),
			'Cart' => isset($this->data['Cart']) ? $this->data['Cart'] : array()
		);
//		dmDebug::ddd($cart['CartItem']['price'], 'fin price');
		return $cart;
	}

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

	public function product() {
		return $this->product;
	}

	public function editEntry($id) {
		
	}
	
	private function name() {
		$name = preg_match('/([a-zA-Z ]+ -){1}(.+)/', $this->data[$this->product]['description'], $match);
		$name = trim($match[1], ' -');
		return $name;
	}
	
	private function blurb() {
		$blurb = preg_match('/([a-zA-Z ]+ -){1}(.+)/', $this->data[$this->product]['description'], $match);
		$blurb = trim($match[2], ' -');
		if ($this->calculatePrice() == '0') {
			$blurb = "<span class=\"alert\">REQUIRES QUOTE</span>, price incomplete. $blurb";
		}
		return $blurb;
	}
	
	/**
	 * Compile custom product form inputs into a markdown list
	 * 
	 * Some fields are filtered out, some are renamed, others are grouped. 
	 * It all happens here! When the work is done, the string can be output 
	 * as Markdown to get UL/LI html or as an echo to get hyphen delimited data
	 * 
	 * @return string
	 */
	private function options() {
//		dmDebug::ddd($this->data[$this->product], '$this->data[$this->product]');
		$options = '';
		
		foreach ($this->data[$this->product] as $name => $value) {
			// reusable journal body fields are included on journal pages I think. 
			// This may not be right, but this hack takes care of the field overlap for now. 
			// It also prevents the need to write special 'name' handlers for these options. 
			$name = str_replace('reusable_', '', $name);
//			dmDebug::ddd("do $name => $value", 'loop');
			
//			dmDebug::ddd($name, 'name');
//			dmDebug::ddd($value, 'value');
			switch ($name) {
				// heres a list of inputs we don't process into output lines
				case 'code':
				case 'product':
				case 'description':
				case 'sum':
				case 'total':
				case 'name':
				case 'email':
				case 'quantity':
				case 'uniqueliner':
					continue;
					break;
				
				case 'Options:63':
					$options .= $this->optionNamed('Closing belt', $value);					
					break;
				
				// these two get merged into a single line
				case 'Options:59.2':
					$options .= $this->optionNamed('Pen loop', $value);					
					break;
				case 'diameter':
					$dia = $value == '0' ? '' : ": $value diameter";
					$options = str_replace('Pen loop', "Pen loop$dia", $options);
					
				// this will be the parent fro the following two
				case 'Options:17':
					$options .= $this->optionNamed('Titling requested', $value);					
					break;
				
				// these two are child LIs of Option:17 
				case 'foil-color':
					if ($this->data[$this->product]['Options:17']) {
						$options .= '    ' . $this->optionPair('Foil color', $value, 'Foil color: discuss');
					}
					break;
				case 'title_text':
					if ($this->data[$this->product]['Options:17']) {
						$options .= '    ' . $this->optionPair('Title text', $value, 'Title text: discuss');
					}
					break;
					
				// these all cascade into a lookup of the actual cloth color
				case 'liners': // only show if they are unique (not the same as the cover cloth)
					if (!$this->data[$this->product]['uniqueliner']) {
						continue;
					}
				case 'liner': // only show if there is no other indication of cloth or liner material (a full leather product in other words)
					if ($name === 'liner' && ($this->data[$this->product]['uniqueliner'] || $this->data[$this->product]['cloth'])) {
						continue;
					}
				case 'leather':
				case 'cloth':
				case 'endpaper':
					$Material = ClassRegistry::init('Material');
					$options .= $this->optionPair($name, $Material->realName($value));
					break;
				
				// everything else is a normal 'name: value' pair
				default:
					$options .= $this->optionPair($name, $value);
					break;
			}
		}
		return $options;
	}
	
	/**
	 * Generate a Name: Value option pair
	 * 
	 * @param string $name
	 * @param string $value
	 * @param string $default
	 * @return string
	 */
	private function optionPair($name, $value, $default = '') {
//		dmDebug::ddd($value, $name . ' pair');
		if ($value && $value != '-1') {
			$name = ucfirst($name);
			return "- $name: $value\n";
		} else {
			return ($default === '') ? '' : "- $default\n";
		}
	}
	
	/**
	 * Generate a Named option without a value
	 * 
	 * @param string $name
	 * @param string $value
	 * @param string $default
	 * @return string
	 */
	private function optionNamed($name, $value, $default = '') {
//		dmDebug::ddd($value, $name . ' named');
		if ($value && $value != '-1') {
			return "- $name\n";
		} else {
			return ($default === '') ? '' : "- $default\n";
		}
	}
}
?>
