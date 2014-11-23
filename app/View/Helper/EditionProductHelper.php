<?php
/**
 * EditionProductHelper
 * 
 * It's expected that Edition Products will always and only be linked to Collections
 * This helper will output a collection of buy buttons for all versions of the 
 * Edition where ever necessary.
 * 
 * @author dondrake
 */
class EditionProductHelper extends PurchasedProductHelper {

	public $helpers = array();

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}

	public function beforeRender($viewFile) {
		
	}

	public function afterRender($viewFile) {
		
	}

	public function beforeLayout($viewLayout) {
		
	}

	public function afterLayout($viewLayout) {
		
	}
	
	/**
	 * If there are any, output all the edition BUY buttons
	 * 
	 * @param array $editions Edition button records
	 */
	public function editionButtons($editions) {
		if (!empty($editions)) {
			foreach ($editions as $edition) {
				echo $this->Form->button('edition purchase button');
			}
		}
	}

}
