<?php

//  Form test zone
echo $this->Form->create('Request', array('action' => 'request'));
echo $this->Form->input('workshop_id', array('type' => 'hidden', 'value' => $id));
echo $this->Html->tag('legend', '');
echo $this->Form->input('workshop_name', array('value' => $heading));
echo $this->Form->input('email', array('default' => (isset($this->viewVars['useremail'])) ? $this->viewVars['useremail'] : ''));
//echo $this->Form->month('month', date('m')+1, array('empty'=>false));
//echo $this->Form->year('year', date('Y'), date('Y')+3, date('Y'), array('empty'=>false));
echo $this->Form->end('Send');
echo $this->Html->link('Request a workshop date', '#', array(
    'class' => 'requesttoggle'));
?>