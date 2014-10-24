<?php
foreach ($cart as $item) {
	$helper = 'dummy';
//	$helper = $this->Helpers->load("{$item['Cart']['type']}ProductHelper");
	if ($item['Cart']['id'] == $new) {
		$this->start('new');
			echo $this->element('Cart/item_detail', array('item' => $item, 'helper' => $helper));
		$this->end();
	} else {
		$this->append('existing');
			echo $this->element('Cart/item_summary', array('item' => $item, 'helper' => $helper));
		$this->end();
	}
}
$json = json_encode($cart);
?>

<div class="<?php echo $cartClass; ?>">
	<?php echo $this->fetch('new') ?>
	<?php echo $this->fetch('existing') ?>
	<?php echo $this->fetch('item_summary') ?>
	<?php echo $this->fetch('cart_summary') ?>
	<?php echo $this->fetch('button_block') ?>
	
<script type=\"text/javascript\">
	//<![CDATA[
	// Data pack for expand/collapse of item sections
	var data = <?php echo $json ?>;
	//]]>
</script>
	
</div>