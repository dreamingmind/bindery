<?php 

// PurchasesComponent beforeRender takes care of getting the data this needs

if ($purchaseCount == 1) {
	$label = 'item';
} else {
	$label = 'items';
}

if ($purchaseCount > 0) {
	$checkout = ' | ' . $this->Html->tag('span', $this->Html->link('Checkout', '/carts/checkout/'), array('class' => 'tool'));
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