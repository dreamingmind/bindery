<!-- Elements/Cart/cart_pallet_button_block.ctp -->
<div class="button_block">
	
	<?php echo $this->PurchasedProduct->checkoutButton('continue', $cart['toolkit']); ?>
	
	<div class="proceed">
		
		<?php 
		echo $this->PurchasedProduct->checkoutButton('checkout', $cart['toolkit']);
		echo $this->PurchasedProduct->checkoutButton('quote', $cart['toolkit']);
		$express = $this->PurchasedProduct->checkoutButton('express', $cart['toolkit']);
		if ($express != '') {
			echo "<span> OR </span>\n$express";
		}
		?>
		
	</div>
</div>
<!-- END Elements/Cart/cart_pallet_button_block.ctp -->
