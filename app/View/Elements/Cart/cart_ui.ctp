<?php

// At this point we have:
// $new = the id of the just added cart item (goes to FALSE if checkout process request)
// $cart = the array of all cart items and their linked data

// First the items are processed to assemble all the item entries. 
// Detail and Summary fetch-blocks are assembled without direct output.
// A json object of toggleData is assembled by sub-processes and this 
// data will support the expand/collapse feature of these item blocks. 

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
$count_statement = "{$cart['toolkit']->itemCount()} item" . (($cart['toolkit']->itemCount() == 1) ? '' : 's');

$this->start('schedule_notices');
	$notices = $this->PolicyStatement->vacation($company['vacation']);
	$notices .= $this->PolicyStatement->statement('Holiday Orders');
	if (strlen($notices) > 0) :
	?>
	<section class='scheduling'>
		<?php echo $notices; ?>
	</section>
	<?php
	endif;
$this->end()
?>
<!-- 
==============================================
This is the shopping cart item output for both
the on-page pallet view of the cart
and the checkout page view of the cart
==============================================
-->
<?php
if (isset($cart['Cart'])) {
	echo "<!-- output the shopping cart item list -->\n";
	
	// Show policies that would effect scheduling
	echo $this->fetch('schedule_notices');
	
	echo $this->Html->tag('h3', "The $count_statement in your cart", array('class' => 'checkout'));
}
	echo $this->fetch('new');
	echo $this->fetch('existing');
	
// This section places the json object on the page which supports
// detail toggling of cart itmes. Pallet and view require different handling.
//
// On the checkout page, add the data to other global variables
if ($cartClass === 'cart_checkout') :
	$this->append('jsGlobalVars');
		echo 'var toggleData = ' . json_encode($this->PurchasedProduct->toggleData) . ';';
	$this->end();
else :
// The pallet, on the other hand, gets the data embedded right in the html response
?>
<script type=\"text/javascript\">
	//<![CDATA[
	// Data pack for expand/collapse of item sections
	var toggleData = <?php echo json_encode($this->PurchasedProduct->toggleData) ?>;
	//]]>
</script>
<?php endif ?>

<!-- 
==============================================
Shopping cart item list complete
==============================================
-->
