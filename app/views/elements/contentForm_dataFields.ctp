<?php

/* @var $this ViewCC */

/**
 * Content.heading
 * Content.content
 * Content.alt
 * Content.title
 */
?> 
<?php

$parameters = array(
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'hide',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Content data fields',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => 'Content',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'heading',
        'content' => array(
            'type' => 'textarea'
        ),
        'alt',
        'title',
//        'publish'=> array(
//            'type'=>'radio',
//            'options'=> array(
//                '1'=>'Publish', '0'=>'Hold' 
//            )
//         )
    )
);

echo $fieldset->fieldset($parameters);
?>
