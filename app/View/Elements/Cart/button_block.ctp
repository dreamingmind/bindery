<?php
$href = '';
if (isset($referer)) {
	// coming from carts/checkout page process
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
			<button>Pay by check</button>
			<button>PayPal</button>
			<?php
		}
		?>
	</div>
</div>