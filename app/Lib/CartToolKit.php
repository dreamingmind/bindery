<?php
/**
 * Description of CartToolKit
 * 
 * Cart analysis tools for making View, Element and Helper output decisions
 *
 * @author dondrake
 */
class CartToolKit {
	
	/**
	 * The Cart array without items
	 *
	 * @var array
	 */
	protected $cart;
	
	/**
	 * The CartItem arrays numerically indexed
	 *
	 * @var array
	 */
	protected $items;
	
	private $shipping;
	
	private $billing;
	
	private $subtotal = 0;
	
	private $taxRate;

	/**
	 * Cart items that don't have a price
	 * 
	 * @var array 
	 */
	private $zeroItems;
	
	/**
	 * Index to the current cart item
	 *
	 * @var int
	 */
	public $itemIndex = 0;


	/**
	 * Cart items that do have a price
	 * @var array 
	 */
	public $nonZeroItems;
	
	public function __construct($cart) {
		$this->loadCart($cart);
		$this->taxRate = Configure::read('company.tax_rate');
	}
	
	/**
	 * Refresh all values to match a cart
	 * 
	 * @param array $cart From CartModel::retrieve()
	 */
	public function loadCart($cart) {
		$this->cart = $this->items = $this->zeroItems = $this->nonZeroItems = $this->unknownItems = $this->billing = $this->shipping = array();
		$this->subtotal = 0;
		
		
		$this->cart = $cart['Cart'];
		$this->items = $cart['CartItem'];
		$this->billing = $cart['Billing'];
		$this->shipping = $cart['Shipping'];
		
		foreach ($this->items as $item) {
			if (floatval($item['price']) == 0) {
				$this->zeroItems[] = $item;
			} elseif (floatval($item['price']) > 0) {
				$this->nonZeroItems[] = $item;
				$this->subtotal += $item['price'] * $item['quantity'];
			} else {
				$this->unknownItems[] = $item;
			}
		}
	}
	
	/**
	 * The number of items in the Cart
	 * 
	 * @return int
	 */
	public function itemCount() {
		return count($this->items);
	}
	
	public function describeItemCount() {
//		$tot = $this->tax + $this->shipping() + $this->cartSubtotal();
		$i = $this->itemCount() === 1 ? 'item' : 'items';
		return "{$this->itemCount()} $i in your cart.";
		
	}
	/**
	 * The number of items in the cart that have price=0
	 * 
	 * @return int
	 */
	public function zeroCount() {
		return count($this->zeroItems);
	}
	
	/**
	 * The number of items in the Cart that have price>0
	 * 
	 * @return int
	 */
	public function nonZeroCount() {
		return count($this->nonZeroItems);
	}
	
	/**
	 * Return the specified address data
	 * 
	 * @param string $type shipping|billing
	 * @return array field names as first index level
	 */
	public function address($type) {
		return $this->$type;
	}
	
	/**
	 * All items are priced so some form of payment is required
	 * 
	 * @return boolean
	 */
	public function mustPay() {
		return $this->itemCount() == $this->nonZeroCount();
	}
	
	/**
	 * There are priced and unpriced items
	 * 
	 * A payment would be considered a deposit.
	 * There are also items to quote so payment is not required
	 * 
	 * @return boolean
	 */
	public function includesQuote() {
		return (!empty($this->zeroItems)) && ($this->zeroCount() != $this->itemCount());
	}
	
	/**
	 * There are no prices. Everything must be quoted
	 * 
	 * @return boolean
	 */
	public function mustQuote() {
		return empty($this->nonZeroItems);
	}
	
	/**
	 * Is CA tax required on this order?
	 * 
	 * @return boolean
	 */
	public function mustTax() {
		return strpos(strtolower(trim($this->shipping['state'])), 'ca') === 0;
	}
	
