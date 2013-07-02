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
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))?$display:'show',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend:'Page Ruling Options',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Option',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'ruling' => array(
            'type'=> 'select',
            'options'=> array(
                '' => 'Select ruling',
                '1/4 rule' => '1/4" rule (normal)',
                '1/4 grid' => '1/4" grid (normal)',
                '1/5 rule' => '1/5" rule (narrow)',
                '1/5 grid' => '1/5" grid (narrow)',
                '5/32 rule' => '5/32" rule (wide)',
                '5/32 grid' => '5/32" grid (wide)',
                'Other ruling' => 'Other ruling'
            )
        )
    )
);

echo $fieldset->fieldset($parameters);
?>