<?php /* @var $this ViewCC */ ?> 
<?php
//<p>
//debug($this->viewVars); die;
//debug($record);
//debug($neighbors);
//debug($filmStrip);
//debug($introduction);
//debug($dispatch);
//debug($this->request->params);
//debug($nextPage);
//debug($previousPage);
//debug($this);//</p>
$h2 = null; // suppress repeated dispatch heading
$path = 'images/thumb/x500y375/';
//$path = 'images/thumb/x160y120/';
//$path = 'images/thumb/x800y600/';

echo $this->Html->tag('h1',$collectionData['heading'],array(
    'class' => 'related',
    'collection'=> $collectionData['id']
));
echo $this->Html->tag('p',$collectionData['text']);

//debug($collectionData);die;
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
    echo $this->Form->input('passedArgs',array(
        'type'=>'hidden',
        'name'=>'data[passedArgs]',
        'value'=>  serialize($this->passedArgs)));
    echo $this->Form->input('params',array(
        'type'=>'hidden',
        'name'=>'data[params]',
        'value'=>  serialize($this->request->params)));
}

foreach ($collectionPage as $dispatch) {
    if ($h2 != $dispatch['heading'] && $dispatch['heading'] != null) {
//        debug($dispatch);die;
        $blog_link = $this->Html->link('See Blog Article','/blog/'.$dispatch['collection_id'].'/'.$dispatch['slug']);
        $blog_link .= $this->Html->changeCollection($this->viewVars, $dispatch['slug'], $dispatch['collection_id']);
        echo $this->Html->tag('h2', $dispatch['heading'].$blog_link);
    }
    
    // heading
    $h2 = $dispatch['heading'];
    // text
    $p = markdown($dispatch['content']);
//    $p = $this->Html->tag('p',markdown($dispatch['content']), array('class'=>'dispatchText'));
    $p = $this->Html->tag('div', $p, array('class'=>'content markdown x640y480'));
    
    // image
    if(isset($dispatch['img_file'])){
        $i = $this->Html->image($path.$dispatch['img_file'], array(
            'id'=>'im'.$dispatch['image_id'],
            'alt'=>$dispatch['alt'],
            'title'=>$dispatch['title']
        ));
    } else {
        $i = $this->Html->image('transparent.png',array('id'=>'im'.$dispatch['image_id'],
'alt'=>'Missing Image', 'class'=>'missing'));
    }
    
    // anchor to here
    $a = $this->Html->tag('a', '', array(
        'name'=>'id'.$dispatch['id'],
        'class'=>'dispatchAnchor'
    ));

    // admin's edit tool
    $e = null;
    $d = null;
    if (isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
//    $e = "<ul class='adminMenu'>\r<li>".
//        $this->Html->link("Edit<br />im-id:{$dispatch['image_id']}", '#', array(
//        'name' => 'fieldset'.$dispatch['id'],
//        'onclick'=> 'showhide(this.name, \'block\'); return false',
//        'escape' => false
//        )) .
//        "</li>\r</ul>\r";
//        debug($dispatch);
        $e = $this->Form->button('Edit',array(
            'class'=>'edit',
            'type'=>'button',
            'slug' => $dispatch['slug'],
            'content_id'=>$dispatch['id']
    ));
        $d = '<div class="formContent'.$dispatch['id'].'"></div>';
    }

    // image zoom tool
    $m = "<menu class='zoom'><a>-</a> <a>+</a></menu>";
    // image nav block, the categories for this image
    $collection_list = '';
    foreach($dispatch['collections'] as $collection_id => $collection_heading){
        $collection_list .= $this->Html->tag('li', 
                $this->Html->link($collection_heading[0], array(
                    'action'=>'newsfeed',
                    'pname'=>$collection_heading[1])));
    }
    $in = $this->Html->div('imgNav',
            $this->Html->div('tools',
                    $this->Html->tag('p','Collections'). "<ul class='categories'>$collection_list</ul>".
                    $this->Html->tag('p',date('M j, Y', $dispatch['date'])).$e));
    
    echo $this->Html->div('dispatch', $m."\r".$a."\r".$in."\r".$i."\r".$p."\r");
    echo $d;
//    echo $this->Form->create('Content', array(
//            'id'=>'fieldset'.$dispatch['id'],
//            'action' => 'dispatch_edit/'.$this->request->params['pname'] . 
//            (isset($this->request->params['named']['page']) ? '/page:' . $this->request->params['named']['page'] : 'page:/' . 1),
////            array('pass' => array($this->request->params['pname'])),
//            'style' =>'display: none;'
//            )
//        );
//
//    echo $this->element('contentForm_metaFields', array(
//        'record' => array('Content'=>$dispatch)
//    ));
//    
//    echo $this->element('contentForm_dataFields', array(
//        'record' => array('Content'=>$dispatch),
//        'display'=>'show'
//    ));
//    
//    echo $this->Form->end('Submit');
}
echo '</form>';
?>
