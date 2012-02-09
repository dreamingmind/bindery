<?php /* @var $this ViewCC */ ?> 
<?php
//<p>
//debug($this->viewVars); die;
//debug($record);
//debug($neighbors);
//debug($filmStrip);
//debug($introduction);
//debug($dispatch);
//debug($this->params);
//debug($nextPage);
//debug($previousPage);
//debug($this);//</p>
$h2 = null; // suppress repeated dispatch heading
$path = 'images/thumb/x500y375/';
//$path = 'images/thumb/x160y120/';
//$path = 'images/thumb/x800y600/';

echo $this->Html->tag('h1',$content[0]['Collection']['heading']);
echo $this->Html->tag('p',$content[0]['Collection']['text']);

foreach ($content as $index => $dispatch) {
    if ($h2 != $dispatch['Content']['heading'] && $dispatch['Content']['heading'] != null) {
        echo $this->Html->tag('h2', $dispatch['Content']['heading']);
    }
    
    // heading
    $h2 = $dispatch['Content']['heading'];
    // text
    $p = $this->Html->tag('p',$dispatch['Content']['content'], array('class'=>'dispatchText'));
    
    // image
    if(isset($dispatch['Content']['Image']['img_file'])){
        $i = $this->Html->image($path.$dispatch['Content']['Image']['img_file'], array(
            'alt'=>$dispatch['Content']['alt'],
            'title'=>$dispatch['Content']['title']
        ));
    } else {
        $i = $this->Html->image('transparent.png',array('alt'=>'Missing Image', 'class'=>'missing'));
    }
    
    // anchor to here
    $a = $this->Html->tag('a', '', array(
        'name'=>'dispatch'.$dispatch['Content']['id'],
        'class'=>'dispatchAnchor'
    ));

    // admin's edit tool
    $e=null;
    if (isset($this->viewVars['usergroupid']) && $this->viewVars['usergroupid']<3){
    $e = "<ul class='adminMenu'>\r<li>".
        $this->Html->link("Edit<br />im-id:{$dispatch['Content']['image_id']}", '#', array(
        'name' => 'fieldset'.$dispatch['Content']['id'],
        'onclick'=> 'showhide(this.name, \'block\'); return false',
        'escape' => false
        )) .
        "</li>\r</ul>\r";
    }

    // image zoom tool
    $m = "<menu class='zoom'><a>-</a> <a>+</a></menu>";
    // image nav block, the categories for this image
    $collection_list = '';
    foreach($dispatch['collections'] as $collection_id => $collection_heading){
        $collection_list .= $this->Html->tag('li', 
                $this->Html->link($collection_heading, array(
                    'action'=>'newsfeed',
                    'pname'=>$collection_heading)));
    }
    $in = $this->Html->div('imgNav',
            $this->Html->div('tools',
                    $this->Html->tag('p','Collections'). "<ul class='categories'>$collection_list</ul>".
                    $this->Html->tag('p',date('M j, Y', $dispatch['Content']['Image']['date'])).$e));
    
    echo $this->Html->div('dispatch', $m."\r".$a."\r".$in."\r".$i."\r".$p."\r");
    echo $this->Form->create('Content', array(
            'id'=>'fieldset'.$dispatch['Content']['id'],
            'action' => 'dispatch_edit/'.$this->params['pname'] . 
            (isset($this->params['named']['page']) ? '/page:' . $this->params['named']['page'] : 'page:/' . 1),
//            array('pass' => array($this->params['pname'])),
            'style' =>'display: none;'
            )
        );

    echo $this->element('contentForm_metaFields', array(
        'record' => $dispatch
    ));
    
    echo $this->element('contentForm_dataFields', array(
        'record' => $dispatch,
        'display'=>'show'
    ));
    
    echo $this->Form->end('Submit');
}
?>
