<style>
table.addresses {
    margin-top: 22px;
}
table.addresses td:last-of-type {
    text-align: left;
}
td:last-of-type {
    text-align: right;
}
table.addresses p.label {
    font-size: 14px;
    font-style: normal;
    font-weight: bold;
    margin-bottom: 12px;
}
.cart_summary > p:first-child {
    margin-top: 19px;
}
.cart_summary span.amt {
    width: 17%;
}
.cart_summary p > span {
    display: inline-block;
    text-align: right;
}
.tot > span.total {
    font-size: 23px;
}
.cart_summary > p:last-child {
    margin-bottom: 48px;
}
section * {
    font-family: helvetica,arial,sans-serif;
    font-size: 12px;
    margin: 3px;
    padding: 0;
}
h1 {
    font-size: 15px;
    font-weight: bold;
    margin: 5px;
}
table {
    border: thin solid #ccc;
    width: 100%;
}
section {
    width: 650px;
}
td {
    border: thin solid #eee;
    padding: 1em;
}
.cart_summary > p {
    width: 100%;
}
span.label {
    width: 78%;
}

</style>
<section>
	
	<?php
$this->append('css');
//echo $this->Html->script('checkout');
echo $this->Html->css('AddressModule.address_module');
$this->end();
?>
	
<?php echo $this->element($acknowledgeMessage) ?>
	
<table class="addresses">
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
	
<?php 
echo $this->element('Cart/cart_summary'); 
?>
<br />
<?php echo date('r', time()); ?>
<hr />
<pre><?php echo $company['linkBlock']; ?></pre>	
<hr />
</section>