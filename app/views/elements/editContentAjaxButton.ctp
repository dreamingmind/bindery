<?php    if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
        // I create a content_id attribute for the form so the 
        // ajax call knows what record to get for the form values
        //This is the div where the ajaxed form elements get inserted
        // This button gets a click function to toggle the form in/out of the page
        echo $form->button('Edit',array(
            'class'=>'edit',
            'type'=>'button',
            'slug'=>$slug,
            'content_id'=>$id
        ));
        echo '<div class="formContent'.$id.'"></div>';
    }
?>
