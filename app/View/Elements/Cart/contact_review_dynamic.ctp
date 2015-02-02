	<address class="address_review">
		<?php 	echo "\t\n" . $this->Form->button('Edit', array('type' => 'button', 'class' => 'edit toggle', 'id' => 'edit_contact')) . "\n"; ?>
		<p class="label">Contact Information</p>
		<p class="name"><?php echo $toolkit->customerName(); ?></p>	
		<p class="email"><?php echo $toolkit->email(); ?></p>
		<p class="phone"><?php echo $toolkit->phone(); ?></p>
		<fieldset class="edit_contact hide">
			<?php 
				echo $this->Form->input('name', array('value' => $toolkit->customerName()));
				echo $this->Form->input('email', array('value' => $toolkit->email()));
				echo $this->Form->input('phone', array('value' => $toolkit->phone()));
				echo "\t\n" . $this->Form->button('Submit', array('type' => 'button', 'class' => 'submit')) . "\n";
				echo "\t\n" . $this->Form->button('Cancel', array('type' => 'button', 'class' => 'cancel')) . "\n";
			?>
		</fieldset>
	</address>

