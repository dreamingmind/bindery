<?php

/* @var $this ViewCC */
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'hide',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Closing Belt',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'closing_belt' => array(
            'type' => 'radio',
            'options' => array('Yes', 'No'),
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'belt'
            )
        )
    )
);

echo $fieldset->fieldset($parameters);
?>