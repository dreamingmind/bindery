<?php 
if ($purchaseCount > 0) {
	$checkout = ' | ' . $this->Html->tag('span', 'Checkout');
} else {
	$checkout = '';
}

echo $this->Html->div(
		'badge',
		$this->Html->image('cart')
		. $this->Html->para(NULL, 
				$this->Html->tag('span', "$purchaseCount items")
				. $checkout
			),
		array('id' => 'cart_badge')
		);
?>