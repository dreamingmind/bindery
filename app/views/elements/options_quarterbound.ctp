<?php

/* @var $this ViewCC */
$parameters = array(
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'hide',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Quarter Bound Material Selection',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'leather' => array(
            'type' => 'select',
            'options' => $leatherOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'Full_Leather Quarter_Bound'
            )
        ),
        'cloth' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'Quarter_Bound'
            )
        )

    )
);

echo $fieldset->fieldset($parameters);
?>