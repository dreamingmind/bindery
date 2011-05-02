<h2>Username: <?php echo $username ?></h2>
<p>To help protect your personal information I need you to enter your password then click Continue.
<?php
echo $session->flash('hackcheck');
echo $form->create('Account', array('class'=>'float_form', 'action' => 'validate_user', 'id' => $userid));
echo $form->inputs(
	array(
		'legend' => __('Verify Password', true),
		'password'
	)
);
echo $form->input('return', array('type'=>'hidden', 'value'=>$return));
echo $html->link('Forgot your password?','/users/forgot/password');
echo $form->end('Continue');
//debug($session);
?>
