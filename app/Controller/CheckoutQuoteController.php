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
	
	/**
	 * There is no confirmation needed during a quote request...
	 * 
	 * That's not true! Fix this so the customer can review their contact info at least.
	 */
//	public function confirm() {
//		parent::confirm();
//		$this->render('/Checkout/confirm');
//	}
	
	/**
	 * The method page is bypassed for quotes. Just send a receipt acknowledgement.
	 */
	public function method() {
		$this->receipt();
	}
	
	public function receipt() {
		parent::receipt();
		try {
			if ($this->CustomerEmail->quoteRequest($this->Purchases->retrieveCart())) {
				$this->Purchases->outToQuote();
			}
		} catch (Exception $exc) {
			dmDebug::ddd($exc, 'exception');
			$this->Session->setFlash('There was a problem sending the acknowledgement email or the email to the bindery. Please try again.', 'f_error');
		}

		$this->render('/Checkout/receipt');
	}
	
}
