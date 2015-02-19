<?php
echo $this->Form->create();
echo $this->Form->input('username', array(
    'label' => 'Email'
));
echo $this->Form->input('password');
echo $this->Form->end('Login');