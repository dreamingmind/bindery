<?php
$this->append('css');
echo $this->Html->css('receipt');
echo $this->Html->css('AddressModule.address_module');
$this->end();
?>
<section class="confirm">
	
	<h2 class="checkout">
		Checkout
		<img src="/bindery2.0/img/check_step.png" alt="dash">Address
		<?php if ($cart['toolkit']->mustPay() && $this->request->controller != 'checkout_quote') { ?><img src="/bindery2.0/img/check_step.png" alt="dash">Payment <?php } ?>
		<img src="/bindery2.0/img/check_now.png" alt="dash"><strong>Confirm</strong>
	</h2>

<h1><?php echo $confirmMessage; ?></h1>
<div class="process_buttons">
	<?php
	echo $this->PolicyStatement->statement('Credit Card Payment Confirm'); 
	echo $this->PurchasedProduct->checkoutButton('back_edit', $cart['toolkit']) . NEWLINE;
	echo $this->element('Cart/confirm_credit_card_button_block') . NEWLINE;
	?>
</div>

<?php
echo $this->element('Cart/confirming_address_table') . NEWLINE;

echo $this->element('Cart/confirming_item_detail_table') . NEWLINE;
 
echo $this->element('Cart/cart_summary') . NEWLINE; 
?>

<div class="process_buttons">
<?php
echo $this->PurchasedProduct->checkoutButton('continue', $cart['toolkit']) . NEWLINE;
echo $this->element('Cart/confirm_credit_card_button_block') . NEWLINE;
?>
</div>

</section>