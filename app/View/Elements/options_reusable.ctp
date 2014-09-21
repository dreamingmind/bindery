<?php

/* @var $this ViewCC */
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'show',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Bookbody',
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
        ),
        'ruling' => array(
            'type'=> 'select',
            'options'=> array(
                '-1' => 'Select ruling',
                'blank' => 'Blank',
                '14l' => '1/4" rule (normal)',
                '14g' => '1/4" grid (normal)',
                '15l' => '1/5" rule (narrow)',
                '15g' => '1/5" grid (narrow)',
                '532l' => '5/32" rule (wide)',
                '532g' => '5/32" grid (wide)',
                'Other' => 'See my special instructions'
//            ),
//            'div' => array(
//                'option' => 'slave-'.$productCategory,
//                'setList' => 'bookbody'
            )
        ),
        'endpapers' => array(
            'type' => 'select',
            'options' => $endpaperOptions,
            'material' => 'endpaper' //this target diagram div background image
//            ,
//            'div' => array(
//                'option' => 'slave-'.$productCategory,
//                'setList' => 'bookbody'
//            )
        )
    )
);

echo $this->Fieldset->fieldset($parameters);
?>