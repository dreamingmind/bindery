<?php
/* @var $this ViewCC */ 

/**
 * ContentCollection.id
 * ContentCollection.seq
 * ContentCollection.publish 
 * ContentCollection.sub_slug
 */
?> 
	<?php
//debug($record);
$parameters = array(
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend:'ContentCollection data fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'ContentCollection',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'id'=>array(
            'type'=>'hidden'
        ),
        'seq',
        'publish'=> array(
            'type'=>'radio',
            'options'=> array(
                '1'=>'Publish', '0'=>'Hold/In-line' 
            )
         ),
        'sub_slug'=>array(
            'options'=>$allTitles
        )
    )
);

echo $fieldset->fieldset($parameters);
	?>
