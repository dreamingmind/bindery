<?php
echo $this->Session->flash();
echo $this->Session->flash('auth');
echo $this->Form->create('User', array('class'=>'float_form', 'action' => 'login', 'id' => 'login'));
echo $this->Form->inputs(
	array(
		'legend' => __('Login'),
		'username' => array('autofocus'=>true),
		'password'
	)
);
echo $this->Html->link('Forgot your username?','/users/forgot/username');
echo ' | ';
echo $this->Html->link('Forgot your password?','/users/forgot/password');
echo $this->Form->end('Login');
//debug($session);
?>
