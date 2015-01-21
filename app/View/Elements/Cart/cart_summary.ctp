<!--
The summary section for a Cart display
-->
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
		<span class="label"><?php echo "{$shipping->provider()} {$shipping->service()}"; ?></span>
		<?php 
			echo sprintf('<span class="amt" title="%s">%s</span>', $shipping->service(), $shipping->rate());
		?>
	</p>
	<p>
		<span class='label'>Total:</span>
		<span class='amt cart_total'><?php echo $cart['toolkit']->subtotal() + $cart['toolkit']->taxAmount() + $shipping->rate(); ?></span>
	</p>
</div>