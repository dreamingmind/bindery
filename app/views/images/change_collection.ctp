<?php
//debug($this->params);
$group = array();
if(isset($allCollections)){
    // make the grouped list into individual lists with a [0] element
    foreach($allCollections as $group => $list){
        $options = array('')+$list;
        $groups[$group] = array('options'=>$options, 'selected'=>0, 'name'=>"data[master][$group]");
    }
    if(isset($default)){
        $groups[$default[0]]['selected']=$default[1];
    }
//    debug($groups);
}
$slug = $searchRecords[0]['Content']['slug'];
$id = $searchRecords[0]['Collection']['id'];

//    if($index==0){
//        debug($record);
        echo $this->Html->para(null,'<br />Article: '.$searchRecords[0]['Content']['heading']);
        echo $this->Html->para(null,
                'Collection: #'.$searchRecords[0]['Collection']['id']
                .' '.$searchRecords[0]['Collection']['heading'] . ' in the ' 
                . ucfirst($searchRecords[0]['Collection']['Category']['name']) . ' category');        
//    }
    
    //Master Form section
    echo '<fieldset class="master"><legend>Master settings for the article</legend>';
    foreach($groups as $field => $options){
    echo $this->Form->input($field, $options);        
    }
    echo '</fieldset>';
    
foreach($searchRecords as $index => $record){
    echo '<div class="changeCollection">';
//    debug($record['Content']['ContentCollection']);
    echo $this->Html->makeLinkedImage('', $record['Content']['Image']);
   echo '<div>';
    echo $this->element('contentcollectionForm_metaFields',array(
        'record'=>$record,
        'legend'=>'ContentCollection Link Fields',
        'prefix'=>array($index),
        'allCollections'=>$allCollections
    ));
   echo $this->element('contentcollectionForm_dataFields',array(
        'record'=>$record,
        'legend'=>'ContentCollection Data Fields',
        'prefix'=>array($index),
        'allTitles'=>$allTitles
    ));
    $legend = 'Content Data Fields';
    if(count($record['Content']['ContentCollection']) > 1){
        $legend .= '<p class="aside">Additional use of this Content:</p>';
        foreach($record['Content']['ContentCollection'] as $collectionLink){
            if($collectionLink['collection_id'] != $id){
//                debug($collectionLink);
                $legend .= $this->Html->changeCollection($this->viewVars, $slug, $collectionLink['collection_id'], true);
            }
        }
    }
        
    echo $this->element('contentForm_dataFields',array(
        'prefix'=>array($index),
        'legend'=>$legend,
        'record'=>$record
    ));
    echo '</div></div>';
//    debug($record);
//    debug($record['ContentCollection']);
//    echo $this->Html->para(null,$record['Content']['content']);
}
//build the tools-set for collection assignment
//echo $this->Html->div('', $this->element('collectionMemberAssignment_pickFields', array(
//    'record'=>$val,
//    'linkedContent' => (isset($linkedContent[$val['Image']['id']])) ? $linkedContent[$val['Image']['id']] : null,
//    'recentCollections'=> $recentCollections,
//    'prefix'=> array($masterCount),
//    'allCollections' => $allCollections
//    )));
//debug($searchRecords);
?>