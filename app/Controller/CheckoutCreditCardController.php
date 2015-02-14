<?php
App::uses('CheckoutController', 'Controller');

/**
 * CakePHP CheckoutCreditCardController
 * 
 * Base controller class for checkout using a credit card
 * 
 * @author dondrake
 */
class CheckoutCreditCardController extends CheckoutController {

	/**
	 * Confirm details of order by credit card
	 */
	public function confirm() {
		parent::confirm();
		$this->set('confirmMessage','Review your order then press <span>Confirm</span>.');
//		$this->render('/Checkout/confirm');
	}

	public function receipt() {
		parent::receipt();
		$this->set('acknowledgeMessage', 'Thank you for your interest in Dreaming Mind products.'
				. '<br />Your order has been sent to the bindery.'
				. '<br />Work will start on your project after your payment or deposit is received.');
		try {
			$cart = $this->Purchases->retrieveCart();
			if ($this->CustomerEmail->payByCreditCard($cart)) {
				$this->Purchases->placeOrder('CreditCard', $cart['toolkit']);
			} else {
				dmDebug::ddd($this->referer(), 'going to redirect. email failed');die;
				// this is the capture point for a failed acknowledgement email
				$this->redirect($this->referer());
			}
		} catch (Exception $exc) {
			debug('placeOrder failed');
			// this is the capture point for a failed state change on the cart record
			$this->Session->setFlash(
					'<p>Notification has been sent.</p>'
					. '<p>There was a problem moving your cart to \'Order\' status, so all the items are still there.</p>'
					. '<p>There is no reason to resubmit your request.</p>', 'f_error');
		}

		$this->render('/Checkout/receipt');
	}
}
