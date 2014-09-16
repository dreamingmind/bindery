<?php
//debug($this->request->data);
echo $this->element('register',
    array(
		'mode' => 'register',
        'model' => 'User'
	) // pass the form id so javascript knows how to manage password/email fields
);
?>