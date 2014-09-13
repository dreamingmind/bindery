<?php

$new_inputs =
    $this->Form->input('Navigator.account',array('options'=>$options))
    .$this->Form->input('Navline.route');
$this->set('new_inputs', $new_inputs);
echo $this->element('tree_crud');

?>
