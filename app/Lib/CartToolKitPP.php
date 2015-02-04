<?php

App::uses('CartToolKit', 'Lib');
App::uses('Usps', 'Model');
/**
 * CartToolKitPP adds PayPal tools to the standard CartToolKit
 *
 * @author dondrake
 */
class CartToolKitPP extends CartToolKit{
	
	/**
	 * The shipping estimating object
	 * 
	 * For now we're hard wired to USPS
	 * 
	 * @var object 
	 */
	protected $Shipper;

	public function __construct($cart) {
		parent::__construct($cart);
		$this->Shipper = new Usps($cart); // This needs some form of abstraction to allow other shippers
	}
	
	/**
	 * Construct an Order NVP compliant array from the current cart
	 * 
	 * @param string $return URL return destination for successful Paypal call
	 * @param string $cancel URL return destination for canceled Paypal call
	 * @param type $currency Currency type. Defaults to USD
	 */
	public function pp_order($return_url, $cancel_url, $currency = 'USD') {

		$subtotal = $this->subtotal();
		$tax = $this->taxAmount();
		$shipping = $this->Shipper->estimate($this); //$this->Cart->shipping();
		$summary = $this->describeItemCount();
		
        $order = array(
            'description' => $summary,
            'currency' => $currency,
            'return' => $return_url,
            'cancel' => $cancel_url,
			'items' => $this->assembleOrderItems()
        );
		
		return $order;
	}
	
	/**
	 * Make Item nodes for an Order NVP compliant array
	 * 
	 * @return array
	 */
	protected function assembleOrderItems() {
		$nvp = array();
		foreach ($this->items as $index => $item) {
			$this->itemIndex = $index;
			$nvp[] = array(
				'name' => $this->itemValue('name'),
				'description' => $this->itemValue('blurb'),
				'tax' => $this->itemTax($index),
				'subtotal' => $this->itemValue('price'),
				'qty' => $this->itemValue('quantity')
			);
		}
		return $nvp;
	}
	
}
