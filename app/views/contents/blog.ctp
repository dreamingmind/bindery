<?php
//debug($recentTitles);
//debug($most_recent);die;
echo $this->Html->changeCollection($this->viewVars, $most_recent[0]['Content']['slug'], $most_recent[0]['Collection']['id']);
echo $html->tag('h1',
        'From the collection: '.$most_recent[0]['Collection']['heading'].
        $this->Form->button('Related Articles',array(
            'class'=>'related',
            'slug'=>$most_recent[0]['Content']['slug'],
            'collection'=>'collection'.$most_recent[0]['Collection']['id']))) . $html->div('related',''); 
echo $html->tag('h2',$most_recent[0]['Content']['heading']);
//debug($userdata);
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
            'images'.DS.'thumb'.DS. $size .DS.$entry['Content']['Image']['img_file'],
            array('alt'=>$entry['Content']['Image']['alt'].' '.$entry['Content']['Image']['alt'],
                'class'=>'scalable '.$cls . ' img'.$size)
        )
        ."\n"
        . $html->div($cls . ' entryText ' . $size . ' markdown',Markdown($entry['Content']['content']),
        array(''/* the div attributes */)));
    
    echo $this->element('editContentAjaxButton', array(
        'slug'=>$most_recent[0]['Content']['slug'],
        'id'=>$entry['Content']['id']
    ));
//        if(isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
//            // I create a content_id attribute for the form so the 
//            // ajax call knows what record to get for the form values
//            //This is the div where the ajaxed form elements get inserted
//            // This button gets a click function to toggle the form in/out of the page
//            echo $form->button('Edit',array(
//                'class'=>'edit',
//                'type'=>'button',
//                'slug'=>$most_recent[0]['Content']['slug'],
//                'content_id'=>$entry['Content']['id']
//            ));
//            echo '<div class="formContent'.$entry['Content']['id'].'"></div>';
//        }
}
echo '</form>';
    $count = 0;
    echo $this->Html->para('relatedPosts','Other articles in the Collection '.$most_recent[0]['Collection']['heading']);
    foreach($relatedArticles as $article){
//    debug($article);die;
    if($most_recent[0]['Content']['slug'] != $article['Content']['slug']){
        $count++;
        $linkDiv = $this->Html->relatedArticleBlock($this->viewVars, $article);
        if($count % 2 == 1){
            echo '<div style="clear: both;">';
            echo str_replace('class="linkDiv"', 'class="linkDiv" style="float: left;"', $linkDiv);
        } else {
            echo str_replace('class="linkDiv"', 'class="linkDiv" style="float: right;"', $linkDiv);
            echo '</div>';
        }
//        echo $this->Html->relatedArticleBlock($this->viewVars, $article,'images/thumb/x75y56/');
    }
//    echo $this->Html->siteSearchBlogBlock($this->viewVars, $article);
//    echo $this->Html->blogMenuBlock($article);
}
?>