<?php
	echo $this->Form->create();
	echo $this->Form->input('password');
	echo $this->Form->input('confirm_password', array(
	    'type' => 'password',
	    'required' => 'required'
	));
	echo $this->Form->end('Save');
?>