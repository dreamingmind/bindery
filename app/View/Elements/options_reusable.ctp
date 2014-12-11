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
        'reusable_pages' => array(
            'type' => 'select',
            'options' => array(
                '-1' => 'Select page count',
				'discuss' => 'Not sure',
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
        'reusable_ruling' => array(
            'type'=> 'select',
            'options'=> array(
                '' => 'Select ruling',
                'blank' => 'Blank',
                '1/4 rule' => '1/4" rule (normal)',
                '1/4 grid' => '1/4" grid (normal)',
                '1/5 rule' => '1/5" rule (narrow)',
                '1/5 grid' => '1/5" grid (narrow)',
                '5/32 rule' => '5/32" rule (wide)',
                '5/32 grid' => '5/32" grid (wide)',
                'Other ruling' => 'Other ruling'
//            ),
//            'div' => array(
//                'option' => 'slave-'.$productCategory,
//                'setList' => 'bookbody'
            )
        ),
        'reusable_endpaper' => array(
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