<?php

/**
 * Checkout process interface
 * 
 * Implement these methods for checkout
 * http://www.smashingmagazine.com/2009/05/28/12-tips-for-designing-an-excellent-checkout-process/
 *
 * @author dondrake
 */
interface Checkout {
	
	public function checkout();
	
	public function address();
	
	public function method();
	
	public function confirm();

	public function recipt();
}
