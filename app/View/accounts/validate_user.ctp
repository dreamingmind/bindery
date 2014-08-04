<h2>Username: <?php echo $username ?></h2>
<p>To help protect your personal information I need you to enter your password then click Continue.
<?php
echo $this->Session->flash('hackcheck');
echo $this->Form->create('Account', array('class'=>'float_form', 'action' => 'validate_user', 'id' => $userid));
echo $this->Form->inputs(
	array(
		'legend' => __('Verify Password'),
		'password'
	)
);
echo $this->Form->input('return', array('type'=>'hidden', 'value'=>$return));
echo $this->Html->link('Forgot your password?','/users/forgot/password');
echo $this->Form->end('Continue');
//debug($session);
?>
