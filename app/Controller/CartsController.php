<?php
App::uses('AppController', 'Controller');
App::uses('Paypal', 'Paypal.Lib');

/**
 * CakePHP Cart
 * @author dondrake
 */
class CartsController extends AppController {
	
	public $helpers = array('PurchasedProduct', 'Cart' => array('className' => 'CartNewEntry'));

	public $secure = array('checkout', 'checkout_address', 'complete', 'express', 'save_contacts', 'setupPaypalClassic');
	
	public $components = array();
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

	public function index() {
		$this->redirect(array('controller' => 'orders', 'action' => 'index'));
	}
	public function view($id) {
		$this->redirect(array('controller' => 'orders', 'action' => 'view', $id));
	}
//	public function index($id) {
//		$this->redirect(array('controller' => 'orders', 'action' => 'index', 'pass' => $id));
//	}
//	public function index($id) {
//		$this->redirect(array('controller' => 'orders', 'action' => 'index', 'pass' => $id));
//	}
    
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
	 * 
	 * This is the first page presentation where registered/anon users 
	 * see all the full summaries of their cart items. They can cange item 
	 * quantities or remove items from their cart.
	 * 
	 * In the future, registered users will also be able to 
	 * send items to their wish list
	 * 
	 * Choosing a payment option will advance the checkout process. 
	 * By Check (this->checkout_address()) and 
	 * PayPal (this->express()) are the current choices
	 */
	public function checkout() {
		$this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
		if ($this->Purchases->cartExists()) {
			$cart = $this->Purchases->retrieveCart();
		} else {
			$cart = array();
		}
		$Usps = ClassRegistry::init('Usps');
		$this->set('shipping', $Usps->estimate($cart));
		$this->set('cart', $cart);
		$this->set('referer', $this->referer());
	}
	
	/**
	 * Paypal Express Checkout
	 * 
	 * Set the vars needed for the nvp package and use the 
	 * Paypal plugin to set up the checkout. On success redirect
	 * 
	 * There is no detection of failed setup yet ===============================================******************************!!!!!!!!!!!!!!!!!!!!!!no error trap
	 */
//	public function express() {
//		$CartItem = ClassRegistry::init('CartItem');
//        $this->setupPaypalClassic();
//		
//		$subtotal = $this->Cart->cartSubtotal();
//		$tax = $this->Cart->tax();
//		$shipping = $this->Cart->shipping();
//		$summary = $this->Cart->summary();
//		
//        $order = array(
//            'description' => $summary,
//            'currency' => 'USD',
//            'return' => 'https://localhost' . $this->request->webroot . 'carts/complete',
//            'cancel' => 'https://localhost' . $this->request->webroot . 'carts/checkout',
//			'items' => $CartItem->paypalClassicNvp()
//        );
//         try {
//            $this->redirect($this->token = $this->Paypal->setExpressCheckout($order));
//        } catch (Exception $e) {
//            dmDebug::ddd($e->getMessage(), 'error');
//            die;
//        }
//	}
	
