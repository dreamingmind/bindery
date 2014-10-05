<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP cart
 * @author dondrake
 */
class PurchasesCompnent extends Component {
	
	/**
	 * The Cart Model
	 *
	 * @var object
	 */
	private $Cart;
	
	public $components = array('Session');

	public function initialize($controller) {
		$this->Cart = ClassRegistry::init('Cart');
	}

	public function startup($controller) {
		
	}

	public function beforeRender($controller) {
		
	}

	public function shutDown($controller) {
		
	}

	public function beforeRedirect($controller, $url, $status = null, $exit = true) {
		
	}
	
	public function itemCount() {
		return $this->Cart->count($Session);
	}

}
