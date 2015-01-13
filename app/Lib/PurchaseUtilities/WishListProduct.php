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
	 * For WishList products, the product type has been moved to a Supplement record 
	 * and the cart items type has been changed to WishList. Also the cart item state 
	 * was changed to 'wish'. So wer reverse these changes and dump the Supplement 
	 * record that kept the original product type.
	 * 
	 * If the deletion fails, there could be problems. Not sure where to fix this.
	 * 
	 * @param string $cartId ID of the Cart header record which links this new CartItem
	 * @return array The data to save
	 */
	public function cartEntry($cartId) {
		$cart = array('CartItem' => array(
				'id' => $this->data['WishList']['id'],
				'order_id' => $cartId,
				'state' => 'cart',
				'type' => $this->data['TypeMemo']['type']
			)
		);
		try {
			ClassRegistry::init('Supplement')->delete($this->data['TypeMemo']['id']);
		} catch (Exception $exc) {
			$this->logTypeMemoDeletionFailure($this->data);
			echo $exc->getTraceAsString('The TypeMemo didn\t delete. This would leave the Cart Item with an extra Supplement if allowed to proceed');
		}

		return $cart;
	}

	public function editEntry($id) {
		
	}

	public function updateQuantity($id, $qty) {
		
	}

}
