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
echo $this->Html->para('modified', 'Modified on '.$last_modified);
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
    
    echo $this->element('content_AjaxEdit_editRequestButton', array(
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
    if(!empty($parents)){
        echo $this->Html->para('relatedPosts','The article above provides details for the following:');
//        debug($parents);
        foreach($parents as $parent){
    //    debug($article);die;
            $count++;
//            debug($parent);
            $category = $parent['Collection']['Category']['name'];
//            debug($category);
            if($category == 'art'){
                $linkDiv = $this->Html->foundArtBlock($this->viewVars, $parent);
            } elseif($category == 'exhibit'){
                $linkDiv = $this->Html->foundGalleryBlock($this->viewVars, $parent);
            } elseif($category == 'dispatch'){
                $linkDiv = $this->Html->relatedArticleBlock($this->viewVars, $parent);
            }
            $this->Html->twoColLinks($count, $linkDiv);
        }
         if($count % 2 == 1){
             // if we ended on an odd, we have to close the div
             echo '</div>';
        }
    }
    $count = 0;
    if(!empty($details)){
        echo $this->Html->para('relatedPosts','For additional details, also see the following:');
        foreach($details as $detail){
    //    debug($article);die;
            $count++;
            $linkDiv = $this->Html->relatedArticleBlock($this->viewVars, $detail);
            $this->Html->twoColLinks($count, $linkDiv);
        }
         if($count % 2 == 1){
             // if we ended on an odd, we have to close the div
             echo '</div>';
        }
    }
    $count = 0;
    if(count($relatedArticles) > 1){
        echo $this->Html->para('relatedPosts','Other articles in the Collection '.$most_recent[0]['Collection']['heading']);
        foreach($relatedArticles as $article){
    //    debug($article);die;
            if($most_recent[0]['Content']['slug'] != $article['Content']['slug']){
                $count++;
                $linkDiv = $this->Html->relatedArticleBlock($this->viewVars, $article);
            $this->Html->twoColLinks($count, $linkDiv);
            }
    //    echo $this->Html->siteSearchBlogBlock($this->viewVars, $article);
    //    echo $this->Html->blogMenuBlock($article);
        }
         if($count % 2 == 1){
             // if we ended on an odd, we have to close the div
             echo '</div>';
        }
    }
?>