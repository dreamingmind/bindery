<table>
	<tbody>
		<?php 
		foreach ($cart['CartItem'] as $item){
			$this->set('item', array('CartItem'=>$item));
			echo $this->element('Cart/item_receipt', array('class' => 'item_detail'));
		}
		?>
	</tbody>
</table>