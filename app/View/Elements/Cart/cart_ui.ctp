<?php

// At this point we have:
// $new = the id of the just added cart item **************************** checkout won't have this value. 
// $cart = the array of all cart items and their linked data
// $cartClass = cart_pallet or cart_checkout, this value is set by the calling view
//		cart_pallet is the overlay div that results when clicking a purchase button
//		cart_checkout is the first page of the checkout process where you review 
//			the cart and choose a payment method

// First the item is processed to assemble all the item entries. 
// Detail and Summary fetch-blocks are assembled without direct output.
// A json object of toggleData is assembled by sub-processes and this 
// data will support the expand/collapse feature of these item blocks. 

// The blocks contain many child nodes, so prepare to drill down 
// if you decide to follow these element calls.  

foreach ($cart as $item) {

	// get the helper that specializes in processing this kind of product
	$helper = $this->Helpers->load("{$item['Cart']['type']}Product");
	
	$isNewItem = $item['Cart']['id'] == isset($new) ? $new : FALSE;
	
	if ($isNewItem || $cartClass === 'cart_checkout') {
		$this->start('new');
			echo $this->element('Cart/item_detail', array(
				'item' => $item, 
				'isNewItem' => $isNewItem, 
				'helper' => $helper,
				'Html' => $this->Html));
		$this->end();
	} else {
		$this->append('existing');
			echo $this->element('Cart/item_summary', array(
				'item' => $item, 
				'helper' => $helper,
				'Html' => $this->Html));
		$this->end();
	}
}
?>

<div id="<?php echo $cartClass; ?>">
	<?php echo $this->fetch('new') ?>
	<?php echo $this->fetch('existing') ?>
	<?php echo $this->fetch('cart_summary') // this might change to a direct element call. ?> 
	<?php echo $this->fetch('button_block') // this might change to a direct element call ?>
	
<script type=\"text/javascript\">
	var toggleData = <?php echo json_encode($helper->toggleData) ?>;
</script>
	
</div>