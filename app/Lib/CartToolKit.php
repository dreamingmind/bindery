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
	private $cart;
	
	/**
	 * The CartItem arrays numerically indexed
	 *
	 * @var array
	 */
	private $items;
	
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
	
	public function itemCount() {
		return count($this->items);
	}
	
	public function zeroCount() {
		return count($this->zeroItems);
	}
	
	public function nonZeroCount() {
		return count($this->nonZeroItems);
	}
	
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
	
	public function subtotal() {
		return $this->subtotal;
	}
	
	public function shippingEstimate() {
		return 12;
	}

	public function shippingZipCode() {
		return $this->shipping['postal_code'];
	}
	
	public function items() {
		return $this->items;
	}
	
	public function email() {
		return $this->cart['email'];
	}
	
	public function phone() {
		return $this->cart['phone'];
	}
	
	public function customerName() {
		return $this->cart['name'];
	}
}

// This iterator filters all items who's price != 0
class ZeroFilter extends FilterIterator {

    public function accept() {
		$item = parent::current();
        //
        return $item['price'] == 0;
    }

}

// This iterator filters all items who's price <= 0
class NonZeroFilter extends FilterIterator {

    public function accept() {
		$item = parent::current();
        //
        return $item['price'] != 0;
    }

}
