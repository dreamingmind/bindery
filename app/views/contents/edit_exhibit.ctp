<?php

echo '<DIV class="formContent">';
    echo $session->flash();
    echo $form->button('Submit',array(
        'type'=>'submit',
        'id'=>'editExhibitSubmit'));
    echo $this->Html->div('', $this->element('contentForm_dataFields',array(
        'record'=>$packet[0],
        'display'=>'show')));
    echo $this->Html->div('', $this->element('imageForm_dataFields',array(
        'record'=>$packet[0])));
    echo $this->Html->div('', $this->element('contentForm_metaFields',array(
        'record'=>$packet[0])));
    echo $this->Html->div('', $this->element('imageForm_metaFields',array(
        'record'=>$packet[0])));
echo '</DIV>';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
