<?php
	foreach($this->request->data['WishList'] as $wish) {
		echo $this->element('Cart/wishlist', array('item' => array('CartItem' => $wish)));
	}
