<?php
//debug($this->params);
foreach($searchRecords as $index => $record){
    if($index==0){
//        debug($record);
        echo $this->Html->para(null,'<br />Article: '.$record['Content']['heading']);
        echo $this->Html->para(null,'Collection: #'.$record['Collection']['id'].' '.$record['Collection']['heading']);        
    }
    echo '<div class="changeCollection">';
    echo $this->Html->makeLinkedImage('', $record['Content']['Image']);
    echo $this->element('contentcollectionForm_dataFields',array(
        'record'=>$record,
        'allTitles'=>$allTitles
    ));
    echo $this->element('contentForm_dataFields',array(
        'record'=>$record
    ));
    echo '</div>';
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