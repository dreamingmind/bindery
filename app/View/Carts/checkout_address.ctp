<!-- View/Carts/checkout_address.ctp -->
<div class="order_addresses"><?php 
$address_toggle = 'cart-' . $this->request->data['Cart']['id'];
echo $this->Form->create('Cart');

	echo $this->element('AddressModule.simple_address_review', array('alias' => 'Shipping'));
	echo $this->element('AddressModule.simple_address_input', array('alias' => 'Shipping'));
	echo $this->Form->input('Same', array('label' => 'Billing same as Shipping', 'checked' => TRUE, 'type' => 'checkbox', 'bind' => 'change.set_billing'));
	
	echo $this->element('AddressModule.simple_address_review', array('alias' => 'Billing'));
	echo $this->element('AddressModule.simple_address_input', array('alias' => 'Billing'));
	
	if (!is_null($this->Session->read('Auth.User.id'))) {
		echo $this->Form->input('Update', array('label' => 'Update my account with these addresses', 'checked' => FALSE, 'type' => 'checkbox'));
	}
	
echo $this->Form->end('Submit');
echo $this->element('Cart/cart_ui', array('cart' => $this->request->data, 'cartClass' => 'cart_checkout'));
?>
</div>
	<script type="text/javascript">
	//<![CDATA[
	initToggles();
	bindHandlers('div.order_addresses')
	//]]>
	</script>
<!-- END View/Carts/checkout_address.ctp END -->
