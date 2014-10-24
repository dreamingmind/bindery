<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP CustomProductHelper
 * @author dondrake
 */
class CustomProductHelper extends PurchasedProductHelper {

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
	
	public function blurb($item, $mode) {
		$text = 'This is a sample burb. I don\'t think custom items will have blurbs, but they must have an implementation of the function';
		if ($mode === 'item_summary') {
			$text = String::truncate($text, 40);
		} else {
			$text = $text;
		}
		return $this->Html->para(NULL, $text);
	}
	
	public function optionList($item, $mode) {
		$options = array(
			'closing belt',
			'pen loop',
			'title: "SAS" gold, front lower right',
			'Please give me a call if there is any problem getting the baby-shit green leather.'
		);
		if ($mode === 'item_summary') {
			$text = $this->Html->para(NULL, String::truncate(implode(' • ', $options), 40));
		} else {
			$text = $this->Html->nestedList($options);
		}
		return $text;
	}

}
