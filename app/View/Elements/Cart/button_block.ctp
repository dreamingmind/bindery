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
			
//    Express Checkout
//    Credit Card
//    Check
//    Needs Quote
//    Partial Payment

			echo "<button method='check' bind='click.pay_check'>Pay by check</button>";
			echo "<button method='paypal' bind='click.pay_express'>PayPal Express Checkout</button>";
			echo "<button method='paypal' bind='click.pay_express'>Credit Card</button>";
			echo "<button method='paypal' bind='click.pay_express'>Submit for Quote</button>";
			echo "<button method='paypal' bind='click.pay_express'>PayPal Express Checkout</button>";
		}
		?>
	</div>
</div>
