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
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'leather' => array(
            'type' => 'select',
            'options' => $leatherOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'FullLeather QuarterBound'
            ),
            'material' => 'leather' //this target diagram div background image
        ),
        'cloth' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'QuarterBound'
            ),
            'material' => 'cloth' //this target diagram div background image
        ),
        'endpapers' => array(
            'type' => 'select',
            'options' => $endpaperOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'endpapers'
            ),
            'material' => 'endpaper' //this target diagram div background image
        ),
        'liners' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'liners'
            ),
            'material' => 'cloth' //this target diagram div background image
        )
    )
);

echo $fieldset->fieldset($parameters);
?>