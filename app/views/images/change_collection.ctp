<?php
//debug($this->params);
echo $this->Html->tag('h1','Article: '.$slug);
echo $this->Html->para(null,'Collection: '.$collection_id);
foreach($searchRecords as $record){
    echo $this->element('contentcollectionForm_dataFields',array(
        'record'=>$record,
        'allTitles'=>$allTitles
    ));
    echo $this->element('contentForm_dataFields',array(
        'record'=>$record
    ));
//    debug($record['ContentCollection']);
    echo $this->Html->para(null,$record['Content']['content']);
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