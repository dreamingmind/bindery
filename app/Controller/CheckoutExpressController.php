<?php
App::uses('CheckoutController', 'Controller');
App::uses('Paypal', 'Paypal.Lib');

/**
 * CakePHP CheckoutExpressController
 * 
 * Handle the PayPal Express Checkout process
 * 
 * @author dondrake
 */
class CheckoutExpressController extends CheckoutController {
	
	public $helpers = array('PurchasedProduct', 'Cart' => array('className' => 'CartNewEntry'));

	public $secure = array('checkout', 'checkout_address', 'complete', 'express', 'save_contacts', 'setupPaypalClassic');
	
	public $components = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	
	public function index() {
		if ($this->request->is('Post') || $this->request->is('Put')) {
			$this->set_express();
		} else {
			parent::index();
		}
		
//		$this->render('/Checkout/index');
	}

	public function set_express() {
		$CartItem = ClassRegistry::init('CartItem');
        $this->setupPaypalClassic();
		
		$subtotal = $this->Cart->cartSubtotal();
		$tax = $this->Cart->tax();
		$shipping = $this->Cart->shipping();
		$summary = $this->Cart->summary();
		
        $order = array(
            'description' => $summary,
            'currency' => 'USD',
            'return' => 'https://localhost' . $this->request->webroot . 'checkout_express/confirm',
            'cancel' => 'https://localhost' . $this->request->webroot . 'checkout_express/checkout',
			'items' => $CartItem->paypalClassicNvp()
        );
         try {
            $this->redirect($this->token = $this->Paypal->setExpressCheckout($order));
        } catch (Exception $e) {
            dmDebug::ddd($e->getMessage(), 'error');
            die;
        }
	}
	
	public function cancel() {
		$this->Session->setFlash('PayPal Express Payment was cancelled', 'f_success');
		parent::index();
	}

	/**
	 * array(
	'TOKEN' => 'EC-9SN761957D3943646',
	'SUCCESSPAGEREDIRECTREQUESTED' => 'false',
	'TIMESTAMP' => '2015-01-28T00:50:29Z',
	'CORRELATIONID' => '1647cc08e23de',
	'ACK' => 'Success',
	'VERSION' => '104.0',
	'BUILD' => '15009693',
	'INSURANCEOPTIONSELECTED' => 'false',
	'SHIPPINGOPTIONISDEFAULT' => 'false',
	'PAYMENTINFO_0_TRANSACTIONID' => '6TJ90306BH2028711',
	'PAYMENTINFO_0_TRANSACTIONTYPE' => 'cart',
	'PAYMENTINFO_0_PAYMENTTYPE' => 'instant',
	'PAYMENTINFO_0_ORDERTIME' => '2015-01-28T00:50:28Z',
	'PAYMENTINFO_0_AMT' => '224.00',
	'PAYMENTINFO_0_FEEAMT' => '6.80',
	'PAYMENTINFO_0_TAXAMT' => '0.00',
	'PAYMENTINFO_0_CURRENCYCODE' => 'USD',
	'PAYMENTINFO_0_PAYMENTSTATUS' => 'Completed',
	'PAYMENTINFO_0_PENDINGREASON' => 'None',
	'PAYMENTINFO_0_REASONCODE' => 'None',
	'PAYMENTINFO_0_PROTECTIONELIGIBILITY' => 'Eligible',
	'PAYMENTINFO_0_PROTECTIONELIGIBILITYTYPE' => 'ItemNotReceivedEligible,UnauthorizedPaymentEligible',
	'PAYMENTINFO_0_SECUREMERCHANTACCOUNTID' => 'HQQ3WZK6B7UBS',
	'PAYMENTINFO_0_ERRORCODE' => '0',
	'PAYMENTINFO_0_ACK' => 'Success'
)

	 */
	public function confirm() {
        $this->setupPaypalClassic();
		$this->parseExpressCheckoutDetails($this->Paypal->getExpressCheckoutDetails($this->request->query['token']));
//		$this->request->data = $this->Purchases->retrieveCart();
		parent::confirm();
		$this->set('confirmMessage','Please confirm the accuracy of this information'
				. '<br />prior to completing your PayPal payment.');
		$this->render('/Checkout/confirm');
	}
    
