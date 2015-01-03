<div>
	<?php
		echo $this->element('Cart/cart_badge', array('purchaseCount', $purchaseCount));
		echo $this->element('Cart/cart_subtotal', array('cartSubtotal', $cartSubtotal));
//		echo $this->PurchasedProduct->cartSubtotal($cartSubtotal);
		echo $this->Session->flash();
	?>
	<p id="url"><?php echo $message_url; ?> </p>
</div>