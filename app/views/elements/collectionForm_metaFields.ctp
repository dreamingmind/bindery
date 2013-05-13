<?php
/* @var $this ViewCC */ 
/**
 * Content.id
 * Content.image_id
 */
?> 
	<?php
$parameters = array(
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=>'Content meta fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Content',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'id',
        'category_id'//,
//        'modified',
//        'created',
    )
);

echo $fieldset->fieldset($parameters);
	?>
