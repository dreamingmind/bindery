<tr>
	<td>
		<?php echo $this->PurchasedProduct->designName($item, $class); ?> 
	</td>
	<td>
		<?php echo $this->PurchasedProduct->blurb($item, $class); ?> 
		<?php echo $this->PurchasedProduct->optionList($item, $class); ?> 		
	</td>
	<td>
		<p class='qty'>
			<?php echo $this->PurchasedProduct->itemQuantitySummary($item); ?> 
			at 
			<?php echo $this->PurchasedProduct->itemPrice($item); ?> 
		</p>
<!--	</td>
	<td>-->
		<div class='tot'>
			$<?php echo $this->PurchasedProduct->itemTotal($item); ?> 
		</div>
	</td>
</tr>
