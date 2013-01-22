<?php
//debug($recentTitles);die;
//debug($most_recent);
echo $html->css('search_links');
//$path = 'images/thumb/x75y56/';
$path = 'images/thumb/x160y120/';

// patterns in markdown: links, images, paragraphs
$patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/');
$replace = array('','',' ');
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
        <h2 class="Col2">Recent On The Bench postings</h2>
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
    $link_uri = array(
        'controller'=>'contents',
        'pname'=>$li['ContentCollection'][0]['Collection']['slug'],
        'action'=>'newsfeed',
        '/#id'.$li['Content']['id']
        );
//    debug($li);
        $blog_link=$html->link('Blog Article','/blog/'.$li['ContentCollection'][0]['collection_id'].'/'.$li['Content']['slug']);    //make the heading into the <A> tag
    //and follow it with truncated markdown content
    $heading_link = $html->link(truncateText($li['Content']['heading'],45), $link_uri,array('escape'=>false)) 
            . markdown(truncateText($clean,100,true))
            . $html->para('aside',"Or view as a $blog_link");
;
    
    $image_link = $html->link($img, $link_uri,array('escape'=>false));
    
    //and output everything in a left-floating div
    echo $html->div('linkDiv', $image_link . $html->para('aside','On the bench: date goes here') . $heading_link);
}
?>
</div>
<div class="Col2Right">
    <!--<div class="linkDiv">-->
        <h2 class="Col2">Recently finished projects</h2>
    <!--</div>-->
    
<?php

$last_update = 0;
foreach($most_recent as $update){
    if ($update['ContentCollection']['content_id']!=$last_update){
        //remove links and image links from markdown content
        $clean = preg_replace($patterns, $replace,$update['Content']['content']);
        $collection = $html->para('aside',$update['Collection']['heading']);
        //make the heading into the <A> tag
        //and follow it with truncated markdown content
        $link_uri = DS.'products'.DS.$update['Collection']['slug'].DS.'gallery'.DS.'id:'.$update['Content']['id'];
        $heading_link = $html->link(truncateText($update['Content']['heading'],45),$link_uri) 
                . markdown(truncateText($clean,100,true));
        //assemble the image link
        $img = $html->image($path.$update['Content']['Image']['img_file'], array(
//            'id'=>'im'.$update['Content']['Image']['id'],
            'alt'=>$update['Content']['Image']['alt'],
            'title'=>$update['Content']['Image']['title']
        ));
        $image_link = $html->link($img,$link_uri,array('escape'=>false));

    echo $html->div('linkDiv', $image_link . $collection . $heading_link);
//echo $this->Html->image(
//        'images'.DS.'thumb'.DS.'x500y375'.DS.$update['Content']['Image']['img_file'],
//        array('alt'=>$update['Content']['Image']['alt'].' '.$update['Content']['Image']['alt']))."\n";
//        $last_update = $update['ContentCollection']['content_id'];
    }
    
}
?>
</div>

<?php
function truncateText($text, $length, $force = false, $force_length = 10){
    //if text is shorter than lengh and $force is true, $force_length chars will drop anyway
    if($force){
        $count=array_sum(count_chars($text,1));
        $length = ($count<$length)?$count-10:$length;
    }
    return TextHelper::truncate($text,$length);
}
//debug($most_recent);
?>
