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
foreach($most_recent as $exhibit){
    echo $html->foundGalleryBlock($exhibit, $result_imagePath);
}
?>
</div>

<?php
//debug($most_recent);
?>
