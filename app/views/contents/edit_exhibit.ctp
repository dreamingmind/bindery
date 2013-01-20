<?php

echo '<DIV class="formContent">';
    echo $session->flash();
    echo $form->button('Submit',array(
        'type'=>'submit',
        'id'=>'editExhibitSubmit'));
    echo $this->Html->div('', $this->element('contentForm_dataFields',array(
        'record'=>$packet[0],
        'display'=>'show')));
    echo $this->Html->div('', $this->element('supplementForm_dataFields',array('data'=>'','form_helper'=>$form)));//$packet[0]
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

<!--This is just example data to use when building the Supplement element-->
<div> 
    <fieldset>
        <legend id="50fba6b8-4310-46b1-93cb-">Content data fields</legend>
        <div class="50fba6b8-4310-46b1-93cb- toggleShow">
            <div class="input text">
                <label for="50fba6b8-4310-46b1-93cb--heading">Heading</label>
                <input type="text" value="A box made to fit" class="input Content_data_fields" id="50fba6b8-4310-46b1-93cb--heading" name="data[Content][heading]">
            </div>
            <div class="input text">
                <label for="50fba6b8-4310-46b1-93cb--alt">Alt</label>
                <input type="text" value="" class="input Content_data_fields" id="50fba6b8-4310-46b1-93cb--alt" name="data[Content][alt]">
            </div>
            <div class="input text">
                <label for="50fba6b8-4310-46b1-93cb--title">Title</label>
                <input type="text" value="" class="input Content_data_fields" id="50fba6b8-4310-46b1-93cb--title" name="data[Content][title]"></div>
            <div class="input radio">
                <input type="radio" checked="checked" value="1" class="input Content_data_fields" id="50fba6b8-4310-46b1-93cb--publish1" name="data[Content][publish]">
                <label for="50fba6b8-4310-46b1-93cb--publish1">Publish</label>
                <input type="radio" value="0" class="input Content_data_fields" id="50fba6b8-4310-46b1-93cb--publish0" name="data[Content][publish]">
                <label for="50fba6b8-4310-46b1-93cb--publish0">Hold</label>
            </div>
        </div>
    </fieldset>
</div>