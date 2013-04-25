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
echo $this->Form->create('Image', array('action'=>"change_collection/$slug/$id"));
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
    echo $this->Form->Submit();
    echo '</fieldset>';
    
foreach($searchRecords as $index => $record){
    echo '<div class="changeCollection">';
    //    debug($record['Content']['ContentCollection']);
        echo $this->Html->makeLinkedImage('', $record['Content']['Image']);
        $statusLegend = $this->Html->tag('legend','Content treatment during assignment',
                array('id'=>"contentStatus$index"));
        $options = array(
            'ignore' => 'Don\'t change me',
            'relink' => 'Relink this Content',
            'clone' => 'Link a clone'
            );
        $attributes = array(
            'default'=>'ignore',
            'name'=>"data[$index][treatment]",
            'legend'=>false);
        $statusChoice = $this->Form->radio('treatment', $options, $attributes);
        echo $this->Html->tag('fieldset',
                $statusLegend . $statusChoice, array('class'=>'fieldsets'));
        echo $this->Form->input('changed',array(
            'type'=>'hidden',
            'name'=>"data[$index][changed]",
            'value'=>0
        ));
        echo $this->Html->para('fieldsets','Click to open field tools',array('id'=>"cc$index"));
//            
//        
//        //Bundle the legend and inputs into a fieldset, wrapping 
//        // the inputs in a div that keys to the legend
//        // for show/hide toggling
//        $this->fieldset = $this->Html->tag('fieldset',
//            $this->legendTag
//            . $this->Html->div($this->unique.' '.$this->display,
//            $this->pre_fields . implode('', $this->inputs) . $this->post_fields)

        echo "<div class='cc$index fieldsets'>";
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
                        $legend .= str_replace(
                                'Change collection', 
                                'Change collection: '.$collectionLink['Collection']['heading'],
                                $this->Html->changeCollection($this->viewVars, $slug, $collectionLink['collection_id']));
                    }
                }
            }

            echo $this->element('contentForm_dataFields',array(
                'prefix'=>array($index),
                'legend'=>$legend,
                'record'=>$record
            ));
        echo '</div>';
    echo '</div>';
    $this->Js->buffer(
        "$('#cc$index').click(function() {
            $('.cc$index').toggle(50, function() {
            // Animation complete.
            });
        });
    ");

}
    echo $this->Form->end();
?>