<!--
The summary section for a Cart display
-->

<div class="cart_summary">
	<p>
		<span class="label">Tax:</span>
		<span class="amt" title="To be determined">--</span>
	</p>
	<p>
		<span class="label">Shipping:</span>
		<span class="amt" title="To be determined">--</span>
	</p>
	<?php echo $this->PurchasedProduct->cartSubtotal($subTotal); ?>
</div>