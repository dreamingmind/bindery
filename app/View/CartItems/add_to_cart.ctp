<?php
/**
 * This assembles the cart ui as a floating pallet for on-page review 
 * immediately after a product purchase-click. 
 * 
 * This is a pretty bad element name. It describes the action that initiates it rather than what it is. ********************* bad naming
 */
$cartClass = 'cart_pallet';
?>
<div id="cart_pallet">
<?php
echo $this->element('Cart/cart_ui', array('cartClass' => $cartClass));
echo $this->element('Cart/cart_pallet_button_block', array('cartClass' => $cartClass, 'cart' => $cart));
?>
</div>
