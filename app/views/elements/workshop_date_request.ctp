<?php
//  Form test zone
echo $this->Form->create('Request',array('action'=>'request'));
echo $this->Form->input('workshop_id',array ('type'=>'hidden','value'=>$id));
echo $this->Html->tag('legend','');
echo $this->Form->input('workshop_name',array('value'=>$heading));
echo $this->Form->input('email');
echo $this->Form->month('month',null,array('empty'=>'Select a month'));
echo $this->Form->year('year',date('Y'),date('Y')+1,null,array('empty'=>'Select a year'));
echo $this->Form->end('Send');
echo $this->Html->link('Request a workshop date','#', array(
                        'class'=>'requesttoggle'));
?>