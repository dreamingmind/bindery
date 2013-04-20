<?php
echo $html->css('search_links');
//debug($collection);
//debug($artedition);
//$path = 'images/thumb/x75y56/';
//$path = 'images/thumb/x160y120/';
//
//// patterns in markdown: links, images, paragraphs
//$patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/');
//$replace = array('','',' ');
//debug($patterns);
//$details = array();
//echo $html->image('transparent.png', array('id'=>'noThumbTransparent'));
?>
<div id="intro">
    <?php
    echo $html->tag('h1',$collection['Collection']['heading'], array(
        'class' => 'related',
        'collection' => $collection['Collection']['id']
    ));
    echo Markdown($collection['Collection']['text']);
    ?>
 </div>
<div id="reference-grid"></div>
<?php
echo $this->Html->image(
        'images'.DS.'thumb'.DS.'x640y480'.DS.$record['Image']['img_file'],
        array('alt'=>$record['Image']['alt'].' '.$record['Content']['alt']))."\n";
//<img alt="" src="/bindery/img/images/thumb/x640y480/DSCN3920.jpg">
?>
<style media="screen" type="text/css">
    <!--
    #detail {
        position: relative;
    }
    #proseblock {
        position: absolute;
        z-index: 3;
        top: <?php echo $record['Supplement']['top_val'] ?>px;
        left: <?php echo $record['Supplement']['left_val'] ?>px;
        width: <?php echo $record['Supplement']['width_val'] ?>px;
        height: <?php echo $record['Supplement']['height_val'] ?>px;
    }
    -->
</style>
<div id="proseblock" >
<h1 class="proseblockheadstyle" id="<?php echo $record['Supplement']['headstyle'] ?>"><?php echo $record['Content']['heading'] ?></h1>
<div class="proseblockpgraphstyle markdown" id="<?php echo $record['Supplement']['pgraphstyle'] ?>"><?php echo Markdown($record['Content']['content']) ?></div>
</div>
<?php
    if(!empty($details)){
        $message = (count($details) > 1) 
            ? 'Here are ' . count($details) . 'additional, related articles.'
            : 'Here is an additional, related article.';
        echo $this->Html->tag('h4',$message);
        foreach($details as $detail){
            $detail_data = explode(':', $detail);
            $image = $this->Html->image('images'.DS.'thumb'.DS.'x75y56'.DS.$detail_data[2]);
//            echo $image;
            $link = $this->Html->link($image,
                    DS.'blog'.DS.$detail_data[0].DS.$detail_data[1],
                    array('escape'=>false,'class'=>'detaillink')
            );
            echo $link;
        }
        
    }

// This is the admins edit form for the Content record
// passedArgs and params are saved from the current page
// so the full page context can be re-established 
// if the data gets saved properly.
if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
    // I create a content_id attribute for the form so the 
    // ajax call knows what record to get for the form values
    echo $this->Form->create('Content', array(
        'default'=>false,
        'class'=>'edit',
        'action'=>'edit_exhibit',
        'content_id'=> $record['Content']['id']));
    // This button gets a click function to toggle the form in/out of the page
    echo $form->button('Edit',array('class'=>'edit','type'=>'button'));
    echo $form->input('passedArgs',array(
        'type'=>'hidden',
        'value'=>  serialize($this->passedArgs)));
    echo $form->input('params',array(
        'type'=>'hidden',
        'value'=>  serialize($this->params)));
    //This is the div where the ajaxed form elements get inserted
    echo $html->div('formContent');
    echo '</form>';
}
?>
