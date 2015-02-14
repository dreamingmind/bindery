<!-- Elements/Cart/confirming_address_table.ctp -->
<table class="addresses">
	<tbody>
		<tr>
			<td>
				<?php 
				echo $this->element('Cart/contact_review', array('toolkit' => $cart['toolkit']));?>
			</td>
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
<!-- END Elements/Cart/confirming_address_table.ctp END -->
