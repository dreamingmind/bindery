<?php
App::uses('AppController', 'Controller');
App::uses('Checkout', 'Lib');

/**
 * CakePHP CheckoutController
 * 
 * Base controller class for the various checkout processes
 * 
 * @author dondrake
 */
class CheckoutController extends AppController implements Checkout {

	public $helpers = array('PurchasedProduct', 'Cart' => array('className' => 'cartNewEntry'));

	public $secure = array('checkout', 'checkout_address', 'complete', 'express', 'save_contacts', 'setupPaypalClassic');
	
	public $components = array();
	
	public $uses = array('Cart');
	
	public $layout = 'checkout';
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
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
	public function index() {
		$this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
		if ($this->Cart->cartExists()) {
			$cart = $this->Cart->retrieve();
		} else {
			$cart = array();
		}
		$this->set('cart', $cart);
		$this->set('referer', $this->referer());
		$this->layout = 'checkout'; 
		$this->render('/Carts/checkout');
	}
	
	public function address() {
		
	}
	
	public function method() {
		
	}
	
	public function confirm() {
		
	}
	
	public function recipt() {
		
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
		$this->request->data = $this->Cart->retrieve();
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
		$this->request->data = $this->Cart->retrieve();		
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
