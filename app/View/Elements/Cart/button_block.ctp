<?php
$href = '';
if (isset($referer)) {
	// coming from cart_items/checkout page process
	$href = "href='$referer'";
}
?>

<div class="button_block">
	<!--<button id="continue" <?php // echo $href; ?> bind="click.continueShopping">Continue Shopping</button>-->
	<div class="proceed">
		<?php
		if (isset($cartClass) && $cartClass === 'cart_pallet') {
			?>
			<button bind="click.checkout">Checkout</button>
			<?php
		} else {
			
		//    Express Checkout
		//    Credit Card
		//    Check
		//    Needs Quote
		//    Partial Payment
//			dmDebug::ddd($prices, 'price');
		// ===============================================================
		// abstract and format this crap
		// ===============================================================
			// Submit for quote
//			if ($prices->subtotal == '0') {
//				echo $this->Html->para('alert', 'Submit your cart for a quote.');
//				echo "<button method='paypal' bind='click.pay_express'>Submit for Quote</button>";
//
//			// partial price
//			} else if ($prices->zeroItem) {
			if ($cart['toolkit']->includesQuote()) {
				echo $this->Html->para('alert', 'Once or more item in your cart requires a quote. You can pay the cart amount as a deposit or wait the the quote is complete.');
			}
				echo $this->PurchasedProduct->checkoutButton('check', $cart['toolkit']);
				echo $this->PurchasedProduct->checkoutButton('express', $cart['toolkit']);
				echo $this->PurchasedProduct->checkoutButton('creditcard', $cart['toolkit']);
				echo $this->PurchasedProduct->checkoutButton('quote', $cart['toolkit']);
				echo $this->PurchasedProduct->checkoutButton('continue', $cart['toolkit']);
//				echo "<button method='paypal' bind='click.pay_express'>PayPal Express Checkout</button>";
//				echo "<button method='paypal' bind='click.pay_express'>Credit Card</button>";
//				echo "<button method='paypal' bind='click.pay_express'>Submit for Quote</button>";
//				echo "<button method='paypal' bind='click.pay_express'>PayPal Express Checkout</button>";
//			} else {
//				echo "<button method='check' bind='click.pay_check'>Pay by check</button>";
//				echo "<button method='paypal' bind='click.pay_express'>PayPal Express Checkout</button>";
//				echo "<button method='paypal' bind='click.pay_express'>Credit Card</button>";
//				echo "<button method='paypal' bind='click.pay_express'>Submit for Quote</button>";
//				echo "<button method='paypal' bind='click.pay_express'>PayPal Express Checkout</button>";
//			}
		}
		?>
	</div>
</div>
