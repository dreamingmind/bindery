<?php
$href = '';
if (isset($referer)) {
	// coming from cart_items/checkout page process
	$href = "href='$referer'";
}
?>
<div class="button_block">
	<button id="continue" <?php echo $href; ?> bind="click.continueShopping">Continue Shopping</button>
	<div class="proceed">
		<?php
		if ($cartClass === 'cart_pallet') {
			?>
			<button bind="click.checkout">Checkout</button>
			<?php
		} else {
			?>
			<button method='check' bind='click.pay'>Pay by check</button>
			<button method="paypal" bind='click.pay'>PayPal</button>
			<?php
		}
		?>
	</div>
</div>