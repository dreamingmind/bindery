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
$details = array();
echo $html->image('transparent.png', array('id'=>'noThumbTransparent'));
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
<?php
if(isset($artedition) && !empty($artedition)){
//    debug($userdata);
            // This is the admins edit form for the Content record
            // passedArgs and params are saved from the current page
            // so the full page context can be re-established 
            // if the data gets saved properly.
    if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
        // I create a content_id attribute for the form so the 
        // ajax call knows what record to get for the form values
        echo $this->Form->create('Content', array(
    //                'default'=>false,
            'class'=>'edit',
            'action'=>'edit_dispatch'//.DS.$entry['Content']['id'],
    //                'content_id'=>$entry['Content']['id']
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

    foreach($artedition as $entry){
//        debug($entry);die;
        if(!empty($entry['ContentCollection']['sub_slug']) && $entry['ContentCollection']['sub_slug'] != 0){
            $details[] = $entry['ContentCollection']['sub_slug'];
        }
        $cls = str_replace(array('.','-'), '', $entry['Content']['Image']['img_file']);
        echo $html->div('entry',

    '        <menu class="local_zoom" id="'.$cls.'" >
                <a class="local_scale_tool">-</a> 
                <a class="local_scale_tool">+</a>
            </menu>
    '
            // the div content
            . $html->image(
                'images'.DS.'thumb'.DS.'x640y480'.DS.$entry['Content']['Image']['img_file'],
                array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'],
                    'class'=>'scalable '.$cls)
            )
            ."\n"
            . $html->div($cls . ' entryText x640y480 markdown',Markdown($entry['Content']['content']),
            array(''/* the div attributes */)));

            if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
                // I create a content_id attribute for the form so the 
                // ajax call knows what record to get for the form values
                //This is the div where the ajaxed form elements get inserted
                // This button gets a click function to toggle the form in/out of the page
                echo $form->button('Edit',array(
                    'class'=>'edit',
                    'type'=>'button',
                    'slug'=>$artedition[0]['Content']['slug'],
                    'content_id'=>$entry['Content']['id']
                ));
                echo '<div class="formContent'.$entry['Content']['id'].'"></div>';
            }
    }
    echo '</form>';
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
}
?>
