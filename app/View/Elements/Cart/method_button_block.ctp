<div class="button_block">
	
	<?php // echo $this->PurchasedProduct->checkoutButton('continue', $cart['toolkit']); ?>
	
	<div class="proceed">
		
		<?php 
//		dmDebug::ddd($this->request->params, 'params');
//		echo $this->PurchasedProduct->checkoutButton('checkout', $cart['toolkit']);
//		echo $this->PurchasedProduct->checkoutButton('quote', $cart['toolkit']);
//		echo $this->PurchasedProduct->checkoutButton('express', $cart['toolkit']);
//		$method = array(
//			'check' => 'Check',
//			'credit_card' => 'Credit Card',
//			'paypal' => 'PayPal'
//			);
		echo $this->PurchasedProduct->checkoutButton('methods', $cart['toolkit']);
		?>
		
	</div>
</div>
