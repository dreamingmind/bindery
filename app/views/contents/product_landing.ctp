<?php
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
    <?php echo $html->tag('h1',$this->params['pname']); ?>
    <p>There are no off-the-shelf products at Dreaming Mind, so the products listed in the menu are general categories of custom bindings I've completed over the years.</p>
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
<?php
//debug($this);
    debug($html->para('',count($sale_items). ' item prices found.'));
?>
<?php
function truncateText($text, $length, $force = false, $force_length = 10){
    //if text is shorter than lengh and $force is true, $force_length chars will drop anyway
    if($force){
        $count= strlen($text);
        $length = ($count<$length)?$count-10:$length;
    }
    return TextHelper::truncate($text,$length);
}
//debug($most_recent);
?>
