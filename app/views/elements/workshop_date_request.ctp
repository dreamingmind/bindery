<?php
//  Form test zone
echo $this->Form->create('Workshop',array('action'=>'request'));
echo $this->Html->tag('legend','');
echo $this->Form->input('heading',array(
  'value'=>$heading));
echo $this->Form->input('email_address');
echo $this->Form->input('month',array(
  'options'=>array(
        '00' => 'Select',
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    )));
$thisyear = date('Y',time());
$year = array(
  '00'=>'Select',
  $thisyear=>$thisyear,
  $thisyear+1=>$thisyear+1);
echo $this->Form->input('year',array(
  'options'=>$year));
echo $this->Form->end('Send');
echo $this->Html->link('Request a workshop date','#', array(
                        'class'=>'requesttoggle'));
?>