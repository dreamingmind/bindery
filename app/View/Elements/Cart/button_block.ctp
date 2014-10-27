<?php
if (isset($referer)) {
	// coming from carts/checkout page process
	$attr = "href='$referer'";
} else {
	// looking at a cart pallet on some page
	$attr = 'bind="click.continue_shopping"';
}
?>
<div class="button_block">
	<button id="continue" <?php echo $attr; ?>>Continue Shopping</button>
	<div class="proceed">
		<?php
		if ($cartClass === 'cart_pallet') {
			?>
			<button>Checkout</button>
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