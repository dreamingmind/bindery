	<div class="item_price">
		<p class="item_calc">
			<?php echo $this->PurchasedProduct->itemQuantity($item); ?> 
			at 
			<?php echo $this->PurchasedProduct->itemPrice($item, $prices); ?> 
		</p>
		<p class="line_total">
			$<?php echo $this->PurchasedProduct->itemTotal($item); ?> 
		</p>
	</div>
