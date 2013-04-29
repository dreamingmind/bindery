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
    
    echo $this->Form->input('heading',array(
        'name'=>'data[master][heading]',
        'type'=>'text',
        'class'=>'masterheading',
        'value'=>$searchRecords[0]['Content']['heading']
    ));
    
    $options = array(
        'individual' => 'Set each record individually',
        'relink' => 'Relink all Content',
        'clone' => 'Clone all and link',
        'ignore' => 'Don\'t change any',
        );
    $attributes = array(
        'default'=>'relink',
        'name'=>"data[master][treatment]",
        'legend'=>false);
    echo $this->Form->radio('treatment', $options, $attributes);
    
    echo $this->Form->Submit();
    echo '</fieldset>';
    
foreach($searchRecords as $index => $record){
            
        $legend = '';
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

        $usage = $this->Html->para(null, $legend);

    echo '<div class="changeCollection individual_treatment">';
    //    debug($record['Content']['ContentCollection']);
        echo $this->Html->makeLinkedImage('', $record['Content']['Image']);
        
        // Individual radio buttons (always visible)
        $statusLegend = $this->Html->tag('legend','Content treatment during assignment',
                array('id'=>"contentStatus$index"));
        $options = array(
            'ignore' => 'Don\'t change me',
            'relink' => 'Relink this Content',
            'clone' => 'Link a clone'
            );
        $attributes = array(
            'default'=>'relink',
            'name'=>"data[$index][treatment]",
            'legend'=>false);
        $statusChoice = $this->Html->div(null,$this->Form->radio('treatment', $options, $attributes));
        
            // ContentCollection meta fields
            $cc = $this->element('contentcollectionForm_metaFields',array(
                'record'=>$record,
                'legend'=>'ContentCollection Link Fields',
                'prefix'=>array($index),
                'allCollections'=>$allCollections
            ));
            
        echo $this->Html->tag('fieldset',
                $statusLegend . $statusChoice. $cc, array('class'=>'fieldsets'));
        echo $this->Form->input('changed',array(
            'type'=>'hidden',
            'name'=>"data[$index][changed]",
            'value'=>0,
            'id'=>$index.'changed'
        )); // end of always visible individual treatment radio buttons
        
        $contentLegend = $this->Html->tag('legend','Content',array('id'=>"cc$index"));
        $contentPara = $this->Html->para(null,$record['Content']['content']);
        $contentHead = $this->Html->tag('h4',$record['Content']['heading']);
        $contentC = $this->Form->input("$index.Content.content",array(
            'value'=>$record['Content']['content'],
            'type'=>'textarea'));
        $contentID = $this->Form->input("$index.Content.id",array('value'=>$record['Content']['id'], array(
            'type'=>'hidden'
        )));
        $contentH = $this->Form->input("$index.Content.heading",array('value'=>$record['Content']['heading']));
        $contentFieldset = $this->Html->tag('fieldset',
                $contentLegend.$this->Html->div("cc$index",$contentID.$contentH.$contentC), array('class'=>'fieldsets'));
        echo $this->Html->div('content',$usage . $contentHead.$contentPara.$contentFieldset);
        
//        
//        echo $this->Html->para('fieldsets','Click to open field tools',array('id'=>"cc$index"));
//
//        echo "<div class='cc$index fieldsets individual_data'>"; // collapsing div of internal fields
        
            // ContentCollection data fields
//            echo $this->element('contentcollectionForm_dataFields',array(
//                'record'=>$record,
//                'legend'=>'ContentCollection Data Fields',
//                'prefix'=>array($index),
//                'allTitles'=>$allTitles
//            ));
            
            // Content meta fields
//            echo $this->element('contentForm_metaFields',array(
//                'prefix'=>array($index),
//                'record'=>$record
//            ));
            
            // Content data fields
//            $legend = 'Content Data Fields';
//            echo $this->element('contentForm_dataFields',array(
//                'prefix'=>array($index),
//                'legend'=>$legend,
//                'record'=>$record
//            
            
            
//        echo '</div>'; // end of collapsing internal fields
    echo '</div>'; // end of single Content block
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