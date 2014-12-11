<?php
	echo $this->Form->button(($purchaseCount > 0) ? 'Add to cart' : 'Order now', array('type' => 'submit', 'class' => 'submit', 'bind' => 'click.addToCart'));
