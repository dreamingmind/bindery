<?php
App::uses('CartHelper', 'View/Helper');

/**
 * CakePHP CartNewEntryHelper
 * @author dondrake
 */
class CartNewEntryHelper extends CartHelper {
	
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

	public function submitItemButtonLabel($itemCount = NULL) {
		if ($itemCount < 1) {
			return 'Order Now';
		} else {
			return 'Add to cart';
		}
	}

	public function cartItemIdInput() {
		return '';
	}
	
	public function submitItemButtonBehavior() {
		return 'click.addToCart';
	}
	
}
