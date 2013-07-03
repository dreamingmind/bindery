<?php

/* @var $this ViewCC */
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'show',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Closing Belt',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'closing_belt' => array(
            'type' => 'radio',
            'options' => array('1' => 'Yes', '0' => 'No'),
            array('default' => '0', 'value' => 0)
        )
    )
);

echo $fieldset->fieldset($parameters);
?>