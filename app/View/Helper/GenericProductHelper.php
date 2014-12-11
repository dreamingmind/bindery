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
class GenericProductHelper extends AppHelper {

//	public $helpers = array();

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}

	public function beforeRender($viewFile) { }

	public function afterRender($viewFile) { }

	public function beforeLayout($viewLayout) { }

	public function afterLayout($viewLayout) { }
	
	public function editItemTool($item) {
//		$p = array_keys($item['CartItem']['Supplement']['data']);
//		$product = $p[0];
//		return ' • ' . $this->Html->link('Edit', DS.$item['CartItem']['Supplement']['data']['edit_path'], array('class' => 'tool'));
		$pname = preg_filter('/products\/|\/purchase/', '', $item['CartItem']['Supplement']['data']['edit_path']);
		return ' • ' . $this->Html->link('Edit', DS.'catalogs/editCatalogItem/'.$item['CartItem']['id'].DS.$pname, array('class' => 'tool'));
	}
}
