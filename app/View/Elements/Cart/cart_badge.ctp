<?php 

// PurchasesComponent beforeRender takes care of getting the data this needs
// $purchaseCount
// $wishCount

if ($purchaseCount == 1) {
	$label = 'item';
} else {
	$label = 'items';
}

if ($purchaseCount > 0) {
	$checkout = ' | ' . $this->Html->tag('span', $this->Html->link('Checkout', array('controller' => 'checkout', 'action' => 'index')), array('class' => 'tool'));
} else {
	$checkout = '';
}

	echo $this->Html->div('badge', NULL, array('id' => 'cart_badge')) . "\n\t";
	echo $this->Html->image('cart.png') . "\n\t";
	if (!empty($checkout)) {
		echo $this->Html->para(NULL, 
			$this->Html->tag('span', $purchaseCount, array('class' => 'count'))
			. ' '
			. $this->Html->tag('span', $label, array('class' => 'label'))
			. $checkout
		);
	} else {
		echo $this->Html->para(NULL, $this->Html->tag('span', 'Cart empty', array('class' => 'count')));
	}
	echo "\n</div>\n";
?>