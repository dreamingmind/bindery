<?php $class = 'item_summary'; ?>

<div class="<?php echo $class; ?>" id="<?php echo "cart_item-{$item['CartItem']['id']}" ?>">
	
	<?php echo $this->PurchasedProduct->modeToggle($item, 'Expand'); ?> 
	
	<div class="item_text">
		<?php echo $this->PurchasedProduct->designName($item, $class); ?> 
		<?php echo $this->PurchasedProduct->blurb($item, $class); ?> 
		<?php echo $this->PurchasedProduct->optionList($item, $class); ?> 		
	</div>
	
	<div class="item_tools">
		<p><?php echo $this->PurchasedProduct->removeItemTool($item) . $this->PurchasedProduct->editItemTool($item); ?></p>
		<?php // echo $helper->editItemTool($item); ?> 
		<?php echo $this->element('Cart/item_price', array('item' => $item, 'helper' => $this->PurchasedProduct)); ?>
	</div>

</div>