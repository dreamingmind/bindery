<?php

//echo '<DIV class="formContent">';
//debug($packet);
echo '<a class="cancel-advanced-search">X</a>';
$record = array();
    echo $form->button('Search',array(
        'type'=>'submit',
        'id'=>'advancedSearchSubmit'));
    echo $this->Html->div('', $this->element('contentAdvancedSearch',array(
        'record'=>$record,
        'display'=>'show'
        )));
    echo $this->Html->div('', $this->element('imageAdvancedSearch',array(
        'record'=>$record,
        'display'=>'show')));
//echo '</DIV>';
?>