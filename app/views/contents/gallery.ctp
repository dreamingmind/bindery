<?php /* @var $this ViewCC */ ?> 
<?php
//<p>
//debug($record);die;
//debug($neighbors);
//debug($filmStrip);
////debug($introduction);
//debug($exhibit);
//debug($this->params);
//debug($nextPage);
//debug($previousPage);
//debug($this->Paginator->params);</p>
?>
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
<span class="<?php echo $record['Supplement']['headstyle'] ?>"><?php echo $record['Content']['heading'] ?></span>
<br>
<br>
<div class="markdown <?php echo $record['Supplement']['pgraphstyle'] ?>"><?php echo Markdown($record['Content']['content']) ?><br><br><br><br></div>
</div>
<?php

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