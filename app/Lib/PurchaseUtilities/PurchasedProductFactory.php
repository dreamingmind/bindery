<?php
App::uses('CustomProduct', 'Lib/PurchaseUtilities');
App::uses('InventoryProduct', 'Lib/PurchaseUtilities');
App::uses('WorkshopProduct', 'Lib/PurchaseUtilities');
App::uses('PurchasedProduct', 'Lib/PurchaseUtilities');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PriceValidatorFactory
 *
 * @author dondrake
 */
class PurchasedProductFactory {
	
	public static function makeProduct($data) {
	
	// this assumes the data provides clues that are used in this 
	// method to decide which validator should be created.
	// 
	// Put its name into $validator
	
	if (isset($data['specs_key'])) {
		$validator = 'CustomProduct';
	} else {
		throw new BadRequestException('Could not determine which price validator to use.');
	}
	
	 return new $validator($data);
	/**
	 * I could check to see if an instance already exists and return that one
	 * but since I'm making them with the data-to-validate as a parameter, I'm planning 
	 * on have multiples if I have multiple records.
	 * 
	 * If I wanted to have only one instance, I would make them without data and 
	 * pass data in when I wanted it validated
	 */
	}
}

?>
