<?php

/**
 * EditionProductHelper
 * 
 * This helper is composed into PurchasedProductHelper to output components specific to GenericProdcuts.
 * 
 * @author dondrake
 */
class GenericProductHelper extends AppHelper {

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}
	
	public function editItemTool($item) {
//		$product_group = preg_filter('/products\/|\/purchase/', '', $item['CartItem']['Supplement']['data']['edit_path']);
		$product_group = $item['CartItem']['Supplement']['data']['edit_path'];
		return ' • ' . $this->Html->link('Edit', DS.'catalogs/editCatalogItem/'.$item['CartItem']['id'].DS.$product_group, array('class' => 'tool'));
	}
}
