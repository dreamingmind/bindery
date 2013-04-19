<?php
//  Form test zone

echo $this->Form->create('Workshop',array('action'=>'request'));
echo $this->Html->tag('legend','Request a date for this workshop');
echo $this->Form->input('id',array(
  'type'=>'hidden',
  'value'=>$id));
echo $this->Form->input('heading',array(
  'value'=>$heading));
echo $this->Form->input('email_address');
echo $this->Form->input('date');
echo $this->Form->end('Send');

?>