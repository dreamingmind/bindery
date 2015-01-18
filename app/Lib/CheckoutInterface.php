<?php

/**
 * Checkout process interface
 * 
 * Implement these methods for checkout
 * http://www.smashingmagazine.com/2009/05/28/12-tips-for-designing-an-excellent-checkout-process/
 *
 * @author dondrake
 */
interface CheckoutInterface {
	
	/**
	 * The initial landing page for a checkout process
	 */
	public function index();
	
	/**
	 * Collect or process address information for the order
	 */
	public function address();
	
	/**
	 * Negotiate a payment with the user
	 */
	public function method();
	
	/**
	 * Final oportunity for the user to review and confirm the order details
	 */
	public function confirm();

	/**
	 * The record of the completed order
	 */
	public function recipt();
}
