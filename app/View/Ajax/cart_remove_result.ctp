<?php
$url = isset($message_url) ? $message_url : FALSE;
$subtotal = isset($cart) ? $this->element('Cart/cart_subtotal', array('cartSubtotal', $cartSubtotal)) : '' ;
$result = array(
	'cart_badge' => $this->element('Cart/cart_badge'),
	'wish_badge' => $this->element('Cart/wish_badge'),
	'cart_subtotal' => $subtotal,
	'flash' => $this->Session->flash(),
	'destination' => $url ? "<p id=\"url\">$url</p>" : '',
	'result' => $result,
);

echo json_encode($result);
