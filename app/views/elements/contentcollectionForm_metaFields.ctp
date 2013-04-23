<?php
/* @var $this ViewCC */ 

/**
 * ContentCollection.id
 * ContentCollection.content_id
 * ContentCollection.collection_id 
 * $groups array - a drop down list of Collections for each Category
 */
?> 
<?php

$group = array();
if(isset($allCollections)){
    // make the grouped list into individual lists with a [0] element
    foreach($allCollections as $group => $list){
        $options = array('')+$list;
        $groups[$group] = array('options'=>$options, 'default'=>0);
    }
}
//debug($record);
$parameters = array(
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend:'ContentCollection meta fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'ContentCollection',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'id',
        'content_id',
        'collection_id'
    ) + $groups
);

echo $fieldset->fieldset($parameters);
       
       $this->Js->buffer(
               "$('#{$fieldset->unique}').click(function() {
  $('.{$fieldset->unique}').toggle(50, function() {
    // Animation complete.
  });
});
");
	?>
