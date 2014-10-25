<?php $class = 'item_summary'; ?>

<div class="<?php echo $class; ?>" id="<?php echo "cart_item-{$item['Cart']['id']}" ?>">
	
	<?php echo $helper->modeToggle($item, 'Expand'); ?> 
	
	<div class="item_text">
		<?php echo $helper->designName($item, $class); ?> 
		<?php echo $helper->blurb($item, $class); ?> 
		<?php echo $helper->optionList($item, $class); ?> 		
	</div>
	
	<div class="item_tools">
		<?php echo $this->element('Cart/item_price', array('item' => $item, 'helper' => $helper)); ?>
	</div>

</div>