	public function receipt() {
		$CartItem = ClassRegistry::init('CartItem');
        $this->setupPaypalClassic();
		
		$subtotal = $this->Cart->cartSubtotal();
		$tax = $this->Cart->tax();
		$shipping = $this->Cart->shipping();
		$summary = $this->Cart->summary();
		
        $order = array(
            'description' => $summary,
            'currency' => 'USD',
            'return' => 'https://localhost' . $this->request->webroot . 'checkout_express/receipt',
            'cancel' => 'https://localhost' . $this->request->webroot . 'checkout_express/cancel',
			'items' => $CartItem->paypalClassicNvp()
        );
//        $this->setupPaypalClassic();
//		$order = ClassRegistry::init('CartItem')->paypalClassicNvp();
		$payer_id = $this->Session->read('express.payer_id');
		$token = $this->Session->read('express.token');
		dmDebug::ddd($this->Paypal->doExpressCheckoutPayment($order, $token, $payer_id), 'do exprees checkout');
		parent::receipt();
	}
	
    protected function setupPaypalClassic() {
        $this->Paypal = new Paypal(array(
            'sandboxMode' => true,
            'nvpUsername' => 'ddrake-facilitator_api1.dreamingmind.com',
            'nvpPassword' => '1373758950',
            'nvpSignature' => 'ANrIbMXUo-yfF9kuWKgOWz14dWXXAVBcsQbD2taAL.Oggcvgh8C7SfR1'
        ));
    }
	
// <editor-fold defaultstate="collapsed" desc="getExpressCheckoutDetails() RESPONSE">
	/**
	 * Paypal response after return from getExpressCheckoutDetails 
	 * 
	 *	array(
	 *		'TOKEN' => 'EC-0YU02221E64022802',
	 *		'BILLINGAGREEMENTACCEPTEDSTATUS' => '0',
	 *		'BILLINGAGREEMENTACCEPTEDSTATUS' => '0',
	 *	 	'CHECKOUTSTATUS' => 'PaymentActionNotInitiated',
	 *		'TIMESTAMP' => '2014-12-24T19:03:59Z',
	 *		'CORRELATIONID' => '21b48366ed808',
	 *		'ACK' => 'Success',
	 *		'VERSION' => '104.0',
	 *		'BUILD' => '14443165',
	 *		'EMAIL' => 'janespratt@dreamingmind.com',
	 *		'PAYERID' => 'E53U4PCQSMGWS',
	 *		'PAYERSTATUS' => 'verified',
	 *		'FIRSTNAME' => 'Jane',
	 *		'LASTNAME' => 'Spratt',
	 *		'COUNTRYCODE' => 'US',
	 *		'SHIPTONAME' => 'Jane Spratt',
	 *		'SHIPTOSTREET' => '1 Main St',
	 *		'SHIPTOCITY' => 'San Jose',
	 *		'SHIPTOSTATE' => 'CA',
	 *		'SHIPTOZIP' => '95131',
	 *		'SHIPTOCOUNTRYCODE' => 'US',
	 *		'SHIPTOCOUNTRYNAME' => 'United States',
	 *		'ADDRESSSTATUS' => 'Confirmed',
	 *		'CURRENCYCODE' => 'USD',
	 *		'AMT' => '66.00',
	 *		'ITEMAMT' => '66.00',
	 *		'SHIPPINGAMT' => '0.00',
	 *		'HANDLINGAMT' => '0.00',
	 *		'TAXAMT' => '0.00',
	 *		'DESC' => '2 items in your cart.',
	 *		'INSURANCEAMT' => '0.00',
	 *		'SHIPDISCAMT' => '0.00',
	 *		'L_NAME0' => 'Notebook',
	 *		'L_NAME1' => 'Portfolio',
	 *		'L_QTY0' => '1',
	 *		'L_QTY1' => '1',
	 *		'L_TAXAMT0' => '0.00',
	 *		'L_TAXAMT1' => '0.00',
	 *		'L_AMT0' => '0.00',
	 *		'L_AMT1' => '66.00',
	 *		'L_ITEMWEIGHTVALUE0' => '   0.00000',
	 *		'L_ITEMWEIGHTVALUE1' => '   0.00000',
	 *		'L_ITEMLENGTHVALUE0' => '   0.00000',
	 *		'L_ITEMLENGTHVALUE1' => '   0.00000',
	 *		'L_ITEMWIDTHVALUE0' => '   0.00000',
	 *		'L_ITEMWIDTHVALUE1' => '   0.00000',
	 *		'L_ITEMHEIGHTVALUE0' => '   0.00000',
	 *		'L_ITEMHEIGHTVALUE1' => '   0.00000',
	 *		'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
	 *		'PAYMENTREQUEST_0_AMT' => '66.00',
	 *		'PAYMENTREQUEST_0_ITEMAMT' => '66.00',
	 *		'PAYMENTREQUEST_0_SHIPPINGAMT' => '0.00',
	 *		'PAYMENTREQUEST_0_HANDLINGAMT' => '0.00',
	 *		'PAYMENTREQUEST_0_TAXAMT' => '0.00',
	 *		'PAYMENTREQUEST_0_DESC' => '2 items in your cart.',
	 *		'PAYMENTREQUEST_0_INSURANCEAMT' => '0.00',
	 *		'PAYMENTREQUEST_0_SHIPDISCAMT' => '0.00',
	 *		'PAYMENTREQUEST_0_INSURANCEOPTIONOFFERED' => 'false',
	 *		'PAYMENTREQUEST_0_SHIPTONAME' => 'Jane Spratt',
	 *		'PAYMENTREQUEST_0_SHIPTOSTREET' => '1 Main St',
	 *		'PAYMENTREQUEST_0_SHIPTOCITY' => 'San Jose',
	 *		'PAYMENTREQUEST_0_SHIPTOSTATE' => 'CA',
	 *		'PAYMENTREQUEST_0_SHIPTOZIP' => '95131',
	 *		'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE' => 'US',
	 *		'PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME' => 'United States',
	 *		'PAYMENTREQUEST_0_ADDRESSSTATUS' => 'Confirmed',
	 *		'PAYMENTREQUEST_0_ADDRESSNORMALIZATIONSTATUS' => 'None',
	 *		'L_PAYMENTREQUEST_0_NAME0' => 'Notebook',
	 *		'L_PAYMENTREQUEST_0_NAME1' => 'Portfolio',
	 *		'L_PAYMENTREQUEST_0_QTY0' => '1',
	 *		'L_PAYMENTREQUEST_0_QTY1' => '1',
	 *		'L_PAYMENTREQUEST_0_TAXAMT0' => '0.00',
	 *		'L_PAYMENTREQUEST_0_TAXAMT1' => '0.00',
	 *		'L_PAYMENTREQUEST_0_AMT0' => '0.00',
	 *		'L_PAYMENTREQUEST_0_AMT1' => '66.00',
	 *		'L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE0' => '   0.00000',
	 *		'L_PAYMENTREQUEST_0_ITEMWEIGHTVALUE1' => '   0.00000',
	 *		'L_PAYMENTREQUEST_0_ITEMLENGTHVALUE0' => '   0.00000',
	 *		'L_PAYMENTREQUEST_0_ITEMLENGTHVALUE1' => '   0.00000',
	 *		'L_PAYMENTREQUEST_0_ITEMWIDTHVALUE0' => '   0.00000',
	 *		'L_PAYMENTREQUEST_0_ITEMWIDTHVALUE1' => '   0.00000',
	 *		'L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE0' => '   0.00000',
	 *		'L_PAYMENTREQUEST_0_ITEMHEIGHTVALUE1' => '   0.00000',
	 *		'PAYMENTREQUESTINFO_0_ERRORCODE' => '0'
	 *	)
	 * 
  	 */// </editor-fold>
	/**
	 * Process the Express Checkout Deatails returned from Paypal
	 * 
	 * Save the response to cart.log
	 * Construct and save the Shipping Address
	 * 
	 * 
	 * @param array $response Paypal getExpressCheckoutDetails() response
	 */
	private function parseExpressCheckoutDetails($response) {
		if ($response['ACK'] === 'Success') {
			$this->Session->write('express.token', $response['TOKEN']);
			$this->Session->write('express.payer_id', $response['PAYERID']);
			unset($response['TOKEN']);
			unset($response['PAYERID']);
			$this->log(json_encode($response), 'cart');


			$this->request->data = $this->Purchases->retrieveCart();
			$shipAddress = array('Address' => array(
					'id' => $this->request->data['Cart']['ship_id'] == '' ? NULL : $this->request->data['Cart']['ship_id'],
					'name1' => $response['SHIPTONAME'],
					'address1' => $response['SHIPTOSTREET'],
					'city' => $response['SHIPTOCITY'],
					'state' => $response['SHIPTOSTATE'],
					'postal_code' => $response['SHIPTOZIP'],
					'coutnry' => $response['SHIPTOCOUNTRYCODE'],
					'foreign_key' => $this->request->data['Cart']['id'],
					'foreign_table' => 'Cart',
					'type' => 'shipping'
			));
			$Address = ClassRegistry::init('AddressModule.Address');
			$Address->save($shipAddress);
			
			$this->request->data('Cart.ship_id', $Address->id);
			$billAddress = array('Address' => array(
					'id' => $this->request->data['Cart']['bill_id'] == '' ? NULL : $this->request->data['Cart']['bill_id'],
					'name1' => 'On file with PayPal',
					'foreign_key' => $this->request->data['Cart']['id'],
					'foreign_table' => 'Cart',
					'type' => 'billing'
			));
			$Address->save($billAddress);
			$this->request->data('Cart.bill_id', $Address->id)
					->data('Cart.name', $response['FIRSTNAME'] . ' ' . $response['LASTNAME'])
					->data('Cart.email', $response['EMAIL']);
			$this->Cart->save($this->request->data);
			
			// log something here
			
		} else {
			$this->Session->setFlash("Paypal's response was {$response['ACK']}. Please try again.");
			// log something.
			// $result['PAYMENTREQUESTINFO_0_ERRORCODE']
		}
 }
	

