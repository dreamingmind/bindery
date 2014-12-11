<?php /* @var $this ViewCC */ ?> 
<?php
//<p>
//debug($record);die;
//debug($neighbors);
//debug($filmStrip);
////debug($introduction);
//debug($exhibit);
//debug($this->request->params);
//debug($nextPage);
//debug($previousPage);
//debug($this->Paginator->params);</p>
?>
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
<div class="proseblockpgraphstyle markdown" id="<?php echo $record['Supplement']['pgraphstyle'] ?>"><?php echo $this->Markdown->transform($record['Content']['content']) ?></div>
</div>
<?php
// This is the admins edit form for the Content record
// passedArgs and params are saved from the current page
// so the full page context can be re-established 
// if the data gets saved properly.
if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
//    debug($record);
    echo $this->Html->changeCollection($this->viewVars, $record['Content']['slug'], $record['ContentCollection'][0]['Collection']['id']);
    // I create a content_id attribute for the form so the 
    // ajax call knows what record to get for the form values
    echo $this->Form->create('Content', array(
        'default'=>false,
        'class'=>'edit',
        'action'=>'edit_exhibit',
        'content_id'=> $record['Content']['id']));
    // This button gets a click function to toggle the form in/out of the page
    echo $this->Form->button('Edit',array('class'=>'edit','type'=>'button'));
    echo $this->Form->input('passedArgs',array(
        'type'=>'hidden',
        'value'=>  serialize($this->passedArgs)));
    echo $this->Form->input('params',array(
        'type'=>'hidden',
        'value'=>  serialize($this->request->params)));
    //This is the div where the ajaxed form elements get inserted
    echo $this->Html->div('formContent');
    echo '</form>';
}
$this->Html->renderDetailLinks($details);
?>