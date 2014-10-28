<div>
<?php
	echo $this->PurchasedProduct->itemTotal($itemTotal); 
	echo $this->element('Cart/cart_subtotal', array('cartSubtotal' => $cartSubtotal));
?>
</div>