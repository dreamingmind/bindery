<table>
	<tbody>
		<tr>
			<td>
				<?php 
				echo $this->element('AddressModule.simple_address_review', 
						array('alias' => 'Billing', 'address' => $cart['toolkit']->address('billing')));
				?>
			</td>
			<td>
				<?php 
				echo $this->element('AddressModule.simple_address_review', 
						array('alias' => 'Shipping', 'address' => $cart['toolkit']->address('shipping')));
				?>
			</td>
		</tr>
	</tbody>
</table>
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
<?php echo $this->element('Cart/cart_summary'); ?>