<?php

//echo '<DIV class="formContent">';
//debug($packet);
echo '<a class="cancel-date-request">X</a>';
$record = array();
    echo $form->button('Search',array(
        'type'=>'submit',
        'id'=>'daterequestSubmit'));
    echo $this->Html->div('', $this->element('contentAdvancedSearch',array(
        'record'=>$record,
        'display'=>'show'
        )));
    echo $this->Html->div('', $this->element('imageAdvancedSearch',array(
        'record'=>$record,
        'display'=>'show')));
    echo $this->Html->div('', $this->element('dateAdvancedSearch',array(
        'record'=>$record,
        'year'=>$year,
        'month'=>$month,
        'week'=>$week,
        'display'=>'show')));
//echo '</DIV>';
?>