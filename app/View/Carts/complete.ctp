<div class="order_addresses"><?php 
$address_toggle = 'cart-' . $this->request->data['Cart']['id'];
echo $this->Form->create('Cart');

	echo $this->element('AddressModule.address_input', array('alias' => 'Billing'));
	echo $this->Form->input('Same', array('label' => 'Shipping same as Billing', 'checked' => TRUE, 'type' => 'checkbox', 'bind' => 'change.set_shipping'));
	
	echo $this->element('AddressModule.address_input', array('alias' => 'Shipping'));
	echo $this->Form->input('Update', array('label' => 'Update my account with these addresses', 'checked' => FALSE, 'type' => 'checkbox'));
	
echo $this->Form->end('Submit');
?>
</div>
	<script type="text/javascript">
	//<![CDATA[
	initToggles();
	bindHandlers('div.order_addresses')
	//]]>
	</script>