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

$group = $groups = array();
if(isset($allCollections)){
    // make the grouped list into individual lists with a [0] element
    foreach($allCollections as $group => $list){
        $options = array('')+$list;
        $groups[$group] = array('options'=>$options, 'selected'=>0);
    }
    if(isset($default)){
        $groups[$default[0]]['selected']=$default[1];
    }
//    debug($default);
}
//debug($groups);
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
        'id' => array(
            'div' => array('similar' => 'ContentCollectionId')
        ),
        'content_id' => array(
            'div' => array('similar' => 'ContentCollectionContentId')
        ),
        'collection_id' => array(
            'div' => array('similar' => 'ContentCollectionCollectionId')
        )
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
