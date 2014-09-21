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
    'model' => 'Workshop',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'id',
        'title',
        'description' => array(
            'type' => 'textarea'
        ),
        'hours',
        'Sessions.title',
        'Sessions.first_day',
        'Sessions.last_day'
    )
);

echo $this->Fieldset->fieldset($parameters);
?>
