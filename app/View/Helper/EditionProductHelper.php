<?php

/**
 * EditionProductHelper
 * 
 * It's expected that Edition Products will always and only be linked to Collections
 * This helper is composed into PurchasedProductHelper to output components specific to EditionProdcuts.
 * 
 * @author dondrake
 */
class EditionProductHelper extends AppHelper {

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}

	public function editItemTool() {
		return '';
	}
}
