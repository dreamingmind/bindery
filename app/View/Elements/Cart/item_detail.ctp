<?php $class = 'item_detail'; ?>

<div class="<?php echo $class; ?>" id="<?php echo "cart_item-{$item['Cart']['id']}" ?>">
	<?php echo $helper->modeToggle('Collapse', $isNewItem); ?> 
	<div class="item_text">
		<?php echo $helper->designName($item, $class); ?> 
		<?php echo $helper->blurb($item, $class); ?> 
		<?php echo $helper->optionList($item, $class); ?> 		
	</div>

	<?php echo $this->element('Cart/item_price', array('item' => $item)); ?> 

</div>