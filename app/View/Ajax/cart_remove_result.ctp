<?php
$url = isset($message_url) ? $message_url : FALSE;
$result = array(
	'cart_badge' => $this->element('Cart/cart_badge', array('purchaseCount', $purchaseCount)),
	'cart_subtotal' => $this->element('Cart/cart_subtotal', array('cartSubtotal', $cartSubtotal)),
	'flash' => $this->Session->flash(),
	'destination' => $url ? "<p id=\"url\">$url</p>" : '',
	'result' => $result,
);

echo json_encode($result);
