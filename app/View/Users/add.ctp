<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
            <?php if(isset ($userdata)) { ?>
 		<legend><?php echo __('Add User');?></legend>
            <?php } else { ?>
                <legend><?php echo __('Register');?></legend>
            <?php } ?>
	<?php
		echo $this->Form->input('email');
		echo $this->Form->input('username');
                if($usergroupid == 1) {
                    echo $this->Form->input('group_id');
                }
		echo $this->Form->input('password');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('zip');
		echo $this->Form->input('email_verified');
		echo $this->Form->input('registration_date');
		echo $this->Form->input('verification_code');
		echo $this->Form->input('ip');
		echo $this->Form->input('phone');
		echo $this->Form->input('fax');
		echo $this->Form->input('country');
		echo $this->Form->input('address');
		echo $this->Form->input('address2');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'));?></li>
	</ul>
</div>