	private function parseExpressCheckoutDetails($response) {
		if ($response['ACK'] === 'Success') {
			unset($response['TOKEN']);
			unset($response['CORRELATIONID']);
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
			$Address->save($shipAddress);
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
	 * The final confirmation of the order after all data collection
	 * 
	 * This is it. Pull the trigger. 
	 * There will need to be a switch here to control the next destination. 
	 * If we are here from the pay-by-check path, then we'll go directly to 
	 * the Thanks page and will have to handle email notifications. 
	 * If we're here from the setExpress return, then the next step will be 
	 * doExpress and we'll go on to the Thanks page after successful response.
	 * 
	 */
    public function complete() {
        $this->setupPaypalClassic();
		$this->parseExpressCheckoutDetails($this->Paypal->getExpressCheckoutDetails($this->request->query['token']));
		$this->Paypal->doExpressCheckoutPayment();
		$this->request->data = $this->Purchases->retrieveCart();
	}
	
	/**
	 * Paypal response after return from getExpressCheckoutDetails 
	 * 
     * array(
	'TOKEN' => 'EC-0YU02221E64022802',
	'BILLINGAGREEMENTACCEPTEDSTATUS' => '0',
	'CHECKOUTSTATUS' => 'PaymentActionNotInitiated',
	'TIMESTAMP' => '2014-12-24T19:03:59Z',
	'CORRELATIONID' => '21b48366ed808',
	'ACK' => 'Success',
	'VERSION' => '104.0',
	'BUILD' => '14443165',
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
	'AMT' => '66.00',
	'ITEMAMT' => '66.00',
	'SHIPPINGAMT' => '0.00',
	'HANDLINGAMT' => '0.00',
	'TAXAMT' => '0.00',
	'DESC' => '2 items in your cart.',
	'INSURANCEAMT' => '0.00',
	'SHIPDISCAMT' => '0.00',
	'L_NAME0' => 'Notebook',
	'L_NAME1' => 'Portfolio',
	'L_QTY0' => '1',
	'L_QTY1' => '1',
	'L_TAXAMT0' => '0.00',
	'L_TAXAMT1' => '0.00',
	'L_AMT0' => '0.00',
	'L_AMT1' => '66.00',
	'L_ITEMWEIGHTVALUE0' => '   0.00000',
	'L_ITEMWEIGHTVALUE1' => '   0.00000',
	'L_ITEMLENGTHVALUE0' => '   0.00000',
	'L_ITEMLENGTHVALUE1' => '   0.00000',
	'L_ITEMWIDTHVALUE0' => '   0.00000',
	'L_ITEMWIDTHVALUE1' => '   0.00000',
	'L_ITEMHEIGHTVALUE0' => '   0.00000',
	'L_ITEMHEIGHTVALUE1' => '   0.00000',
	'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
	'PAYMENTREQUEST_0_AMT' => '66.00',
	'PAYMENTREQUEST_0_ITEMAMT' => '66.00',
	'PAYMENTREQUEST_0_SHIPPINGAMT' => '0.00',
	'PAYMENTREQUEST_0_HANDLINGAMT' => '0.00',
	'PAYMENTREQUEST_0_TAXAMT' => '0.00',
	'PAYMENTREQUEST_0_DESC' => '2 items in your cart.',
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
	'L_PAYMENTREQUEST_0_NAME0' => 'Notebook',
	'L_PAYMENTREQUEST_0_NAME1' => 'Portfolio',
	'L_PAYMENTREQUEST_0_QTY0' => '1',
	'L_PAYMENTREQUEST_0_QTY1' => '1',
	'L_PAYMENTREQUEST_0_TAXAMT0' => '0.00',
	'L_PAYMENTREQUEST_0_TAXAMT1' => '0.00',
	'L_PAYMENTREQUEST_0_AMT0' => '0.00',
	'L_PAYMENTREQUEST_0_AMT1' => '66.00',
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
	 * 
	 */
	
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
	public function save_contacts() {

		$this->request->data('Cart.name', $this->request->data('Cart.first_name') . ' ' . $this->request->data('Cart.last_name'))
				->data('Cart.id', $this->Cart->cartId());
		// if this is a logged in user, we'll update their account with this info too
		// possibly some is different, but we're going to assume new is best.
		if ($this->Auth->user('id')) {
			$this->request->data('Cart.user_id', $this->Auth->user('id'))
				->data('Customer.id', $this->Auth->user('id'))
				->data('Customer.registration_date', $this->Auth->user('registration_date'))
				->data('Customer.first_name', $this->request->data('Cart.first_name'))
				->data('Customer.last_name', $this->request->data('Cart.last_name'))
				->data('Customer.phone', $this->request->data('Cart.phone'))
				->data('Customer.email', $this->request->data('Cart.email'));
		}
				
		if ($this->Cart->saveAssociated($this->request->data)) {
			if ($this->request->data('Cart.Register') === '1') {
				
				// I'm disabling this for now. Turn the input back on and write some code to do this.
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
