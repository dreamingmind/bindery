<?php
echo $session->flash();
echo $session->flash('auth');
echo $form->create('User', array('class'=>'float_form', 'action' => 'login', 'id' => 'login'));
echo $form->inputs(
	array(
		'legend' => __('Login', true),
		'username' => array('autofocus'=>true),
		'password'
	)
);
echo $html->link('Forgot your username?','/users/forgot/username');
echo ' | ';
echo $html->link('Forgot your password?','/users/forgot/password');
echo $form->end('Login');
//debug($session);
?>
