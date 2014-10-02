<?php 
if (isset($cart)) {
	$count = count($cart);
	$checkout = ' | ' . $this->Html->tag('span', 'Checkout');
} else {
	$count = 0;
	$checkout = '';
}

echo $this->Html->div(
		'badge',
		$this->Html->image('cart')
		. $this->Html->para(NULL, 
				$this->Html->tag('span', "$count items")
				. $checkout
			),
		array('id' => 'cart_badge')
		);
?>