<?php
echo $html->css('search_links');
//debug($collection);
//$path = 'images/thumb/x75y56/';
//$path = 'images/thumb/x160y120/';
//
//// patterns in markdown: links, images, paragraphs
//$patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/');
//$replace = array('','',' ');
//debug($patterns);
echo $html->image('transparent.png', array('id'=>'noThumbTransparent'));
?>
<div id="intro">
    <?php
    echo $html->tag('h1',$this->params['pname']);
    echo Markdown($collection['Collection']['text']);
    ?>
 </div>
<div class="Col2Left">
    <!--<div class="linkDiv">-->
        <h2 class="Col2">Recent On The Bench postings</h2>
    <!--</div>-->
    
<?php
foreach($recentNews as $news){
    echo $html->foundNewBlock($this->viewVars, $news);
}
?>
</div>
<div class="Col2Right">
    <!--<div class="linkDiv">-->
        <h2 class="Col2">Recently finished projects</h2>
    <!--</div>-->
    
<?php

$last_update = 0;
foreach($recentExhibit as $exhibit){
    echo $html->foundGalleryBlock($exhibit);
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
