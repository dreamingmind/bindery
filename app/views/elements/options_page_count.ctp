<?php

/* @var $this ViewCC */
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'show',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Page Count',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'pages' => array(
            'type' => 'select',
            'options' => array(
                '-1' => 'Select page count',
                '128' => '128 pages',
                '192' => '192 pages',
                '256' => '256 pages',
                'other' => 'See my special instructions'
//            ),
//            'div' => array(
//                'option' => 'slave-'.$productCategory,
//                'setList' => 'bookbody'
            )
        )
    )
);

echo $fieldset->fieldset($parameters);
?>