<?php

/* @var $this ViewCC */
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'show',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Cover Material Selection',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'leather' => array(
            'type' => 'select',
            'options' => $leatherOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'FullLeather QuarterBound'
            )
        ),
        'cloth' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'QuarterBound'
            )
        ),
        'endpapers' => array(
            'type' => 'select',
            'options' => $endpaperOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'endpapers'
            )
        ),
        'liners' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'liners'
            )
        )
    )
);

echo $fieldset->fieldset($parameters);
?>