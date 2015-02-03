<div class="button_block">
	
	<?php // echo $this->PurchasedProduct->checkoutButton('continue', $cart['toolkit']); ?>
	
	<div class="proceed">
		
		<?php 
//		echo $this->PurchasedProduct->checkoutButton('checkout', $cart['toolkit']);
//		if ($cart['toolkit']->mustQuote()) {
//			// quote buttons normally show whenever there is 0 cost item on the cart 
//			// but on pallets, more buttons are confusing so this is suppressed 
//			// and will only show when the checkout button drops of the page 
//			// because there are no items with prices
			echo $this->PurchasedProduct->checkoutButton('confirm', $cart['toolkit']);
//		}		
//		echo $this->PurchasedProduct->checkoutButton('express', $cart['toolkit']);
		?>
		
	</div>
</div>
