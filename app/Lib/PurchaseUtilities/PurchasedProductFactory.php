<?php
App::uses('CustomProduct', 'Lib/PurchaseUtilities');
App::uses('InventoryProduct', 'Lib/PurchaseUtilities');
App::uses('WorkshopProduct', 'Lib/PurchaseUtilities');
App::uses('PurchasedProduct', 'Lib/PurchaseUtilities');
App::uses('VariationProduct', 'Lib/PurchaseUtilities');
App::uses('EditionProduct', 'Lib/PurchaseUtilities');
App::uses('GenericProduct', 'Lib/PurchaseUtilities');
App::uses('WishListProduct', 'Lib/PurchaseUtilities');

/**
 * Description of PurchasedProductFactory
 * 
 * Given an array of data, examine it to determine which kind 
 * of product it represents. Return the concrete PurchasedProduct 
 * utility class to handle the unique array struct for the product type
 *
 * @author dondrake
 */
class PurchasedProductFactory {
	
	public static function makeProduct($item, $cart) {
	
	// this assumes the data provides clues that are used in this 
	// method to decide which validator should be created.
	// 
	// Put its name into $validator
	
	// this first one handles cases where the CartItem record already exists
	if (isset($item['CartItem']['type'])) {
		$product = $item['CartItem']['type'].'Product';
		
	// all the others handle the submission of a request for a new cart item
	} elseif (isset($item['specs_key'])) {
		$product = 'CustomProduct';
		
	} elseif (isset($item['cmd'])) {
		$product = 'InventoryProduct';
		
	} elseif (isset($item['Edition'])) {
		$product = 'EditionProduct';
		
	} elseif (isset($item['generic'])) {
		$product = 'GenericProduct';
		
	} elseif ('workshop' === TRUE) {
		$product = 'WorkshopProduct';
		
	} elseif ('purchased' === TRUE) {
		$product = 'PurchasedProduct';
		
	} elseif ('variation' === TRUE) {
		$product = 'VariationProduct';
		
	} elseif (isset($item['WishList'])) {
		$product = 'WishListProduct';
		
	} else {
		dmDebug::ddd($item, 'item');
		throw new BadRequestException('Could not determine which product utility class to use.');
	}
	
	 return new $product($item, $cart);
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
