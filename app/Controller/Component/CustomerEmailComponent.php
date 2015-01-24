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
	 * Email quote request to me and to customer
	 * 
	 * @return boolean success/failure
	 */
	public function quoteRequest($cart) {
		$toolkit = $cart['toolkit'];
		
		// log the quote request
		
		// Set up the basics for Quote Request emails
		$this->Email
				->subject("{$this->controller->company['businessName']} Quote Request")
				->template('/Checkout/receipt_email', 'default')
				->helpers(array('Markdown.Markdown', 'PurchasedProduct'))
				->emailFormat('html')
				->viewVars(array(
					'cart' => $cart,
					'shipping' => new Usps($cart),
					));
				
		// Finalize and send the bindery notification of a quote request
		$this->quoteAcknowledgement('bindery', $toolkit);
		$this->Email
				->config('default')
				->from(array($this->controller->company['tech_email'] => $this->controller->company['bindery']))
				->to($this->controller->company['order_email'])
				->send()
				;
		
		// Finalize and send the customer acknowledgement of a quote request
		$this->quoteAcknowledgement('customer', $toolkit);
		$this->Email
				->config('default')
				->from(array($this->controller->company['tech_email'] => $this->controller->company['bindery']))
				->subject("Your Quote Request to {$this->controller->company['businessName']}")
				->to($toolkit->email())
				->replyTo($this->controller->company['email'])
				->send()
				;
				
		return TRUE;
	}
	
	/**
	 * Set the acknowledgement elements for quote emails
	 * 
	 * And pass in any variables required for they're rendering
	 * 
	 * @param string $type
	 * @param type $toolkit
	 */
	private function quoteAcknowledgement($type, $toolkit) {
		if ($type === 'bindery') {
			$this->Email
				->viewVars(array(
					'acknowledgeMessage' => 'quote_acknowledgement_bindery'					
				));
		} elseif ($type = 'customer') { 
			$this->Email
				->viewVars(array(
					'acknowledgeMessage' => 'quote_acknowledgement_customer',
					'company' => $this->controller->company
				));
		}
	}

}
