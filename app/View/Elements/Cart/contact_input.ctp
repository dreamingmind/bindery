<?php
echo $this->Form->create('Cart', array('action' => 'contacts'));
?>
	<fieldset id='required_contact' class="contact">
		<legend><?php echo __('Contact Information'); ?></legend>
		<p><strong>** </strong>I might have question when completing your work. I'll need the following contact information before taking your order.</p>
	<?php
		echo $this->Form->input('Cart.first_name');
		echo $this->Form->input('Cart.last_name');
		echo $this->Form->input('Cart.email');
		echo $this->Form->input('Cart.phone');
		echo $this->Form->input('Register', array(
			'label' => 'Please remember me (you\'ll get a password via email).', 
			'checked' => FALSE, 
			'type' => 'checkbox',
			'bind' => 'click.registration_request'));
	?>
	</fieldset>
<?php
	echo $this->Form->end('Submit', array('bind' => 'click.submitContacts'));
?>
