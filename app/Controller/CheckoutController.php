<?php
App::uses('AppController', 'Controller');
App::uses('CheckoutInterface', 'Lib');
App::uses('AddressModule.Address', 'Model');
App::uses('Usps', 'Model');

/**
 * CakePHP CheckoutController
 * 
 * Base controller class for the various checkout processes
 * 
 * @author dondrake
 */
class CheckoutController extends AppController implements CheckoutInterface {

	public $helpers = array('PurchasedProduct', 'Cart' => array('className' => 'cartNewEntry'));

	public $secure = array('checkout', 'checkout_address', 'complete', 'express', 'save_contacts', 'setupPaypalClassic');
	
	public $components = array('Checkout');
	
	public $uses = array('Cart');
		
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
	 * The page also shows contact and address forms which must be filled out. 
	 * Submitting the form comes back here where the form-save process is 
	 * delegated to address which will redirect to the next step or return 
	 * here for page re-render as appropriate.
	 * 
	 * In the future, registered users will also be able to 
	 * send items to their wish list
	 * 
	 * Choosing a payment option will advance the checkout process. 
	 * By Check (this->checkout_address()) and 
	 * PayPal (this->express()) are the current choices
	 */
	public function index() {
		if (!$this->request->is('get')) {
			$this->address();
			// handle possible return from address due to data problems
		}
		
		if ($this->Purchases->cartExists()) {
			$cart = $this->Purchases->retrieveCart();
		} else {
			$this->Checkout->doNoCartRedirect();
		}

		// setting data for the view is a bit messy
		$this->request->data = $cart; // not used yet

		// for the fieldset helper (Element/email.ctp)
		$this->set('model', 'Cart');
		$this->set('record', $cart);
		$this->set('fieldsetOptions', array('class' => 'contact'));

		// for the rest of the view
		$this->set('cart', $cart);
		$this->set('referer', $this->referer());
		$this->set('contentDivIdAttr', 'checkout');
		$this->layout = 'checkout'; 
		
	}
	
	/**
	 * Handle data submission from checkout/index
	 * 
	 * Save sumbitted contact info, addresses and link everything together. 
	 * Then pull the shipping cost. If everything goes well, redirect to 
	 * the method page. Otherwise, return and let the index page re-render 
	 * with appropriate error messaging.
	 */
	public function address() {
		$this->layout = 'checkout'; 

		$this->request->data('Shipping.foreign_table', 'Cart')
				->data('Shipping.foreign_key', $this->request->data['Cart']['id'])
				->data('Shipping.type', 'shipping')
				->data('Billing.foreign_table', 'Cart')
				->data('Billing.foreign_key', $this->request->data['Cart']['id'])
				->data('Billing.type', 'billing');
		try {
//			$this->Session->setFlash('This is an error message', 'f_error');
//			return;
			$Address = ClassRegistry::init('AddressModule.Address');
			
			$Address->create();
			$Address->save($this->request->data['Shipping']);
			$shipId = $Address->id;
			
			$Address->create();
			$Address->save($this->request->data['Billing']);
			$billId = $Address->id;
			
			$this->request->data('Cart.ship_id', $shipId)
					->data('Cart.bill_id', $billId);
			$this->Cart->save($this->request->data['Cart']);
			
			// need to detect problems and return to checkout in those cases
			// like bad state? or bad zip?
			
		} catch (Exception $exc) {
			echo $exc->getTraceAsString();
		}

		$this->redirect('method');
	}
	
	protected function prepareCartObjects() {
		if ($this->Purchases->cartExists()) {
			$cart = $this->Purchases->retrieveCart();
		} else {
			$this->Checkout->doNoCartRedirect();
		}
		$this->set('cart', $cart);
		$this->set('shipping', new Usps($cart));
	}
		
	public function method() {
		
		$this->prepareCartObjects();
		// for the fieldset helper (Element/email.ctp)
		$this->set('model', 'Cart');
		$this->set('fieldsetOptions', array('class' => 'contact'));

		// for the rest of the view
		$this->set('referer', $this->referer()); // take care of elsewhere? 
		$this->set('contentDivIdAttr', 'checkout'); // what is this for?
		$this->layout = 'checkout'; 
		
		$this->render('method');
	}
	
	public function confirm() {
		
	}
	
	public function receipt() {
		$this->layout = 'checkout'; 
		$this->prepareCartObjects();
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
