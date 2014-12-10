<?php $class = 'item_detail'; ?>

<div class="<?php echo $class; ?>" id="<?php echo "cart_item-{$item['CartItem']['id']}" ?>">
	
	<?php echo $helper->modeToggle($item, 'Collapse', $isNewItem); ?> 
	
	<div class="item_text">
		<?php echo $helper->designName($item, $class); ?> 
		<?php echo $helper->blurb($item, $class); ?> 
		<?php echo $helper->optionList($item, $class); ?> 		
	</div>

	<div class="item_tools">
		<p><?php echo $helper->removeItemTool($item) . $helper->editItemTool($item); ?></p>
		<?php // echo $helper->editItemTool($item); ?> 
		<?php echo $this->element('Cart/item_price', array('item' => $item, 'helper' => $helper)); ?>
	</div>
	 

</div>