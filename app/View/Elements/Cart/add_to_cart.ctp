<?php 
    echo $this->Form->button(
			$this->Cart->submitItemButtonLabel($purchaseCount), // concrete helper will provide the correct label
			array('type' => 'submit', 'class' => 'orderButton', 'option' => 'slave-' . $productCategory, 'setlist' => 'order', 'bind' => 'click.addToCart', 'div' => FALSE)
		);
?>
