<!--
The summary section for a Cart display
-->
<?php // debug($cartSubtotal); ?>
<div class="cart_summary">
	<p>
		<span class='label'>Subtotal:</span>
		<span class='amt cart_subtotal'><?php echo $cart['toolkit']->subtotal(); ?></span>
	</p>
	<p>
		<span class="label">Tax:</span>
		<?php 
			echo sprintf('<span class="amt" title="%s">%s</span>', 
				($cart['toolkit']->mustTax() ? 'California state sales tax' : 'Exempt, out of state'),
				$cart['toolkit']->taxAmount());
		?>
	</p>
	<p>
		<span class="label">Shipping:</span>
		<span class="amt" title="To be determined"><?php echo $cart['toolkit']->shippingEstimate(); ?></span>
	</p>
	<p>
		<span class='label'>Total:</span>
		<span class='amt cart_total'><?php echo $cart['toolkit']->subtotal() + $cart['toolkit']->taxAmount() + $cart['toolkit']->shippingEstimate(); ?></span>
	</p>
</div>