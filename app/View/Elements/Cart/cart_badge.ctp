<?php 

if ($purchaseCount == 1) {
	$label = 'item';
} else {
	$label = 'items';
}

if ($purchaseCount > 0) {
	$checkout = ' | ' . $this->Html->tag('span', 'Checkout', array('class' => 'tool'));
} else {
	$checkout = '';
}

echo $this->Html->div(
		'badge',
		$this->Html->image('cart')
		. $this->Html->para(NULL, 
				$this->Html->tag('span', $purchaseCount, array('class' => 'count'))
				. ' ' 
				. $this->Html->tag('span', $label, array('class' => 'label'))
				. $checkout
			),
		array('id' => 'cart_badge')
		);
?>