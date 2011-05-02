<?php

$new_inputs =
    $form->input('Navigator.account',array('options'=>$options))
    .$form->input('Navline.route');
$this->set('new_inputs', $new_inputs);
echo $this->element('tree_crud');

?>
