<div class="button_block">	
	<div class="proceed">
		
		<?php 
//		echo $this->PurchasedProduct->checkoutButton('checkout', $cart['toolkit']);
		if ($cart['toolkit']->mustQuote()) :
			echo $this->PurchasedProduct->checkoutButton('quote', $cart['toolkit']);
		endif;
		if ($cart['toolkit']->mustPay()) :
?>
		<p>Checkout with Paypal<p>
<?php
			echo $this->PurchasedProduct->checkoutButton('express', $cart['toolkit']);
?>
		<p><span>OR</span> enter your contact information and choose a checkout method on the next page</p>
<?php
		endif;
		?>
	</div>
</div>
