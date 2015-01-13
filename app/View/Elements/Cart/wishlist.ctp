<?php
$class = 'item_detail';
$item_id = $item['CartItem']['id'];
?>

<div class="<?php echo $class; ?>" id="<?php echo "cart_item-{$item_id}" ?>">
	
	<?php
		echo $this->Form->create('WishList', array(
			'id' => "WishListForm_$item_id"
		));
		echo $this->Form->input('id', array(
			'type' => 'hidden',
			'value' => $item_id
		));
		echo $this->Form->input('TypeMemo.id', array(
			'type' => 'hidden',
			'value' => $item['CartItem']['TypeMemo']['id']
		));
		echo $this->Form->input('TypeMemo.type', array(
			'type' => 'hidden',
			'value' => $item['CartItem']['TypeMemo']['data']
		));
//		echo $this->Html->link('Add to cart', "/cart_item/wish/{$item_id}", array('class' => 'tool wish', 'bind' => 'click.addToCart'));
		echo $this->Form->button($this->Cart->submitItemButtonLabel($purchaseCount), array('class' => 'tool wish', 'bind' => 'click.addToCart'));
		echo $this->Form->end();
// echo $this->PurchasedProduct->modeToggle($item, 'Collapse', $isNewItem); 
	?> 
	
	<div class="item_text">
		<?php echo $this->PurchasedProduct->designName($item, $class); ?> 
		<?php echo $this->PurchasedProduct->blurb($item, $class); ?> 
		<?php echo $this->PurchasedProduct->optionList($item, $class); ?> 		
	</div>

	<!--<div class="item_tools">-->
		<!--<p><?php // echo $this->PurchasedProduct->removeItemTool($item) . $this->PurchasedProduct->editItemTool($item) ; ?></p>-->
		<?php // echo $helper->editItemTool($item); ?> 
		<?php // echo $this->element('Cart/item_price', array('item' => $item)); ?>
	<!--</div>-->
	 

</div>