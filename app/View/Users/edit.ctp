<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php echo __('Edit User');?></legend>
	<?php
        echo $this->Form->input('active');
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('repeat_password');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('zip');
		echo $this->Form->input('email_verified');
		echo $this->Form->hidden('registration_date');
		echo $this->Form->input('verification_code');
		echo $this->Form->input('ip');
		echo $this->Form->input('phone');
		echo $this->Form->input('fax');
		echo $this->Form->input('country');
		echo $this->Form->input('address');
		echo $this->Form->input('address2');
		echo $this->Form->input('username');
                echo $this->Form->input('group_id', array('type'=>'hidden'));
                if($usergroupid == 1) {
                    echo $this->Form->input('group_id');
                }
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index'));?></li>
                <li><?php echo $this->Html->link(__('Refresh Validation Hash'), array('action' => 'refreshHash', $this->Form->value('User.id')));?></li>
	</ul>
</div>
