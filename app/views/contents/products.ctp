<?php
//debug($recentTitles);die;
//debug($most_recent);
echo $html->css('search_links');
//$this->result_imagePath = 'images/thumb/x75y56/';
//$this->result_imagePath = 'images/thumb/x160y120/';

// patterns in markdown: links, images, paragraphs
//$patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/');
//$replace = array('','',' ');
//debug($patterns);
echo $html->image('transparent.png', array('id'=>'noThumbTransparent'));
?>
<div id="intro">
    <h1>All hand bound.<br />All individually made.</h1>
    <p>There are no off-the-shelf products at Dreaming Mind, so the products listed in the menu are general categories of custom bindings I've completed over the years.</p>
    <p>Click on them for additional links to the Gallery of finished work or 'On The Bench' in-process pictures.</p>
</div>
<div class="Col2Left">
    <!--<div class="linkDiv">-->
        <h2 class="Col2">Recent On The Bench postings</h2>
    <!--</div>-->
    
<?php
foreach($recentTitles as $news){
    echo $html->foundNewBlock($news, $result_imagePath);
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
        $heading_link = $html->link($html->truncateText($update['Content']['heading'],45),$link_uri) 
                . markdown($html->truncateText($clean,100,array('force'=>true)));
        //assemble the image link
        $img = $html->image($result_imagePath.$update['Content']['Image']['img_file'], array(
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
//debug($most_recent);
?>
