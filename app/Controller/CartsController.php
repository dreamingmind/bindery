<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');
App::uses('Paypal', 'Paypal.Lib');

/**
 * CakePHP Cart
 * @author dondrake
 */
class CartsController extends AppController {
	
	public $helpers = array('PurchasedProduct', 'Cart');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

	public function index($id) {
		
	}
    
    public function setupPaypalClassic() {
        $this->Paypal = new Paypal(array(
            'sandboxMode' => true,
            'nvpUsername' => 'ddrake-facilitator_api1.dreamingmind.com',
            'nvpPassword' => '1373758950',
            'nvpSignature' => 'ANrIbMXUo-yfF9kuWKgOWz14dWXXAVBcsQbD2taAL.Oggcvgh8C7SfR1'
        ));
    }

	/**
	 * Transfer to the first 'checkout' process page
	 */
	public function checkout() {
		$this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
		if ($this->Cart->cartExists()) {
			$cart = $this->Cart->retrieve();
		} else {
			$cart = array();
		}
		$this->set('cart', $cart);
		$this->set('referer', $this->referer());
	}
	
	public function pay($method) {
		$CartItem = ClassRegistry::init('CartItem');
        $this->setupPaypalClassic();
		
		$subtotal = $this->Cart->cartSubtotal();
		$tax = $this->Cart->tax();
		$shipping = $this->Cart->shipping();
		$summary = $this->Cart->summary();
		
        $order = array(
            'description' => $summary,
            'currency' => 'USD',
            'return' => 'http://localhost' . $this->request->webroot . 'carts/complete',
            'cancel' => 'http://localhost' . $this->request->webroot . 'carts/checkout',
			'items' => $CartItem->paypalClassicNvp()
        );
         try {
            $this->redirect($this->token = $this->Paypal->setExpressCheckout($order));
        } catch (Exception $e) {
            dmDebug::ddd($e->getMessage(), 'error');
            die;
        }
	}
	
