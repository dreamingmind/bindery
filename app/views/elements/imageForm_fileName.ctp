<?php
/* @var $this ViewCC */ 
/**
 * Image.img_file
 * Image.alt
 * Image.title
 * 
 * Image.recent_titles (array for drop list)
 * 
 */
?> 
<?php

// This has been modified so it requires $record
// but $record does not need to carry the field data
// which still remains optional. But the calling
// view needs to add 'options'=>'recent_title'
// (an array of... duh, recent titles).
// This could/should be expanded to include
// 'options'=>'category' so the category radio list
// will be dynamic too.
$parameters = array(
    'post_fields' => (isset($post_fields))
        ?$post_fields
        :false,
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=>'Image file name',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Image',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'file'
    )
);

echo $fieldset->fieldset($parameters);
?>