<div class="button_block">
	
	<?php echo $this->PurchasedProduct->checkoutButton('continue', $cart['toolkit']); ?>
	
	<div class="proceed">
		
		<?php 
//		dmDebug::ddd($this->request->params, 'params');
		echo $this->PurchasedProduct->checkoutButton('checkout', $cart['toolkit']);
		echo $this->PurchasedProduct->checkoutButton('quote', $cart['toolkit']);
		echo $this->PurchasedProduct->checkoutButton('express', $cart['toolkit']);
		?>
		
	</div>
</div>