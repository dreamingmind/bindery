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
		$this->set('confirmMessage','Please confirm the accuracy of this information'
				. '<br />prior to placing your order.');
//		$this->render('/Checkout/confirm');
	}

}
