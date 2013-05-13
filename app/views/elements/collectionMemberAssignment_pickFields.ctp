<?php
/* @var $this ViewCC */ 
/**
 * Record array
 * 
 * This fieldset element doesn't use a $record array beacuse it is
 * all post-processing data. But it does require a few
 * arrays that support selection lists of various kinds
 * 
 * Content.linked_content (array of Content.heading(s) where Content.image_id = Content.image_id, and '', 'New')
 *      the array is passed in $linkedContent
 * Content.new_collection (empty. used in post-processing)
 * Content.new_collection_category (array of possible categories)
 *      the array is passed in $collectionCategories
 * Content.recent_collections (array of recently used Collection.heading(s))
 *      passed in $recentCollections (id=>'heading (category)')
 * $groups array - a drop down list of Collections for each Category
 */
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
	?>
