<?php
/**
 * This assembles the cart ui as a floating pallet for on-page review 
 * immediately after a product purchase-click. 
 * 
 * This is a pretty bad element name. It describes the action that initiates it rather than what it is. ********************* bad naming
 */
$cartClass = 'cart_checkout';

$this->append('scripts');
echo $this->Html->script('order_addresses');
$this->end();

//echo $this->Html->tag('h2', 'Checkout -> Address -> Payment -> Confirm', array('class' => 'checkout'));

?>
	<h2 class="checkout">Checkout<img src="/bindery2.0/img/check_now.png" alt="dash"><strong>Address</strong><img src="/bindery2.0/img/check_step.png" alt="dash">Payment<img src="/bindery2.0/img/check_step.png" alt="dash">Confirm</h2>

<div id="required_data">
	<h3 class="entry">Provide Contact and Address Information</h3>
	<?php 
		echo $this->element('email');
		echo $this->element('AddressModule.simple_address_input', array('alias' => 'Shipping'));
		echo $this->Form->input('Same', array('label' => 'Billing same as Shipping', 'checked' => TRUE, 'type' => 'checkbox', 'bind' => 'change.set_billing', 'id' => 'CartSame')) . '<br />';
		echo $this->element('AddressModule.simple_address_input', array('alias' => 'Billing')); 
		if (!is_null($this->Session->read('Auth.User.id'))) {
			echo $this->Form->input('Update', array('label' => 'Update my account with these addresses', 'checked' => FALSE, 'type' => 'checkbox'));
		}
	
	echo $this->Form->end('Submit');

	?>
</div>
<div id="cart_checkout">
<?php
echo $this->element('Cart/cart_ui', array('cartClass' => $cartClass));
if (count($cart) == 0) {
	echo $this->Html->para(NULL, 'Your cart is empty.');
}
?>
</div>
