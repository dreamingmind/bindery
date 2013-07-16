<?php
//Display the detail workshop

echo $this->element('workshopFeature');

//Display articles related to this workshop

foreach($article as $entry){
    $cls = str_replace(array('.','-'), '', $entry['Content']['Image']['img_file']);
    echo $html->div('entry',

'        <menu class="local_zoom" id="'.$cls.'" >
            <a class="local_scale_tool">-</a> 
            <a class="local_scale_tool">+</a>
        </menu>
'
        // the div content
        . $html->image(
            'images'.DS.'thumb'.DS.'x320y240'.DS.$entry['Content']['Image']['img_file'],
            array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'],
                'class'=>'scalable '.$cls)
        )
        ."\n"
        . $html->div($cls . ' entryText x320y240 markdown',Markdown($entry['Content']['content']),
        array(''/* the div attributes */)));
    
        if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
            // I create a content_id attribute for the form so the 
            // ajax call knows what record to get for the form values
            //This is the div where the ajaxed form elements get inserted
            // This button gets a click function to toggle the form in/out of the page
            echo $form->button('Edit',array(
                'class'=>'edit',
                'type'=>'button',
                'slug'=>$article[0]['Content']['slug'],
                'content_id'=>$entry['Content']['id']
            ));
            echo '<div class="formContent'.$entry['Content']['id'].'"></div>';
        }
}
echo '</form>';
?>