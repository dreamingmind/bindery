<?php
App::uses('CheckoutController', 'Controller');
App::uses('CartToolKitPP', 'Lib');
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
	
//	public $components = array();
	
	/**
	 * The Payment Model
	 *
	 * @var Model
	 */
	public $Payment;
	
	/**
	 * The PayPal version of the CartToolKit
	 *
	 * @var object
	 */
	public $toolkit;
		
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
		// should this be moved back to properties set in CheckoutController?
		$cart = $this->Purchases->retrieveCart();
		$this->toolkit = new CartToolKitPP($cart);

		$CartItem = ClassRegistry::init('CartItem');
        $this->setupPaypalClassicCedentials();
		$order = $this->toolkit->pp_order(
				'https://localhost' . $this->request->webroot . 'checkout_express/confirm',
				'https://localhost' . $this->request->webroot . 'checkout_express/checkout');
		
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

	 */
	public function confirm() {
		$toolkit = new CartToolKitPP($this->Purchases->retrieveCart());
		$this->setupPaypalClassicCedentials();
		
		// to set a try-catch around this, the getExpress call 
		// must be made separately and wrapped in the try. Wrapping 
		// this compound statement doesn't get the job done.
		$this->parseExpressCheckoutDetails($this->Paypal->getExpressCheckoutDetails($this->request->query['token']), $toolkit);

		parent::confirm();
		$this->set('confirmMessage','Please confirm the accuracy of this information'
				. '<br />prior to completing your PayPal payment.');
		$this->render('/Checkout/confirm');
	}
    
	/**
	 * Make the doPayment confiming call to paypal and show a receipt
	 * 
	 * Sets up the Order and Tokens for the call, makes the call, 
	 * sends confirming email receipt and changes Cart to Order 
	 * with the trasactionID recorded in the Order record
	 * 
	 * @throws Exception
	 */
	public function receipt() {
		parent::receipt();
		//PAYMENTINFO_0_TRANSACTIONID
		// should this be moved back to properties set in CheckoutController?
		$cart = $this->Purchases->retrieveCart();
		$this->toolkit = new CartToolKitPP($cart);
		$cart['toolkit'] = $this->toolkit;

        $this->setupPaypalClassicCedentials();
		$order = $this->toolkit->pp_order(
				'https://localhost' . $this->request->webroot . 'checkout_express/receipt',
				'https://localhost' . $this->request->webroot . 'checkout_express/cancel');
		
		// these values were written to the session earlier in the checkout sequence
		$payer_id = $this->Session->read('express.payer_id');
		$token = $this->Session->read('express.token');
		try {
			$response = $this->Paypal->doExpressCheckoutPayment($order, $token, $payer_id);
			if ($response['PAYMENTINFO_0_ACK'] != 'Success' || $response['PAYMENTINFO_0_PAYMENTSTATUS'] != 'Completed') {
				
				// Some meaningful code needs to be written here to handle payment problems
				
			} 
		} catch (Exception $exc) {
			$this->Session->setFlash($exc->getMessage() . ' Could not contact PayPal. Please try again', 'f_error');
			$this->redirect('/checkout/index');
		}

		try {
			if ($this->CustomerEmail->payByPaypalExpress($cart)) {
				$this->Purchases->placeOrder($response['PAYMENTINFO_0_TRANSACTIONID'], $this->toolkit);
			} //else {
				// this is the capture point for a failed acknowledgement email
//				$this->redirect($this->referer());
//			}
		} catch (Exception $exc) {
			
		}
		ClassRegistry::init('Payment')->orderEvent(
			$this->toolkit->cartId(),
			$this->toolkit->userId(),
			'doExpressCheckout',
			json_encode($response)
		);
		
		$this->render('/Checkout/receipt');
	}
	
	/**
	 * Set endpoint and credentials
	 * 
	 * Should be moved to database config?
	 */
    protected function setupPaypalClassicCedentials() {
        $this->Paypal = new Paypal(array(
            'sandboxMode' => true,
            'nvpUsername' => 'ddrake-facilitator_api1.dreamingmind.com',
            'nvpPassword' => '1373758950',
            'nvpSignature' => 'ANrIbMXUo-yfF9kuWKgOWz14dWXXAVBcsQbD2taAL.Oggcvgh8C7SfR1'
        ));
    }
	
