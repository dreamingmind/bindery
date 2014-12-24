<?php

// At this point we have:
// $new = the id of the just added cart item (goes to FALSE if checkout process request)
// $cart = the array of all cart items and their linked data
// $cartClass = cart_pallet or cart_checkout, this value is set by the calling view
//		cart_pallet is the overlay div that results when clicking a purchase button
//		cart_checkout is the first page of the checkout process where you review 
//			the cart and choose a payment method

// First the items are processed to assemble all the item entries. 
// Detail and Summary fetch-blocks are assembled without direct output.
// A json object of toggleData is assembled by sub-processes and this 
// data will support the expand/collapse feature of these item blocks. 

// The blocks contain many child elements, so prepare to drill down 
// if you decide to follow these element calls.  

$new = isset($new) ? $new : FALSE;

$prices = new stdClass();
$prices->subtotal = 0;
$prices->zeroItem = FALSE;
$this->set('prices', $prices);

if (isset($cart['CartItem'])) {
	foreach ($cart['CartItem'] as $index => $item) {

		$prices->subtotal += $item['total'];
		$isNewItem = $item['id'] == $new;

		if ($isNewItem || $cartClass === 'cart_checkout') {
			$this->start('new');
			echo $this->element('Cart/item_detail', array(
				'item' => array('CartItem' => $item),
				
				'prices' => $prices,

				'isNewItem' => $isNewItem,

				'Html' => $this->Html));
			$this->end();
		} else {
			$this->append('existing');
			echo $this->element('Cart/item_summary', array(
				'item' => array('CartItem' => $item),
				
				'prices' => $prices,

				'Html' => $this->Html));
			$this->end();
		}
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

if (isset($cart['Cart'])) {
	echo "<!-- open the div -->\n";
	echo $this->Html->div(NULL, NULL, array('id' => $cartClass, 'title' => 'Supply the required contact information to proceed.'));
	echo $this->PurchasedProduct->cartContactHeader($cart);
}

	echo $this->fetch('new');
	echo $this->fetch('existing');
	if (count($cart) > 0) {
		echo $this->element('Cart/cart_summary', array('cartSubtotal' => $prices->subtotal));
		echo $this->element('Cart/button_block', array('cartClass' => $cartClass, 'cart' => $cart));
	}
	
// This section places the json object on the page which supports
// detail toggling of cart itmes. Pallet and view require different handling.

// On the checkout page, add the data to other global variables
if ($cartClass === 'cart_checkout') {
	$this->append('jsGlobalVars');
		echo 'var toggleData = ' . json_encode($this->PurchasedProduct->toggleData) . ';';
	$this->end();
} else {
// The pallet, on the other hand, gets the data embedded right in the html response
?>

<script type=\"text/javascript\">
	//<![CDATA[
	// Data pack for expand/collapse of item sections
	var toggleData = <?php echo json_encode($this->PurchasedProduct->toggleData) ?>;
	//]]>
</script>

<?php
}
if (isset($cart['Cart'])) {
echo "</div>\n";
}
?>
<!-- 
==============================================
Shopping cart complete
==============================================
-->
