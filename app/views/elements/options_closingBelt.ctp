<?php

/* @var $this ViewCC */
$options = array(
    'options' => array(
        '1' => 'Yes',
        '0' => 'No'
    )
);
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'show',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Closing Belt',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'closing_belt' => array(
            'type' => 'radio',
            'options' => array('0' => 'No', '1' => 'Yes'),
            'default' => '0',
            'legend' => false,
            'option' => 'master-belt', // controls the diagram area belt div
            'setlist' => 'belt',
            'material' => 'leather' //this target diagram div background image
        )
    )
);

$htmlBlock =  $fieldset->fieldset($parameters);
/**
 * This is a rough pattern for detailing out a radio button set to act as masters
 * it should work for checkboxes or select lists too
 */
$master = array(
    'nameSpace' => '-belt',
    'sets' => $options['options']
);

$htmlBlock = preg_replace('/(type="radio")/', "$1 option=\"master{$master['nameSpace']}\"", $htmlBlock);
foreach($master['sets'] as $value => $set){
    $htmlBlock = preg_replace("/(value=\"{$value}\")/", "$1 setlist=\"{$set}\"", $htmlBlock);
}
echo $htmlBlock;
?>