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
    'legend'=> (isset($legend))?$legend:'Project Description',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
		'project_name' => array('placeholder' => 'optional'),
		'quantity',
		'time_frame' => array('placeholder' => 'optional'),
		'budget' => array('placeholder' => 'optional'),
        'project_description' => array(
            'type' => 'textarea',
            'rows' => 10
        ),
		'id' => array('type' => 'hidden'),
    )
);

echo $this->Fieldset->fieldset($parameters);
?>
