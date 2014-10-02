<?php 
    echo $this->Paypal->button(
			'Add To Cart', 
			array(),
//			array('type' => 'addtocart', 'amount' => '15.00', 'item_name' => $productCategory), 
			array('type' => 'button', 'class' => 'orderButton', 'option' => 'slave-' . $productCategory, 'setlist' => 'order', 'bind' => 'click.addToCart')
		);
?>