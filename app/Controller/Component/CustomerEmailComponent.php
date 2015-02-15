<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP CustomerEmailComponent
 * @author dondrake
 */
class CustomerEmailComponent extends Component {
	
	public $controller;
	
	public $Email;

	public function initialize(Controller $controller) {
		$this->controller = $controller;
		$this->Email = new CakeEmail();
	}

// <editor-fold defaultstate="collapsed" desc="CALLBACKS">
	public function startup(Controller $controller) {
		
	}

	public function beforeRender(Controller $controller) {
		
	}

	public function shutDown(Controller $controller) {
		
	}

	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
		
	}

	// </editor-fold>

	/**
	 * Email quote request to me and to customer
	 * 
	 * @return boolean success/failure
	 */
	public function quoteRequest($cart) {
		return $this->performParameterizedCheckoutConfirmationEmail($cart, array(
			'log' => 'logQuoteEmail',
			'exception_message' => 'There was a problem sending the acknowledgement email or the email to the bindery. Please try again.',
			'bindery_subject' => 'Quote Request', // gets company name prepended
			'bindery_template' => 'quote_acknowledgement_bindery',
			'customer_subject' => 'Your Quote Request', // gets " to company name" appended
			'customer_template' => 'quote_acknowledgement_customer'
		));
	}
	
	public function payByCreditCard($cart) {
		return $this->performParameterizedCheckoutConfirmationEmail($cart, array(
			'log' => 'logCreditCardEmail',
			'exception_message' => 'The confirmation email process failed. You\re items are still in your cart, but if you complete the Paypal Send process we\'ll both get emails regarding the payment. I\'ll manually move your items from the cart to an order.',
			'bindery_subject' => 'Order by credit card', // gets company name prepended
			'bindery_template' => 'credit_card_acknowledgement_bindery',
			'customer_subject' => 'Your Order', // gets " to company name" appended
			'customer_template' => 'credit_card_acknowledgement_customer'
		));
	}
	
	/**
	 * Email order-by-check acknowledgement to me and to customer
	 * 
	 * @return boolean success/failure
	 */
	public function payByCheck($cart) {
		return $this->performParameterizedCheckoutConfirmationEmail($cart, array(
			'log' => 'logQuoteEmail',
			'exception_message' => 'There was a problem sending the acknowledgement email or the email to the bindery. Please try again.',
			'bindery_subject' => 'Order By Check', // gets company name prepended
			'bindery_template' => 'check_acknowledgement_bindery',
			'customer_subject' => "Your Order #{$cart['toolkit']->orderNumber()}", // gets " to company name" appended
			'customer_template' => 'check_acknowledgement_customer'
		));
	}
	
	/**
	 * Email paypal-express-payment acknowledgement to me and to customer
	 * 
	 * @param array $cart A standard cart array with CartToolKitPP attached instead of the standard toolkit
	 */
	public function payByPaypalExpress($cart) {
		return $this->performParameterizedCheckoutConfirmationEmail($cart, array(
			'log' => 'logExpressEmail',
			'exception_message' => 'There was a problem sending the acknowledgement email or the email to the bindery. Your order should be ok, but you\'ll need to send me an email so I can get the details from my system manually.',
			'bindery_subject' => 'Order by Paypal Express', // gets company name prepended
			'bindery_template' => 'paypal_express_acknowledgement_bindery',
			'customer_subject' => "Your Order #{$cart['toolkit']->orderNumber()}", // gets " to company name" appended
			'customer_template' => 'paypal_express_acknowledgement_customer'
		));
	}

	/**
	 * Set up the basics of an Order Acknowledgement email
	 * 
	 * These are the main parts for an email response to any of the checkout processes. 
	 * html email, 
	 * template receipt_email, 
	 * from technical@, 
	 * reply main company address
	 * 
	 * @param array $cart The cart array with it's toolkit object
	 */
	protected function configCommonCheckoutEmailValues($cart) {
		$this->Email
				->config('default')
				->template('/Checkout/receipt_email', 'default')
				->helpers(array('Markdown.Markdown', 'PurchasedProduct'))
				->emailFormat('html')
				->from(array($this->controller->company['tech_email'] => $this->controller->company['bindery']))
				->replyTo($this->controller->company['email'])
				->viewVars(array(
					'cart' => $cart,
					'shipping' => new Usps($cart),
					'company' => $this->controller->company
					));
				
	}
	
	/**
	 * keys:
	 * 'log' => 'logQuoteEmail'
	 * 'exception_message' => 'There was a problem sending the acknowledgement email or the email to the bindery. Please try again.'
	 * 'bindery_subject' => 'Quote Request' // gets company name prepended
	 * 'bindery_template' => 'quote_acknowledgement_bindery'
	 * 'customer_subject' => 'Your Quote Request' // gets " to company name" appended
	 * 'customer_template' => 'quote_acknowledgement_customer'
	 * 
	 * @param type $cart
	 * @param type $parameters
	 */
	protected function performParameterizedCheckoutConfirmationEmail($cart, $parameters = array()) {
		extract($parameters);
		// log the quote request
		$this->controller->$log('Attempt', $cart);
		// set up the common values and body elements for a checkout acknowledgement email
		$this->configCommonCheckoutEmailValues($cart);
		try {
			// Finalize and send the bindery notification of a quote request
			$this->Email
					->subject("{$this->controller->company['businessName']} $bindery_subject")
					->to(array($this->controller->company['order_email'] => 'Estimator'))
					->viewVars(array('acknowledgeMessage' => $bindery_template))
					->send();
			// Finalize and send the customer acknowledgement of a quote request
			$this->Email
					->subject("$customer_subject to {$this->controller->company['businessName']}")
					->to(array($cart['toolkit']->email() => $cart['toolkit']->customerName()))
					->bcc($this->controller->company['email'])
					->viewVars(array('acknowledgeMessage' => $customer_template))
					->send();
			// log success
			$this->controller->$log('Success', $cart);	
		// or set flash message shown on exception
		} catch (Exception $exc) {
			dmDebug::ddd($exc->getMessage(), 'message');die;
			$this->controller->Session->setFlash($exception_message, 'f_error');
			return FALSE;
		}
		return TRUE;
	}

}
