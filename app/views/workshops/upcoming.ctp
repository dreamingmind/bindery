<?php 
/**
 * Temporary randomizer to get shifting data in the Feature slot
 */
    $pool = array_merge($upcoming,$potential);
    $count = count($pool);
    $feature = $pool[rand(0, $count-1)];
//    debug ($feature);
// End of temporary randomizer
//==================================

    $featureHtml = '';
    $workshopTitle = $this->Html->tag('h2',$feature['Workshop']['heading'],array('id'=>'featureHeading'));
    $workshopPicture = $this->Html->image(
            "images/thumb/x160y120/{$feature['ContentCollection'][0]['Content']['Image']['img_file']}",
            array('id'=>'featurePicture'));
    $featureHtml = $workshopPicture . $workshopTitle;
    
    echo $this->Html->css('search_links');
    echo $this->Html->div('',
        $this->Html->div('',$featureHtml,array(
            'id'=>'feature-overlay'
        )), 
        array(
            'id'=>'feature-pic',
            'style'=>"background: url('/bindery/img/images/thumb/x640y480/{$feature['ContentCollection'][0]['Content']['Image']['img_file']}') no-repeat scroll 0px 0px transparent;"
        )
     );
?>

    <?php
echo '<div class="Col2Left">';
echo $this->Html->tag('h1','Upcoming workshops');
foreach ($upcoming as $workshop) {
//debug ($workshop);
      echo $html->foundWorkshopBlock($workshop);
}
echo '</div>';

echo '<div class="Col2Right">';
echo $this->Html->tag('h1','Potential workshops');
foreach ($potential as $workshop) {
      echo $html->foundWorkshopBlock($workshop);
}
echo '</div>';

//echo $this->Html->tag('h1','Current workshops');
//echo '<ul>';
//foreach ($now as $workshop) {
//      echo $html->foundWorkshopBlock($workshop);
//}
//echo '</ul>';
?>