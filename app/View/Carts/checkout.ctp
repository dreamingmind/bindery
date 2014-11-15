<?php
/**
 * This assembles the cart ui as a floating pallet for on-page review 
 * immediately after a product purchase-click. 
 * 
 * This is a pretty bad element name. It describes the action that initiates it rather than what it is. ********************* bad naming
 */
$cartClass = 'cart_checkout';
echo $this->Html->tag('h2', 'Checkout', array('class' => 'checkout'));
echo $this->element('Cart/cart_ui', array('cartClass' => $cartClass));
if (count($cart) == 0) {
	echo $this->Html->para(NULL, 'Your cart is empty.');
}
