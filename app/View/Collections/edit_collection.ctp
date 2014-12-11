<?php

//echo '<DIV class="formContent">';
//debug($packet);
    echo $this->Session->flash();
//    $linkNumber = $packet[0]['Content']['id'];
//    echo $this->Html->div('', $this->element('supplementForm_dataFields',array(
//        'data'=>$packet[0],
//        'form_helper'=>$form,
//        'prefix'=>array('ContentCollection','0'),
//        'supplement_defaults' => $packet[0]['ContentCollection'][0]['Collection']['Category']['supplement_list'],
//        'supplements' => $packet[0]['ContentCollection'][0]['Supplement'],
//        'content_collection_id' => $packet[0]['ContentCollection'][0]['id'])));//
    echo $this->Form->button('Submit All',array(
        'type'=>'submit',
        'id'=>'editExhibitSubmit'));
    echo $this->Html->div('', $this->element('collectionForm_dataFields',array(
        'record'=>$packet[0],
//        'post_fields'=>$iiLinks,
        'display'=>'show'
        )));
    echo $this->Html->div('', $this->element('collectionForm_metaFields',array(
        'record'=>$packet[0],
//        'linkNumber' => $linkNumber,
        'display'=>'hide')));
//echo '</DIV>';
?>