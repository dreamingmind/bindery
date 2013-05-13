<?php
//  Form test zone
echo $this->Form->create('Request',array('action'=>'request'));
echo $this->Form->input('workshop_id',array ('type'=>'hidden','value'=>$id));
echo $this->Html->tag('legend','');
echo $this->Form->input('workshop_name',array('value'=>$heading));
echo $this->Form->input('email', array('default'=>'ddrake@dreamingmind.com'));
echo $this->Form->month('month');
echo $this->Form->year('year',date('Y'),date('Y')+1);
echo $this->Form->end('Send');
echo $this->Html->link('Request a workshop date','#', array(
                        'class'=>'requesttoggle'));
?>