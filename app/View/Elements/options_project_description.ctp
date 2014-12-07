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
		'project_name',
		'time_frame',
		'budget' => array('placeholder' => 'optional'),
        'project_description' => array(
            'type' => 'textarea',
            'rows' => 10
        ),
		'product_type' => array('type' => 'hidden')
    )
);

// if the product_type (which controls which concrete product utility gets used) 
// isn't set, then we make sure it's set to trigger the default utility for these products
if (!$parameters['record']) {
	$parameters['record'] = array($parameters['model'] => array('product_type' => 'description'));
} elseif (!isset($parameters['record'][$parameters['model']]['product_type'])) {
	$parameters['record'][$parameters['model']]['product_type'] = 'description';
}

echo $this->Fieldset->fieldset($parameters);
?>