	/**
	 * Return a span containing the tax amount and title attr
	 * 
	 * @return string
	 */
//	public function taxSpan() {
//		$format = '<span class="amt" title="%s">%s</span>';
//		
//		$tax = $this->taxAmount();
//		
//		if ($this->mustTax()) {
//			$title = 'California sales tax';
//		} else {
//			$title = 'Exempt, out of state';
//		}
//			return sprintf($format, $title, $tax);
//	}
	
	/**
	 * DEPRECATED - Moved to Usps Model
	 */
//	public function shippingEstimate() {
//		return 12;
//	}
	
	/**
	 * Return the tax amount or '-TBD-'
	 * 
	 * @return int|string
	 */
	public function taxAmount() {
		if ($this->mustTax()) {
			return $this->subtotal * $this->taxRate;
		}
		return 0;
	}
	
	/**
	 * Get the tax for the $index-th item
	 * 
	 * @param int $index
	 */
	public function itemTax($index) {
		if ($this->mustTax()) {
			return $this->itemSubtotal($index) * $this->taxRate;
		}
		return 0;
	}
	
	/**
	 * Get the price*quantity for the $index-th item
	 * 
	 * @param int $index
	 * @return float
	 */
	public function itemSubtotal($index) {
		return $this->items[$index]['price'] * $this->items[$index]['quantity'];
	}

		/**
	 * Get the field value for the $index-th item
	 * 
	 * @param int $index
	 * @param string $field
	 * @return string|NULL
	 */
	public function itemValue($field, $index = FALSE) {
		if (!$index) {
			$index = $this->itemIndex;
		}

		if (isset($this->items[$index][$field])) {
			return $this->items[$index][$field];
		} else {
			return NULL;
		}
	}

		/**
	 * Return the sum of the nonZero priced items in the cart
	 * 
	 * @return float
	 */
	public function subtotal() {
		return $this->subtotal;
	}

	/**
	 * Return the shipping zip code
	 * 
	 * @return string
	 */
	public function shippingZipCode() {
		return $this->shipping['postal_code'];
	}
	
	/**
	 * Return all or some of the fields for the set of items in the cart
	 * 
	 * @param array $fields field keys to filter the return
	 * @return array
	 */
	public function items($fields = array()) {
		if (empty($fields)) {
			return $this->items;
		} else {
			$i = array();
			foreach ($this->items as $item) {
				$i[] = array_intersect_key($item, $fields);
			}
			return $i;
		}

	}
	
	/**
	 * Return the order number for this cart
	 * 
	 * @return string
	 */
	public function orderNumber() {
		return $this->cart['number'];
	}
	
	/**
	 * Return the cart owner's email address
	 * 
	 * @return string
	 */
	public function email() {
		return $this->cart['email'];
	}
	
	/**
	 * Return the cart owner's phone number
	 * 
	 * @return string
	 */
	public function phone() {
		return $this->cart['phone'];
	}
	
	/**
	 * Return the cart owner's name
	 * 
	 * @return string
	 */
	public function customerName() {
		return $this->cart['name'];
	}
	
	/**
	 * Return the id of the Cart record
	 * 
	 * @return string
	 */
	public function cartId() {
		return $this->cart['id'];
	}
	
	/**
	 * Return the id of the User that owns the Cart (even if anon, return '')
	 * 
	 * @return string
	 */
	public function userId() {
		return $this->cart['user_id'];
	}
	
	/**
	 * Return a comma delimited in list of cart item IDs
	 * 
	 * @return string
	 */
	public function itemInList() {
		$list = array();
		foreach ($this->items as $item) {
			$list[] = $item['id'];
		}
		return implode(', ', $list);
	}
}

// This iterator filters all items who's price != 0
//class ZeroFilter extends FilterIterator {
//
//    public function accept() {
//		$item = parent::current();
//        //
//        return $item['price'] == 0;
//    }
//
//}
//
//// This iterator filters all items who's price <= 0
//class NonZeroFilter extends FilterIterator {
//
//    public function accept() {
//		$item = parent::current();
//        //
//        return $item['price'] != 0;
//    }
//
//}
