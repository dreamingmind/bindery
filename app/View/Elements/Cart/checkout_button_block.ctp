<div class="button_block">	
	<div class="proceed">
		
		<?php 
//		echo $this->PurchasedProduct->checkoutButton('checkout', $cart['toolkit']);
		if ($cart['toolkit']->mustQuote()) :
			echo $this->PurchasedProduct->checkoutButton('quote', $cart['toolkit']);
		endif;
		if ($cart['toolkit']->mustPay()) :
?>
		<p><?php echo $this->PurchasedProduct->checkoutButton('express', $cart['toolkit']); ?> <span class="text">Checkout with Paypal</span><p>

<?php
		endif;
		?>
	</div>
</div>
