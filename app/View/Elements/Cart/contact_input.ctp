<?php
	if ($purchaseCount > 0) :
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
			// this shold only show for anon users ===========================================================================
			echo $this->Form->input('Register', array(
				'label' => 'Future feature. [Please register me with Dreaming Mind.]', 
				'checked' => FALSE, 
				'type' => 'checkbox',
				'disabled' => TRUE,
				'bind' => 'click.registration_request'));
	?>
		</fieldset>
<?php
		echo $this->Form->input('Submit', array('bind' => 'click.submitContacts', 'type' => 'submit', 'label' => FALSE));
		echo $this->Form->end();
	endif
?>
