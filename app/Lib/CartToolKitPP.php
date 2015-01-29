<?php

App::uses('CartToolKit', 'Lib');
App::uses('Usps', 'Model');
/**
 * Description of CartToolKitPP
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
	 * 
	 * @param string $return
	 * @param string $cancel
	 * @param type $currency
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
	
	protected function assembleOrderItems() {
		$nvp = array();
		foreach ($this->items as $index => $item) {
			$this->itemIndex = $index;
			$nvp[] = array(
				'name' => $this->itemValue('name'),
				'description' => $this->itemValue('blurb') . ' - ' . $this->itemValue('options'),
				'tax' => $this->itemTax($index),
				'subtotal' => $this->itemValue('price'),
				'qty' => $this->itemValue('quantity')
			);
		}
		return $nvp;
	}
	
}
