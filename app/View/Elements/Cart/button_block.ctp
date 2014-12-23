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
			echo "<button method='check' bind='click.pay_check'>Pay by check</button>";
			echo "<button method='paypal' bind='click.pay_express'>PayPal</button>";
		}
		?>
	</div>
</div>
