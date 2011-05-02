<div class="users form">
<?php echo $form->create('User');?>
	<fieldset>
            <?php if(isset ($userdata)) { ?>
 		<legend><?php __('Add User');?></legend>
            <?php } else { ?>
                <legend><?php __('Register');?></legend>
            <?php } ?>
	<?php
		echo $form->input('email');
		echo $form->input('username');
                if($usergroupid == 1) {
                    echo $form->input('group_id');
                }
		echo $form->input('password');
		echo $form->input('first_name');
		echo $form->input('last_name');
		echo $form->input('city');
		echo $form->input('state');
		echo $form->input('zip');
		echo $form->input('email_verified');
		echo $form->input('registration_date');
		echo $form->input('verification_code');
		echo $form->input('ip');
		echo $form->input('phone');
		echo $form->input('fax');
		echo $form->input('country');
		echo $form->input('address');
		echo $form->input('address2');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Users', true), array('action' => 'index'));?></li>
	</ul>
</div>
