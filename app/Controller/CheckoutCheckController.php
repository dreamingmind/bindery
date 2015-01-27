<?php
App::uses('CheckoutController', 'Controller');

/**
 * CakePHP CheckoutCheckController
 * 
 * Base controller class for checkout using a check
 * 
 * @author dondrake
 */
class CheckoutCheckController extends CheckoutController {

	/**
	 * Confirm details of order by check
	 */
	public function confirm() {
		parent::confirm();
		$this->set('confirmMessage','Please confirm the accuracy of this information'
				. '<br />prior to placing your order.');
		$this->render('/Checkout/confirm');
	}
	
	public function receipt() {
		parent::receipt();
		$this->set('acknowledgeMessage', 'Thank you for your interest in Dreaming Mind products.'
				. '<br />Your order has been sent to the bindery.'
				. '<br />Work will start on your project after your payment or deposit is received.');
		try {
			$cart = $this->Purchases->retrieveCart();
			if ($this->CustomerEmail->payByCheck($cart)) {
				$this->Purchases->placeOrder('Check', $cart['toolkit']);
			} else {
				// this is the capture point for a failed acknowledgement email
				$this->redirect($this->referer());
			}
		} catch (Exception $exc) {
			// this is the capture point for a failed state change on the cart record
			$this->Session->setFlash(
					'<p>Notification has been sent.</p>'
					. '<p>There was a problem moving your cart to \'Order\' status, so all the items are still there.</p>'
					. '<p>There is no reason to resubmit your request.</p>', 'f_error');
		}

		$this->render('/Checkout/receipt');
	}
	
}
