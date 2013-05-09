<?php
echo $html->css('search_links');
//debug($collection);
//debug($artedition);
//$path = 'images/thumb/x75y56/';
//$path = 'images/thumb/x160y120/';
//
//// patterns in markdown: links, images, paragraphs
//$patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/');
//$replace = array('','',' ');
//debug($patterns);
//$details = array();
//echo $html->image('transparent.png', array('id'=>'noThumbTransparent'));
?>
<div id="intro">
    <?php
    echo $html->tag('h1',$collection['Collection']['heading'], array(
        'class' => 'related',
        'collection' => $collection['Collection']['id']
    ));
    echo Markdown($collection['Collection']['text']);
    ?>
 </div>
<?php
if(!empty($record)){
   echo $this->element('artExhibit');
} else {
    foreach($list as $result){
        echo $html->foundArtBlock($this->viewVars, $result);
    }
//    debug($list);
}

?>
