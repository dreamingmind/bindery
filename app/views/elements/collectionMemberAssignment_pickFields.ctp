<?php
/* @var $this ViewCC */ 
?> 
<?php
// make the grouped list into individual lists with a [0] element
foreach($allCollections as $group => $list){
    $options = array('')+$list;
    $groups[$group] = array('options'=>$options, 'multiple'=>'multiple', 'default'=>0);
}
//debug($allCollections);die;
$parameters = array(
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=>'Collection Membership Assignment',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Content',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'linked_content' => array(
            'options'=>$linkedContent,
            'value'=>0,
            'before'=>'First, choose a Content record:'),
        'new_collection'=>array(
            'before'=>'Second, create or choose some Collection for it:'
        ),
        'new_collection_category'=>array(
            'type'=>'radio',
            'options'=>$collectionCategories
        ),
        'recent_collections' => array(
            'options'=> $recentCollections,
            'selected'=>0),
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
//debug($linkedContent);
//debug($recentCollections);
//debug($allCollections);
	?>
