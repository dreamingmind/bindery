	<!-- The cart subtotal line in cart_summary, a part of cart_ui -->
	<?php // dmDebug::ddd($itemTotal, 'item tot');
//	dmDebug::ddd($cartSubtotal, 'subtot');die;?>
	<p>
		<span class='label'>Subtotal:</span>
		<!--<span class='amt cart_subtotal'><?php // echo $cart['toolkit']->subtotal(); ?></span>-->
		<span class='amt cart_subtotal'><?php echo $cartSubtotal; ?></span>
	</p>
