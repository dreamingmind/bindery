<!--
The summary section for a Cart display
-->
<?php // debug($cartSubtotal); ?>
<div class="cart_summary">
	<p>
		<span class="label">Tax:</span>
		<span class="amt" title="To be determined">-TBD-</span>
	</p>
	<p>
		<span class="label">Shipping:</span>
		<span class="amt" title="To be determined">-TBD-</span>
	</p>
	<?php echo $this->element('Cart/cart_subtotal', array('cartSubtotal' => $cartSubtotal)); ?>
</div>