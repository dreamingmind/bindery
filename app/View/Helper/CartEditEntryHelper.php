<?php
App::uses('CartHelper', 'View/Helper');

/**
 * CakePHP CartEditEntryHelper
 * @author dondrake
 */
class CartEditEntryHelper extends CartHelper {
	
	public $helpers = array('Form');

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
	
	public function cartItemIdInput() {
		return "\n" . $this->Form->input('CartItem.id', array('type' => 'hidden')) . "\n";
	}

	public function submitItemButtonLabel($itemCount = NULL) {
		return 'Save Changes';
	}
	
	public function submitItemButtonBehavior() {
		return 'click.saveChangesToCart';
	}
	
}
