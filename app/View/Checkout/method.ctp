<?php 
//dmDebug::ddd($shipping, 'ship quote');

/**
 * Standard page for allowing the user to select a payment method 
 * after they have reviewed their cart items and provided contact/billing/shipping info
 */
$cartClass = 'cart_checkout';

$this->append('scripts');
echo $this->Html->script('checkout');
echo $this->Html->script('order_addresses');
$this->end();

//echo $this->Html->tag('h2', 'Checkout -> Address -> Payment -> Confirm', array('class' => 'checkout'));

?>
	<h2 class="checkout">Checkout<img src="/bindery2.0/img/check_step.png" alt="dash">Address<img src="/bindery2.0/img/check_now.png" alt="dash"><strong>Payment</strong><img src="/bindery2.0/img/check_step.png" alt="dash">Confirm</h2>

<!-- The right-hand, new data input section -->
<div id="required_data">
	<h3 class="entry">Choose a payment method</h3>
	<?php 
		echo $this->element('Cart/method_button_block');
	?>
</div>

<!-- The left-hand, previous data review/edit section -->
<div id="cart_checkout">
<?php
echo $this->element('Cart/contact_review_dynamic');
echo $this->element('AddressModule.simple_address_review_dynamic', array('alias' => 'Billing', 'address' => $this->request->data('Billing')));
echo $this->element('AddressModule.simple_address_review_dynamic', array('alias' => 'Shipping', 'address' => $this->request->data('Shipping')));
echo $this->element('Cart/cart_ui', array('cartClass' => $cartClass));
echo $this->element('Cart/cart_summary');
if (count($cart) == 0) {
	echo $this->Html->para(NULL, 'Your cart is empty.');
}
?>
</div>
