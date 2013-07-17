<?php

/*
 *Until End borrowed security, below, taken from newsfeed.ctp, lines 26-47 as security check to allow editing
 *This section also opens a form which is closed with content_AjaxEdit_closeForm
 * 
 * This is the admins edit form for the Content record
 * passedArgs and params are saved from the current page
 * so the full page context can be re-established
 * if the data gets saved properly.
 *     
 */
if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
    // I create a content_id attribute for the form so the 
    // ajax call knows what record to get for the form values
    echo $this->Form->create('Content', array(
//                'default'=>false,
        'class'=>'edit',
        'action'=>'edit_dispatch' //this was changed from 'edit_dispatch'
        ));
    echo $form->input('passedArgs',array(
        'type'=>'hidden',
        'name'=>'data[passedArgs]',
        'value'=>  serialize($this->passedArgs)));
    echo $form->input('params',array(
        'type'=>'hidden',
        'name'=>'data[params]',
        'value'=>  serialize($this->params)));
}

//End borrowed security segment from newsfeed.ctp


?>
