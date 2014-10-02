<?php 
    echo $this->Paypal->button(
			'Add To Cart', 
			array(),
//			array('type' => 'addtocart', 'amount' => '15.00', 'item_name' => $productCategory), 
			array('type' => 'submit', 'class' => 'orderButton', 'option' => 'slave-' . $productCategory, 'setlist' => 'order', 'bind' => 'click.addToCart', 'div' => FALSE)
		);
?>
<!--<input type="button" value="Add To Cart" bind="click.addToCart" setlist="order" option="slave-Reusable_Journal" class="orderButton" style="display: block;">
<button type="submit" setlist="order" option="slave-Reusable_Journal" class="orderButton" style="display: block;">Add to cart</button>-->