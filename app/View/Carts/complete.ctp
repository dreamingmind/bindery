<div class="order_addresses"><?php 
$address_toggle = 'cart-' . $this->request->data['Cart']['id'];
echo $this->Form->create('Cart');
?>
	<!--<div id="<?php // echo $address_toggle?>" class="toggle">-->
	<?php echo $this->element('AddressModule.address_input', array('alias' => 'Billing')); ?>
	<!--</div>-->
	<?php echo $this->Form->input('Same', array('label' => 'Shipping same as Billing', 'checked' => TRUE, 'type' => 'checkbox', 'bind' => 'change.set_shipping')); ?>
	<!--<div class="<?php // echo $address_toggle?> hide">-->
	<?php echo $this->element('AddressModule.address_input', array('alias' => 'Shipping')); ?>
	<!--</div>-->
<?php
echo $this->Form->end();
?>
</div>
	<script type="text/javascript">
	//<![CDATA[
	initToggles();
	bindHandlers('div.order_addresses')
	//]]>
	</script>