<?php

/**
 * CakePHP Cart
 * @author dondrake
 */
abstract class CartHelper extends AppHelper {
	
	public $helpers = array();

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}

	public function beforeRender($viewFile) {
		parent::beforeRender($viewFile);
	}

	public function afterRender($viewFile) {
		parent::afterRender($viewFile);
	}

	public function beforeLayout($viewLayout) {
		parent::beforeLayout($viewLayout);
	}

	public function afterLayout($viewLayout) {
		parent::afterLayout($viewLayout);
	}
	
	public function contactPresent($cart) {
		$email = preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $cart['email']);
		$phone = preg_match('/[\d+]/', $cart['phone']);
		$name = preg_match("/[a-zA-Z]+/", $cart['name']);
		return $email && $phone && $name;
	}
	
	abstract public function cartItemIdInput();
	
	abstract public function submitItemButtonLabel($itemCount = NULL);
	
	abstract public function submitItemButtonBehavior();

}
