<tr>
	<td>
		<?php echo $this->PurchasedProduct->designName($item, $class); ?> 
	</td>
	<td>
		<?php echo $this->PurchasedProduct->blurb($item, $class); ?> 
		<?php echo $this->PurchasedProduct->optionList($item, $class); ?> 		
	</td>
	<td>
			<?php echo $this->PurchasedProduct->itemQuantity($item); ?> 
			at 
			<?php echo $this->PurchasedProduct->itemPrice($item, $prices); ?> 
	</td>
	<td>
			$<?php echo $this->PurchasedProduct->itemTotal($item); ?> 
	</td>
</tr>
