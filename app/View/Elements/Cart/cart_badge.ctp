<?php 
// PurchasesComponent beforeRender takes care of getting the data this needs
// $purchaseCount

if (!empty($purchaseCount > 0)) {
	// make <image><number>item(s) link line
	
	$itemCount = $this->Html->tag('span', ' ' .$purchaseCount, array('class' => 'count'))
		. ' ' . $this->Html->tag('span', (($purchaseCount == 1) ? 'item' : 'items'), array('class' => 'label'));
	
	$checkout = $this->Html->link(
		$this->Html->image('cart.png', array('alt' => 'cart icon')) . ' ' . $itemCount,
		array('controller' => 'checkout', 'action' => 'index'), 
		array('escape' => FALSE, 'title' => 'Checkout')
	);
	
} else {
	// make cart empty label
	$checkout = $this->Html->para(NULL, $this->Html->tag('span', ' Cart empty', array('class' => 'count')));
}

?>
<!-- Elements/Cart/cart_badge.ctp -->
	<div class="badge" id="cart_badge">
		<p> |&nbsp;<?php echo $checkout; ?> </p>
	</div>
<!-- END Elements/Cart/cart_badge.ctp END -->
