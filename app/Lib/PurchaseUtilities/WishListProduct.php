<?php
App::uses('PurchasedProduct', 'Lib/PurchaseUtilities');
/**
 * Description of WishListProduct
 *
 * @author dondrake
 */
class WishListProduct extends PurchasedProduct{
	
	
	protected function calculatePrice() {
		
	}

	/**
	 * Prepare data for save to cart
	 * 
	 * For Edition Products, the array of data describing the option 
	 * choices and details is stored as serialized Supplement data. 
	 * 
	 * @param string $cartId ID of the Cart header record which links this new CartItem
	 * @return array The data to save
	 */
	public function cartEntry($cartId) {
		$cart = array('WishList' => array(
				'id' => $this->data['WishList']['id'],
				'order_id' => $cartId,
				'state' => 'cart',
			)
		);
//		dmDebug::ddd($cart, 'cart');die;
		return $cart;
	}

	public function editEntry($id) {
		
	}

	public function updateQuantity($id, $qty) {
		
	}

}
