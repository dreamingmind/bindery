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
	}
	
	/**
	 * Refresh all values to match a cart
	 * 
	 * @param array $cart From CartModel::retrieve()
	 */
	public function loadCart($cart) {
		$this->cart = $this->items = $this->zeroItems = $this->nonZeroItems = $this->unknownItems = array();
		
		$this->cart = $cart['Cart'];
		$this->items = $cart['CartItem'];
		
		foreach ($this->items as $item) {
			if (floatval($item['price']) == 0) {
				$this->zeroItems[] = $item;
			} elseif (floatval($item['price']) > 0) {
				$this->nonZeroItems[] = $item;
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
