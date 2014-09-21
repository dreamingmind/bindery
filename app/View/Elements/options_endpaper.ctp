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
    'legend'=> (isset($legend))?$legend:'Endpaper',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'endpaper' => array(
            'type' => 'select',
            'options' => $endpaperOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'endpaper'
            ),
            'material' => 'endpaper' //this target diagram div background image
        )
    )
);

echo $this->Fieldset->fieldset($parameters);
?>