<!-- Elements/Cart/confirming_item_detail_table.ctp -->
<table>
	<tbody>
	<thead>
		<tr>
			<th>Item</th><th>Item Details</th><th>Price</th>
		</tr>
	</thead>
		<?php 
		foreach ($cart['CartItem'] as $item){
			$this->set('item', array('CartItem'=>$item));
			echo $this->element('Cart/item_receipt', array('class' => 'item_detail'));
		}
		?>
	</tbody>
</table>
<!-- END Elements/Cart/confirming_item_detail_table.ctp END -->
