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

	public function beforeRender($viewFile) { }

	public function afterRender($viewFile) { }

	public function beforeLayout($viewLayout) { }

	public function afterLayout($viewLayout) { }
	
	/**
	 * Provide the edit-request tool for a custom product
	 * 
	 * @param array $item
	 * @return string
	 */
	public function editItemTool($item) {
//		$supplement = unserialize($item['CartItem']['Supplement']['data']);
//		return ' • ' . $this->Html->link('Edit', DS.$item['CartItem']['Supplement']['data']['edit_path'], array('class' => 'tool'));
		$pname = preg_filter('/products\/|\/purchase/', '', $item['CartItem']['Supplement']['data']['edit_path']);
		return ' • ' . $this->Html->link('Edit', DS.'catalogs/editCatalogItem/'.$item['CartItem']['id'].DS.$pname, array('class' => 'tool'));
	}
	

}
