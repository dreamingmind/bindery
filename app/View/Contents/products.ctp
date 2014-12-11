<?php
//debug($recentExhibits);
//debug($recentNews);die;

echo $this->Html->css('search_links');
//$this->result_imagePath = 'images/thumb/x75y56/';
//$this->result_imagePath = 'images/thumb/x160y120/';

// patterns in markdown: links, images, paragraphs
//$patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/');
//$replace = array('','',' ');
//debug($patterns);
echo $this->Html->image('transparent.png', array('id'=>'noThumbTransparent'));
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
foreach($recentNews as $news){
    echo $this->Html->foundNewBlock($this->viewVars, $news);
}
?>
</div>
<div class="Col2Right">
    <!--<div class="linkDiv">-->
        <h2 class="Col2">Recently finished projects</h2>
    <!--</div>-->
    
<?php

$last_update = 0;
foreach($recentExhibits as $exhibit){
    echo $this->Html->foundGalleryBlock($this->viewVars, $exhibit);
}
?>
</div>

<?php
//debug($most_recent);
?>
