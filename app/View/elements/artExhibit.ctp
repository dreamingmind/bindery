<div id="exhibit">
    <?php
    echo $this->Html->image(
            'images'.DS.'thumb'.DS.'x640y480'.DS.$record['Image']['img_file'],
            array('alt'=>$record['Image']['alt'].' '.$record['Content']['alt']))."\n";
    //<img alt="" src="/bindery/img/images/thumb/x640y480/DSCN3920.jpg">
    echo $this->Html->changeCollection($this->viewVars, $record['Content']['slug'], $record['ContentCollection'][0]['collection_id']);
//    debug($record);
    ?>
<!--    <style media="screen" type="text/css">
        
        #detail {
            position: relative;
        }
        #proseblock {
            /*position: absolute;*/
            z-index: 3;
            top: <?php // echo $record['Supplement']['top_val'] ?>px;
            left: <?php // echo $record['Supplement']['left_val'] ?>px;
            width: <?php // echo $record['Supplement']['width_val'] ?>px;
            height: <?php // echo $record['Supplement']['height_val'] ?>px;
        }
        
    </style>-->
    <div id="proseblock" >
    <h2 id="exhibitTitle"><?php echo $record['Content']['heading'] ?></h2>
    <div id="exhibitContent"><?php echo $this->Markdown->transform($record['Content']['content']) ?></div>
    </div>
<?php
//    if(!empty($details)){
//        $message = (count($details) > 1) 
//            ? 'Here are ' . count($details) . ' reprints of related blog articles.'
//            : 'Here is a reprint of a related blog article.';
//        echo $this->Html->tag('h4',$message);
//        foreach($details as $detail){
//            echo $this->Html->artDetailBlock($this->viewVars, $detail,'images/thumb/x75y56/');
//        }
//    }
    $this->Html->renderDetailLinks($details);
//debug($this->viewVars['usergroupid']);
// This is the admins edit form for the Content record
// passedArgs and params are saved from the current page
// so the full page context can be re-established 
// if the data gets saved properly.
    echo $this->Form->create('Content', array(
//                'default'=>false,
        'class'=>'edit',
        'action'=>'edit_dispatch'//.DS.$entry['Content']['id'],
//                'content_id'=>$entry['Content']['id']
        ));
    echo $this->element('content_AjaxEdit_editRequestButton', array(
        'slug'=>$record['Content']['slug'],
        'id'=>$record['Content']['id']
    ));
    echo '</form>';
	?>
</div>