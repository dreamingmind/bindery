<?php

App::uses('PurchasedProductHelper', 'Helper');

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

//	public $helpers = array();

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
	 * Blurb creation method
	 * 
	 * Editions have the blurb stored in the Supplement record
	 * 
	 * @param array $item
	 * @param string $mode
	 * @return string
	 */
	public function blurb($item, $mode) {
		$edition = unserialize($item['Supplement']);
		$blurb = $edition['Edition']['blurb'];
		$summary = $this->Html->para(NULL, String::truncate($blurb, 40), array('class' => 'blurb'));
		$full = $this->Html->para(NULL, $blurb, array('class' => 'blurb'));
		$this->storeToggleData($item, 'blurb', $summary, $full);
		
		if ($mode === 'item_summary') {
			$text = $summary;
		} else {
			$text = $full;
		}
		return $text;
	}
	
	/**
	 * If there are any, output all the edition BUY buttons
	 * 
	 * ALL CALLS TO THIS METHOD HAVE BEEN DISABLED ========================================*******!!!!!!!!!!
	 * 
	 * @param array $editions Edition button records
	 */
	public function editionButton($edition) {
		if ($edition['available']) {
			
			echo $this->Form->button('edition purchase button');
		}
	}

}
