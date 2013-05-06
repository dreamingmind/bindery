<?php
//debug($this->params);
//debug($this->viewVars);
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
    
    echo '<fieldset class="master"><legend>Master settings for the article</legend>';
    echo $this->Form->input('heading',array(
        'name'=>'data[master][heading]',
        'type'=>'text',
        'class'=>'masterheading',
        'value'=>$searchRecords[0]['Content']['heading']
    ));
    
    $options = array(
        'relink' => 'Relink all Content',
        'clone' => 'Clone all and link',
        'ignore' => 'Don\'t change any',
        );
    $attributes = array(
        'default'=>'relink',
        'name'=>"data[master][treatment]",
        'legend'=>false);
    echo $this->Form->radio('master_treatment', $options, $attributes);
    
    //Master Form section
    foreach($groups as $field => $options){
    echo $this->Form->input($field, $options);
    }
    
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

    echo '<div class="changeCollection individual_treatment" id="'.$index.'Individual">';
        echo $this->Html->makeLinkedImage('', $record['Content']['Image']);
        
        // Individual radio buttons (always visible)
        $statusLegend = $this->Html->tag('legend','Content treatment during assignment',
                array('id'=>"contentStatus$index"));
        $options = array(
            'relink' => 'Relink this Content',
            'clone' => 'Link a clone',
            'ignore' => 'Don\'t change me'
            );
        $attributes = array(
            'default'=>'relink',
            'id'=>'Content'.$index.'Treatment',
            'name'=>"data[$index][treatment]",
            'legend'=>false);
        $statusChoice = $this->Html->div(
                'individualTreatment',
                $this->Form->radio('treatment', $options, $attributes));
 
        $droplists = '';
        foreach($groups as $field => $options){
            $droplists .= $this->Form->input($field, $options);
        }
        
        $droplists = str_replace('data[master]','data['.$index.']',$droplists);
        unset($allCollections, $this->viewVars['allCollections']);
        // ContentCollection meta fields
        $cc = $this->element('contentcollectionForm_metaFields',array(
            'record'=>$record,
            'legend'=>'ContentCollection Link Fields',
            'prefix'=>array($index)//,
//            'allCollections'=>$allCollections
        ));
        
        $cc = str_replace('<fieldset>', '<fieldset class="fieldsets">', $cc);
        $cc = str_replace('similar="ContentCollectionCollectionId"', 
                'similar="ContentCollectionCollectionId" sync="1"', $cc);
            

        echo $this->Html->tag('fieldset',
                $statusLegend . $statusChoice. $droplists, array('class'=>'fieldsets'));
        echo $this->Form->input('changed',array(
            'type'=>'hidden',
            'name'=>"data[$index][changed]",
            'value'=>0,
            'id'=>$index.'changed'
        )); // end of always visible individual treatment radio buttons
        
        $contentLegend = $this->Html->tag('legend','Content',array('id'=>"cc$index"));
        $contentPara = $this->Html->para(null,$record['Content']['content']);
        $contentHead = $this->Html->tag('h4',$record['Content']['heading']);
        $contentC = $this->Form->input("Content.content",array(
            'value'=>$record['Content']['content'],
            'name'=>"data[$index][Content][content]",
            'id'=>$index.'ContentContent',
            'type'=>'textarea',
            'div' => array(
                'similar' => 'ContentContent'
            )));
        $contentID = $this->Form->input("Content.id",array(
            'value'=>$record['Content']['id'],
            'name'=>"data[$index][Content][id]",
            'id'=>$index.'ContentId',
            'type'=>'text',
            'div' => array(
                'similar' => 'ContentId',
                'sync' => true
            )));
        $contentH = $this->Form->input("Content.heading",array(
            'value'=>$record['Content']['heading'],
            'name'=>"data[$index][Content][heading]",
            'id'=>$index.'ContentHeading',
            'div' => array(
                'similar' => 'ContentHeading',
                'sync' => true
            ))) ;
        $contentPlus = 
        $this->Form->input('Content.image_id', array('type'=>'text',
            'name'=>"data[$index][Content][image_id]",
                'value'=>$record['Content']['image_id']))
                .$this->Form->input('Content.alt',array(
                    'name'=>"data[$index][Content][alt]",
                    'value'=>$record['Content']['alt']
                ))
                .$this->Form->input('Content.title',array(
                    'name'=>"data[$index][Content][title]",
                    'value'=>$record['Content']['title']
                ));
        $contentFieldset = $this->Html->tag('fieldset',
                $contentLegend.$this->Html->div("cc$index",$contentID.$contentH.$contentC.$contentPlus), array('class'=>'fieldsets'));
        echo $this->Html->div('content',$usage . $contentHead.$contentPara.$contentFieldset . $cc);
        
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