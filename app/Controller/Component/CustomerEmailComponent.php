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

	public $components = array();
	
	public $controller;
	
	public $Email;

	public function initialize(Controller $controller) {
		$this->controller = $controller;
		$this->Email = new CakeEmail();
	}

	public function startup(Controller $controller) {
		
	}

	public function beforeRender(Controller $controller) {
		
	}

	public function shutDown(Controller $controller) {
		
	}

	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
		
	}
	
	/**
	 * Email quote request to me and cc to customer
	 * 
	 * @return boolean success/failure
	 */
	public function quoteRequest($cart) {
		$toolkit = $cart['toolkit'];
		// log the quote request
		debug('emailing the quote');
		$this->Email
				->subject("{$this->controller->company['businessName']} Quote Request")
				->template('/Checkout/receipt_email', 'default')
				->helpers(array('Markdown.Markdown', 'PurchasedProduct'))
				->emailFormat('html')
				->viewVars(array(
					'cart' => $cart,
					'shipping' => new Usps($cart),
					'acknowledgeMessage' => "A quote request from {$toolkit->customerName()} at {$toolkit->email()}"
					));

		$this->Email
				->config('default')
				->from(array($this->controller->company['tech_email'] => $this->controller->company['bindery']))
				->to($this->controller->company['order_email'])
//				->cc($toolkit->email())
//				->replyTo($this->controller->company['email'])
				->send()
				;
		$this->Email
				->config('default')
				->from(array($this->controller->company['tech_email'] => $this->controller->company['bindery']))
//				->to($this->controller->company['order_email'])
				->subject("Your Quote Request to {$this->controller->company['businessName']}")
				->to($toolkit->email())
				->replyTo($this->controller->company['email'])
				->viewVars(array('acknowledgeMessage' => "Thank you for your interest. Your quote has been sent to the bindery for review."))
				->send()
				;
		return TRUE;
	}

}
