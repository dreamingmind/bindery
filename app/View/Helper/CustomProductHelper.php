<?php

App::uses('PurchasedProductHelper', 'Helper');

/**
 * CakePHP CustomProductHelper
 * @author dondrake
 */
class CustomProductHelper extends AppHelper {

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
	 * Store the design name text variants and return the currently required version
	 * 
	 * Overrides PurchasedProductHelper version
	 * 
	 * @param array $item
	 * @param string $mode
	 * @return string
	 */
//	public function designName($item, $mode) {
//		$name = preg_match('/([a-zA-Z ]+ -){1}(.+)/', $item['CartItem']['product_name'], $match);
//		$name = trim($match[1], ' -');
//		$summary = $this->Html->tag('h1', String::truncate($name, 40), array('class' => 'product_name'));
//		$full = $this->Html->tag('h1', $name, array('class' => 'product_name'));
//		$this->storeToggleData($item, 'product_name', $summary, $full);
//		
//		if ($mode === 'item_summary') {
//			$text = $summary;
//		} else {
//			$text = $full;
//		}
//		return $text;
//	}

	/**
	 * Extract blurb from the Custom product_name sent from the page
	 * 
	 * @param array $item
	 * @param string $mode
	 * @return type
	 */
//	public function blurb($item, $mode) {
//		$name = preg_match('/([a-zA-Z ]+ -){1}(.+)/', $item['CartItem']['product_name'], $match);
//		$name = trim($match[2], ' -');
//
//		$summary = $this->Html->para(NULL, String::truncate($name, 40), array('class' => 'blurb'));
//		$full = $this->Html->para(NULL, $name, array('class' => 'blurb'));
//		$this->storeToggleData($item, 'blurb', $summary, $full);
//		
//		if ($mode === 'item_summary') {
//			$text = $summary;
//		} else {
//			$text = $full;
//		}
//		return $text;
//	}
	
	/**
	 * STUB METHOD FOR TESTING ************************************************************************************** ================================= not this!
	 * 
	 * @param array $item
	 * @param string $mode
	 * @return string
	 */
//	public function optionList($item, $mode) {
//		$options = array(
//			'closing belt',
//			'pen loop',
//			'title: "SAS" gold, front lower right',
//			'Please give me a call if there is any problem getting the baby-shit green leather.'
//		);
//
//		$summary = $this->Html->para(NULL, String::truncate(implode(' • ', $options), 40), array('class' => 'options'));
//		$full = $this->Html->nestedList($options, array('class' => 'options'));
//		$this->storeToggleData($item, 'options', $summary, $full);
//		
//		if ($mode === 'item_summary') {
//			$text = $summary;
//		} else {
//			$text = $full;
//		}
//		return $text;
//	}
	
	/**
	 * Provide the edit-request tool for a custom product
	 * 
	 * @param array $item
	 * @return string
	 */
	public function editItemTool($item) {
//		$supplement = unserialize($item['CartItem']['Supplement']['data']);
//		return ' • ' . $this->Html->link('Edit', DS.$item['CartItem']['Supplement']['data']['edit_path'], array('class' => 'tool'));
		return ' • ' . $this->Html->link('Edit', DS.'catalogs/editCatalogItem/'.$item['CartItem']['id'], array('class' => 'tool'));
	}
	

}
