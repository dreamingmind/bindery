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

$new = isset($new) ? $new : FALSE;
$subTotal = 0;

foreach ($cart as $item) {

	$subTotal += $item['Cart']['total'];
	$isNewItem = $item['Cart']['id'] == $new;
	
	// get the helper that specializes in processing this kind of product
	$helper = $this->Helpers->load("{$item['Cart']['type']}Product");
	
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
<!-- 
==============================================
This is the shopping cart output for both
on-page pallet view of the cart
and checkout page view of the cart
==============================================
-->
<?php
echo $this->Html->div(NULL, NULL, array('id' => $cartClass));

	echo $this->fetch('new');
	echo $this->fetch('existing');
	if (count($cart) > 0) {
		echo $this->element('Cart/cart_summary', array('subTotal' => $subTotal));
		echo $this->element('Cart/button_block', array('cartClass' => $cartClass));
	}
	
// This section places the json object on the page which supports
// detail toggling of cart itmes. Pallet and view require different handling.

// On the checkout page, add the data to other global variables
if ($cartClass === 'cart_checkout') {
	$this->append('jsGlobalVars');
		echo 'var toggleData = ' . json_encode($helper->toggleData) . ';';
	$this->end();
} else {
// The pallet, on the other hand, gets the data embedded right in the html response
?>

<script type=\"text/javascript\">
	//<![CDATA[
	// Data pack for expand/collapse of item sections
	var toggleData = <?php echo json_encode($helper->toggleData) ?>;
	//]]>
</script>

<?php
}
?>
</div>