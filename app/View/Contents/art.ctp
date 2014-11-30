<?php
echo $this->Html->css('search_links');
echo $this->Html->css('art_purchase');
echo $this->Html->script('art_purchase');
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
//echo $this->Html->image('transparent.png', array('id'=>'noThumbTransparent'));
?>
<div id="collectionIntro">
    <?php
    $showToggle = $this->Html->tag('span','',array('class'=>'show'));
    echo $this->Html->tag('h1',$collection['Collection']['heading'] . $showToggle, array(
        'class' => 'related',
        'collection' => $collection['Collection']['id']
    ));
    echo $this->Markdown->transform($collection['Collection']['text']);
    ?>
 </div>
<?php
if(!empty($record)){
   // found exhibits so show the beauty shot and filmstrip (also detail links)
   echo $this->element('artExhibit');
} else {
    // no exhibits. A landing page. Show some downstream sample links
    // and blog-reprints on this pname if they exist
    foreach($deepLinks as $link){
        echo $this->Html->foundArtBlock($this->viewVars, $link);
    }
    if(!empty($searchResults)){
        $message = (count($searchResults) > 1) 
            ? 'Here are ' . count($searchResults) . ' reprints of related blog articles.'
            : 'Here is a reprint of a related blog article.';
        echo $this->Html->tag('h4',$message);
        foreach($searchResults as $link){
            echo $this->Html->foundNewBlock($this->viewVars, $link, 'images/thumb/x75y56/');
        }
    }
//    debug($list);
}

?>
