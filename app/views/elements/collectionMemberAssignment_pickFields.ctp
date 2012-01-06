<?php
/* @var $this ViewCC */ 
?> 
	<?php
$parameters = array(
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=>'Collection Membership Assignment',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Content',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'linked_content' => array(
            'options'=>$linkedContent),
        'new_collection',
        'recent_collections' => array(
            'options'=> $recentCollections),
        'all_collections' => array(
            'options'=> $allCollections),
//        'title',
//        'publish'=> array(
//            'type'=>'radio',
//            'options'=> array(
//                '1'=>'Publish', '0'=>'Hold' 
//            )
//         )
    )
);

echo $fieldset->fieldset($parameters);
       
       $this->Js->buffer(
               "$('#{$fieldset->unique}').click(function() {
  $('.{$fieldset->unique}').toggle(50, function() {
    // Animation complete.
  });
});
");
//debug($linkedContent);
//debug($recentCollections);
//debug($allCollections);
	?>
