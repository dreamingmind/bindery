<?php
//debug($recentTitles);
//debug($most_recent);die;
echo $html->tag('h1',
        'From the collection: '.$most_recent[0]['Collection']['heading'].
        $this->Form->button('Related Articles',array(
            'class'=>'related',
            'collection'=>'collection'.$most_recent[0]['Collection']['id']))) . $html->div('related',''); 
echo $html->tag('h2',$most_recent[0]['Content']['heading']);
//debug($userdata);

foreach($most_recent as $entry){
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
                'action'=>'edit_dispatch'.DS.$entry['Content']['id'],
                'content_id'=>$entry['Content']['id']
                ));
            // This button gets a click function to toggle the form in/out of the page
            echo $form->button('Edit',array('class'=>'edit','type'=>'button'));
            echo $form->input('passedArgs',array(
                'type'=>'hidden',
                'value'=>  serialize($this->passedArgs)));
            echo $form->input('params',array(
                'type'=>'hidden',
                'value'=>  serialize($this->params)));
            //This is the div where the ajaxed form elements get inserted
            echo '<div class="formContent'.$entry['Content']['id'].'"></div>';
            echo '</form>';
        }
}
?>