// <editor-fold defaultstate="collapsed" desc="doExpressCheckoutPayment() RESPONSE">
	/**
	 * array(
	 * 'TOKEN' => 'EC-9SN761957D3943646',
	 * 'SUCCESSPAGEREDIRECTREQUESTED' => 'false',
	 * 'TIMESTAMP' => '2015-01-28T00:50:29Z',
	 * 'CORRELATIONID' => '1647cc08e23de',
	 * 'ACK' => 'Success',
	 * 'VERSION' => '104.0',
	 * 'BUILD' => '15009693',
	 * 'INSURANCEOPTIONSELECTED' => 'false',
	 * 'SHIPPINGOPTIONISDEFAULT' => 'false',
	 * 'PAYMENTINFO_0_TRANSACTIONID' => '6TJ90306BH2028711',
	 * 'PAYMENTINFO_0_TRANSACTIONTYPE' => 'cart',
	 * 'PAYMENTINFO_0_PAYMENTTYPE' => 'instant',
	 * 'PAYMENTINFO_0_ORDERTIME' => '2015-01-28T00:50:28Z',
	 * 'PAYMENTINFO_0_AMT' => '224.00',
	 * 'PAYMENTINFO_0_FEEAMT' => '6.80',
	 * 'PAYMENTINFO_0_TAXAMT' => '0.00',
	 * 'PAYMENTINFO_0_CURRENCYCODE' => 'USD',
	 * 'PAYMENTINFO_0_PAYMENTSTATUS' => 'Completed',
	 * 'PAYMENTINFO_0_PENDINGREASON' => 'None',
	 * 'PAYMENTINFO_0_REASONCODE' => 'None',
	 * 'PAYMENTINFO_0_PROTECTIONELIGIBILITY' => 'Eligible',
	 * 'PAYMENTINFO_0_PROTECTIONELIGIBILITYTYPE' => 'ItemNotReceivedEligible,UnauthorizedPaymentEligible',
	 * 'PAYMENTINFO_0_SECUREMERCHANTACCOUNTID' => 'HQQ3WZK6B7UBS',
	 * 'PAYMENTINFO_0_ERRORCODE' => '0',
	 * 'PAYMENTINFO_0_ACK' => 'Success'
	 * )
	 */// </editor-fold>

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
	 * Decompose this mess ==================================================================================
	 * 
	 * Save the response to cart.log
	 * Construct and save the Shipping Address
	 * 
	 * 
	 * @param array $response Paypal getExpressCheckoutDetails() response
	 */
	private function parseExpressCheckoutDetails($response, $toolkit) {
		if ($response['ACK'] === 'Success') {
			$this->Session->write('express.token', $response['TOKEN']);
			$this->Session->write('express.payer_id', $response['PAYERID']);
//			unset($response['TOKEN']);
//			unset($response['PAYERID']);
			
//			$this->log(json_encode($response), 'cart');
			ClassRegistry::init('Payment')->orderEvent(
				$toolkit->cartId(),
				$toolkit->userId(),
				'setExpressCheckout',
				json_encode($response)
			);


			$this->request->data = $this->Purchases->retrieveCart();
			$shipAddress = array('Address' => array(
				'id' => $this->request->data['Cart']['ship_id'] == '' ? NULL : $this->request->data['Cart']['ship_id'],
				'name1' => $response['SHIPTONAME'],
				'address1' => $response['SHIPTOSTREET'],
				'city' => $response['SHIPTOCITY'],
				'state' => $response['SHIPTOSTATE'],
				'postal_code' => $response['SHIPTOZIP'],
				'country' => $response['SHIPTOCOUNTRYCODE'],
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
				'type' => 'billing',
				'name2' => '', 'address1' => '', 'address2' => '',
				'city' => '', 'state' => '', 'postal_code' => '', 'country' => ''
			));
			$Address->save($billAddress, FALSE);
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
	 * TEMP - HOLD - REWRITE
	 * 
	 * @return type
	 */
//	public function paypalClassicNvp() {
//		$cartId = $this->Cart->cartId();
//		$items = $this->find('all', array(
//			'conditions' => array('CartItem.order_id' => $cartId),
//			'contain' => false,
//		));
//		$nvp = array();
//		foreach ($items as $item) {
//			$nvp[] = array(
//				'name' => $item['CartItem']['product_name'],
////				'description' => $item['CartItem']['product_name'],
////				'tax' => $this->someTaxCalculator(),
//				'subtotal' => $item['CartItem']['price'],
//				'qty' => $item['CartItem']['quantity']
//			);
//		}
//		return $nvp;
//	}

	
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
