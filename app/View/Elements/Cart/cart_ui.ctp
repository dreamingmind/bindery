<?php

//App::uses('PurchasedProduct', 'PurchasedProductHelper');
//App::uses('CustomProduct', 'Purchase/CustomProductHelper');

foreach ($cart as $item) {
//	$helper = 'dummy';
	$helper = $this->Helpers->load("{$item['Cart']['type']}Product");
	
	$isNewItem = $item['Cart']['id'] == $new;
	
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
$json = json_encode($cart);
?>

<div id="<?php echo $cartClass; ?>">
	<?php echo $this->fetch('new') ?>
	<?php echo $this->fetch('existing') ?>
	<?php echo $this->fetch('item_summary') ?>
	<?php echo $this->fetch('cart_summary') ?>
	<?php echo $this->fetch('button_block') ?>
	
<script type=\"text/javascript\">
	//<![CDATA[
	// Data pack for expand/collapse of item sections
	var toggleData = <?php echo json_encode($helper->toggleData) ?>;
	//]]>
</script>
	
</div>