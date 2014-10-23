<?php
foreach ($cart as $item) {
	if ($item['Cart']['id'] == $new) {
		$this->start('new');
			echo $this->Html->para(NULL, "{$item['Cart']['price']} : {$item['Cart']['design_name']}");
		$this->end();
	} else {
		$this->append('existing');
			echo $this->Html->tag('li', "{$item['Cart']['price']} : {$item['Cart']['design_name']}\n\t\t\t");
		$this->end();
	}
}
?>

<div class="cart pallet">
	<p>Shopping Cart</p>
	<div class='new'>
		<?php echo $this->fetch('new'); ?>
	</div>
	<div class='existing'>
		<ol>
			<?php echo $this->fetch('existing'); ?>
		</ol>
	</div>
	<div class='tools'>
		<button class="continue">Continue</button>
		<button class='checkout'>Checkout</button>
	</div>
	<div>
		<?php dmDebug::ddd($this->request->data, 'posted data'); ?>
		<?php dmDebug::ddd($cart, 'cart data'); ?>
	</div>
</div>
