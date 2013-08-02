<?php
echo $this->Html->para('','I am a view');

echo $this->Form->create('Workshop');
echo $this->Form->input('collection_id',array(
    'type'=>'text'
));
echo $this->Form->input('name');

echo $this->element('workshopForm_dataFields');

echo $this->Form->end('Submit');
?>