	/**
     * array(
            'TOKEN' => 'EC-9S3688317D1605549',
            'BILLINGAGREEMENTACCEPTEDSTATUS' => '0',
            'CHECKOUTSTATUS' => 'PaymentActionNotInitiated',
            'TIMESTAMP' => '2014-11-14T01:05:56Z',
            'CORRELATIONID' => 'c88df0792dbc6',
            'ACK' => 'Success',
            'VERSION' => '104.0',
            'BUILD' => '13630372',
            'EMAIL' => 'janespratt@dreamingmind.com',
            'PAYERID' => 'E53U4PCQSMGWS',
            'PAYERSTATUS' => 'verified',
            'FIRSTNAME' => 'Jane',
            'LASTNAME' => 'Spratt',
            'COUNTRYCODE' => 'US',
            'SHIPTONAME' => 'Jane Spratt',
            'SHIPTOSTREET' => '1 Main St',
            'SHIPTOCITY' => 'San Jose',
            'SHIPTOSTATE' => 'CA',
            'SHIPTOZIP' => '95131',
            'SHIPTOCOUNTRYCODE' => 'US',
            'SHIPTOCOUNTRYNAME' => 'United States',
            'ADDRESSSTATUS' => 'Confirmed',
            'CURRENCYCODE' => 'USD',
            'AMT' => '32.50',
            'ITEMAMT' => '26.00',
            'SHIPPINGAMT' => '0.00',
            'HANDLINGAMT' => '0.00',
            'TAXAMT' => '6.50',
            'DESC' => 'The total for the 1 items on your cart is 0',
            'INSURANCEAMT' => '0.00',
            'SHIPDISCAMT' => '0.00',
            'L_NAME0' => 'Blue shoes',
            'L_NAME1' => 'Red trousers',
            'L_QTY0' => '1',
            'L_QTY1' => '3',
            'L_TAXAMT0' => '2.00',
            'L_TAXAMT1' => '1.50',
            'L_AMT0' => '8.00',
            'L_AMT1' => '6.00',
            'L_DESC0' => 'A pair of really great blue shoes',
            'L_DESC1' => 'Tight pair of red pants, look good with a hat.',
            'L_ITEMWEIGHTVALUE0' => '   0.00000',
            'L_ITEMWEIGHTVALUE1' => '   0.00000',
            'L_ITEMLENGTHVALUE0' => '   0.00000',
            'L_ITEMLENGTHVALUE1' => '   0.00000',
            'L_ITEMWIDTHVALUE0' => '   0.00000',
            'L_ITEMWIDTHVALUE1' => '   0.00000',
            'L_ITEMHEIGHTVALUE0' => '   0.00000',
            'L_ITEMHEIGHTVALUE1' => '   0.00000',
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
            'PAYMENTREQUEST_0_AMT' => '32.50',
            'PAYMENTREQUEST_0_ITEMAMT' => '26.00',
            'PAYMENTREQUEST_0_SHIPPINGAMT' => '0.00',
            'PAYMENTREQUEST_0_HANDLINGAMT' => '0.00',
            'PAYMENTREQUEST_0_TAXAMT' => '6.50',
            'PAYMENTREQUEST_0_DESC' => 'The total for the 1 items on your cart is 0',
            'PAYMENTREQUEST_0_INSURANCEAMT' => '0.00',
            'PAYMENTREQUEST_0_SHIPDISCAMT' => '0.00',
            'PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED' => 'false',
            'PAYMENTREQUEST_0_SHIPTONAME' => 'Jane Spratt',
            'PAYMENTREQUEST_0_SHIPTOSTREET' => '1 Main St',
            'PAYMENTREQUEST_0_SHIPTOCITY' => 'San Jose',
            'PAYMENTREQUEST_0_SHIPTOSTATE' => 'CA',
            'PAYMENTREQUEST_0_SHIPTOZIP' => '95131',
            'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE' => 'US',
            'PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME' => 'United States',
            'PAYMENTREQUEST_0_ADDRESSSTATUS' => 'Confirmed',
            'PAYMENTREQUEST_0_ADDRESSNORMALIZATIONSTATUS' => 'None',
            'L_PAYMENTREQUEST_0_NAME0' => 'Blue shoes',
            'L_PAYMENTREQUEST_0_NAME1' => 'Red trousers',
            'L_PAYMENTREQUEST_0_QTY0' => '1',
            'L_PAYMENTREQUEST_0_QTY1' => '3',
            'L_PAYMENTREQUEST_0_TAXAMT0' => '2.00',
            'L_PAYMENTREQUEST_0_TAXAMT1' => '1.50',
            'L_PAYMENTREQUEST_0_AMT0' => '8.00',
            'L_PAYMENTREQUEST_0_AMT1' => '6.00',
            'L_PAYMENTREQUEST_0_DESC0' => 'A pair of really great blue shoes',
            'L_PAYMENTREQUEST_0_DESC1' => 'Tight pair of red pants, look good with a hat.',
            'L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE0' => '   0.00000',
            'L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE1' => '   0.00000',
            'L_PAYMENTREQUEST_0_ITEMLENGTHVALUE0' => '   0.00000',
            'L_PAYMENTREQUEST_0_ITEMLENGTHVALUE1' => '   0.00000',
            'L_PAYMENTREQUEST_0_ITEMWIDTHVALUE0' => '   0.00000',
            'L_PAYMENTREQUEST_0_ITEMWIDTHVALUE1' => '   0.00000',
            'L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE0' => '   0.00000',
            'L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE1' => '   0.00000',
            'PAYMENTREQUESTINFO_0_ERRORCODE' => '0'
        )
     */
    public function complete() {
        $this->setupPaypalClassic();
		$this->scripts[] = 'order_addresses';
		debug($this->Paypal->getExpressCheckoutDetails($this->request->query['token']));
        
        
        die;
	}
	
	public function save_contacts() {
//		array(
//	'Cart' => array(
//		'first_name' => 'Jane',
//		'last_name' => 'Spratt',
//		'email' => 'janespratt@dreamingmind.com',
//		'phone' => '510 415 9987',
//		'Register' => '1'
//	)
//)
//		debug($this->request->data);
		$this->request->data('Cart.name', $this->request->data('Cart.first_name') . ' ' . $this->request->data('Cart.last_name'))
				->data('Cart.id', $this->Cart->cartId());
		
		if ($this->Cart->save($this->request->data)) {
			// clear the cache
			if ($this->request->data('Cart.Register') === '1') {
				$this->Session->setFlash('Check your email for the message to confirm your registration.', 'f_success');
			} else {
				$this->Session->setFlash('Thank you. Please proceed.', 'f_success');
			}
		} else {
			$this->Session->setFlash('There was a problem saving your contact information. Please try again.', 'f_error');
		}
		$this->layout = 'ajax';
		$this->render('/Ajax/flashOut');
	}
}
