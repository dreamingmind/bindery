<?php

/**
 * EditionProduct Utility manages purchase clicks on art purchases which are essentially stock items
 * 
 * Edition descriptions and blurbs are stored in a dedicated table. 
 * If an editions needs options, they will be supplemental data linked the record (hasMany Supplements). 
 * The edition record will carry a value used to look up its corresponding QB record which has current pricing. 
 * 
 * The process of creating a cart entry then, is a matter of looking up the various 
 * relevant records for creation of the cart record. 
 * 
 * Since no editions are expected to have options at this point, editing will be a trivial pass-through.
 * 
 * Subscription edition pattern unkown at this point ++++++++++++++++ !!!!!!!!!!!!!!!!!!!! ===============
 *
 * @author dondrake
 */
class EditionProduct extends PurchasedProduct {
	
	protected function calculatePrice() {
		
	}

	public function cartEntry($cartId) {
		
	}

	public function editEntry($id) {
		
	}

	public function paypalCartUploadNode($index) {
		
	}

	public function updateQuantity($id, $qty) {
		
	}

}