 /**
	 * Gather contact and shipping information for pay-by-check customers.
	 * 
	 * This is the full edit page for the cart. But 
	 */
	public function checkout_address() {
		$this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
		$this->scripts[] = 'order_addresses';
		$this->request->data = $this->Purchases->retrieveCart();		
	}
	
	/**
	 * Forced collection of contact info for shopping carts
	 */
//	public function save_contacts() {
//
//		$this->request->data('Cart.name', $this->request->data('Cart.first_name') . ' ' . $this->request->data('Cart.last_name'))
//				->data('Cart.id', $this->Cart->cartId());
//		// if this is a logged in user, we'll update their account with this info too
//		// possibly some is different, but we're going to assume new is best.
//		if ($this->Auth->user('id')) {
//			$this->request->data('Cart.user_id', $this->Auth->user('id'))
//				->data('Customer.id', $this->Auth->user('id'))
//				->data('Customer.registration_date', $this->Auth->user('registration_date'))
//				->data('Customer.first_name', $this->request->data('Cart.first_name'))
//				->data('Customer.last_name', $this->request->data('Cart.last_name'))
//				->data('Customer.phone', $this->request->data('Cart.phone'))
//				->data('Customer.email', $this->request->data('Cart.email'));
//		}
//				
//		if ($this->Cart->saveAssociated($this->request->data)) {
//			if ($this->request->data('Cart.Register') === '1') {
//				
//				// I'm disabling this for now. Turn the input back on and write some code to do this.
//				$this->Session->setFlash('Check your email for the message to confirm your registration.', 'f_success');
//			} else {
//				$this->Session->setFlash('Thank you. Please proceed.', 'f_success');
//			}
//		} else {
//			$this->Session->setFlash('There was a problem saving your contact information. Please try again.', 'f_error');
//		}
//		$this->layout = 'ajax';
//		$this->render('/Ajax/flashOut');
//	}
}
