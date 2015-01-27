<?php
$this->append('css');
//echo $this->Html->script('checkout');
echo $this->Html->css('AddressModule.address_module');
$this->end();
?>
	<h2 class="checkout">
		Checkout
		<img src="/bindery2.0/img/check_step.png" alt="dash">Address
		<?php if ($cart['toolkit']->mustPay()) { ?><img src="/bindery2.0/img/check_step.png" alt="dash">Payment <?php } ?>
		<img src="/bindery2.0/img/check_now.png" alt="dash"><strong>Confirm</strong>
	</h2>

<h1><?php echo $confirmMessage; ?></h1>
<?php echo $this->PurchasedProduct->checkoutButton('back_edit', $cart['toolkit']); ?>
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
<?php 
echo $this->element('Cart/cart_summary'); 
echo $this->element('Cart/confirm_button_block');
?>