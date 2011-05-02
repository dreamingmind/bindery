<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User');?></legend>
	<?php
        echo $form->input('active');
		echo $form->input('id');
		echo $form->input('email');
		echo $form->input('repeat_password');
		echo $form->input('first_name');
		echo $form->input('last_name');
		echo $form->input('city');
		echo $form->input('state');
		echo $form->input('zip');
		echo $form->input('email_verified');
		echo $form->hidden('registration_date');
		echo $form->input('verification_code');
		echo $form->input('ip');
		echo $form->input('phone');
		echo $form->input('fax');
		echo $form->input('country');
		echo $form->input('address');
		echo $form->input('address2');
		echo $form->input('username');
                echo $form->input('group_id', array('type'=>'hidden'));
                if($usergroupid == 1) {
                    echo $form->input('group_id');
                }
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('User.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('User.id'))); ?></li>
		<li><?php echo $html->link(__('List Users', true), array('action' => 'index'));?></li>
                <li><?php echo $html->link(__('Refresh Validation Hash', true), array('action' => 'refreshHash', $form->value('User.id')));?></li>
	</ul>
</div>
