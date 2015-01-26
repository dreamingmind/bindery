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
	public function confirm() {
		parent::confirm();
		$this->set('confirmMessage','Please confirm the accuracy (double check your email address)<br />of this information prior to submitting your cart for quote.');
		$this->render('/Checkout/confirm');
	}
	
	/**
	 * The method page is bypassed for quotes..
	 */
	public function method() {
		$this->confirm();
	}
	
	public function receipt() {
		parent::receipt();
		$this->set('acknowledgeMessage', 'Thank you for your interest in Dreaming Mind products.<br />Your items have been submitted for quote.');
		try {
			if ($this->CustomerEmail->quoteRequest($this->Purchases->retrieveCart())) {
				$this->Purchases->outToQuote();
			} else {
				// this is the capture point for a failed acknowledgement email
				$this->redirect($this->referer());
			}
		} catch (Exception $exc) {
			// this is the capture point for a failed state change on the cart record
			$this->Session->setFlash(
					'<p>Notification has been sent.</p>'
					. '<p>There was a problem clearing your cart, so all the items are still there.</p>'
					. '<p>There is no reason to resubmit your request.</p>', 'f_error');
		}

		$this->render('/Checkout/receipt');
	}
	
}
