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

}
