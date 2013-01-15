<?php
//debug($recentTitles);die;
//debug($most_recent);
echo $html->css('search_links');
//$path = 'images/thumb/x75y56/';
$path = 'images/thumb/x160y120/';

$patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/');
$replace = array('','');
//debug($patterns);
echo $html->image('transparent.png', array('id'=>'noThumbTransparent'));
?>
<div id="intro">
    <h1>All hand bound.<br />All individually made.</h1>
    <p>There are no off-the-shelf products at Dreaming Mind, so the product listed in the menu are general categories of custom binding projects I've completed over the years.</p>
    <p>Click on them for additional links to the Gallery of finished work or 'On The Bench' in-process pictures.</p>
</div>
<div class="Col2Left">
    <!--<div class="linkDiv">-->
        <h2 class="Col2">Links to the 5 most recent On The Bench postings.</h2>
    <!--</div>-->
    
<?php
foreach($recentTitles as $li){
    //remove links and image links from markdown content
    $clean = preg_replace($patterns, $replace,$li['Content']['content']);
    //assemble the image link
    $img = $html->image($path.$li['Image']['img_file'], array(
        'id'=>'im'.$li['Image']['id'],
        'alt'=>$li['Image']['alt'],
        'title'=>$li['Image']['title']
    ));
    //make the heading into the <A> tag
    //and follow it with truncated markdown content
    $link = $html->link($li['Content']['heading'], array(
        'controller'=>'contents',
        'pname'=>$li['ContentCollection'][0]['Collection']['slug'],
        'action'=>'newsfeed',
        '/#id'.$li['Content']['id']),
        array('escape'=>false)
    ) . markdown(TextHelper::truncate($clean,100));
    
    //and output everything in a left-floating div
    echo $html->div('linkDiv', $img . $link);
}
?>
</div>
<div class="Col2Right">
    <!--<div class="linkDiv">-->
        <h2 class="Col2">Links to the 3 most recent pictures of finished projects.</h2>
    <!--</div>-->
    
<?php

$last_update = 0;
foreach($most_recent as $update){
    if ($update['ContentCollection']['content_id']!=$last_update){
        //remove links and image links from markdown content
        $clean = preg_replace($patterns, $replace,$update['Content']['content']);
        $collection = $html->para('',$update['Collection']['heading']);
        //make the heading into the <A> tag
        //and follow it with truncated markdown content
        $link = $html->link($update['Content']['heading'],
            DS.'products'.DS.$update['Collection']['slug'].DS.'gallery'.DS.'id:'.$update['Content']['id']
            ) . markdown(TextHelper::truncate($clean,100));
        //assemble the image link
        $img = $html->image($path.$update['Content']['Image']['img_file'], array(
//            'id'=>'im'.$update['Content']['Image']['id'],
            'alt'=>$update['Content']['Image']['alt'],
            'title'=>$update['Content']['Image']['title']
        ));

    echo $html->div('linkDiv', $img . $collection . $link);
//echo $this->Html->image(
//        'images'.DS.'thumb'.DS.'x500y375'.DS.$update['Content']['Image']['img_file'],
//        array('alt'=>$update['Content']['Image']['alt'].' '.$update['Content']['Image']['alt']))."\n";
//        $last_update = $update['ContentCollection']['content_id'];
    }
}
?>
</div>
<?php
//debug($most_recent);
?>
