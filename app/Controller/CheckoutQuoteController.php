<?php
App::uses('CheckoutController', 'Controller');

/**
 * CakePHP CheckoutQuoteController
 * 
 * Handle Checkout processes that require quoting
 * 
 * @author dondrake
 */
class CheckoutQuoteController extends CheckoutController {

	public function index() {
		parent::index();
		$this->render('/Checkout/index');
	}
	
//	public function confirm() {
//		parent::confirm();
//		$this->render('/Checkout/confirm');
//	}
	
	public function method() {
		$this->receipt();
	}
	
	public function receipt() {
		parent::receipt();
		$this->set('acknowledgeMessage', 'Thank your for your interest. I\'ll prepare your quote and contact you.');
		if ($this->CustomerEmail->quoteRequest()) {
			$this->Purchases->outToQuote();
		}
		$this->render('/Checkout/receipt');
	}
	
}
