<!--
Ajax update HTML for synching the page after an item quantity change. 
Such a change effects cart pricing nodes. 
-->
<div>
<?php
	echo $this->PurchasedProduct->itemTotal($itemTotal); 
	echo $this->element('Cart/cart_subtotal', array('cartSubtotal' => $cartSubtotal));
?>
</div>