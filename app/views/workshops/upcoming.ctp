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
    $workshopContent = TextHelper::truncate(Markdown($feature['ContentCollection'][0]['Content']['content']),550);
//    $workshopContent = $this->Html->para(
//            '',
//            $feature['ContentCollection'][0]['Content']['content'],
//            array('id'=>'featureContent'));
    $accum = array(
//        '<p class="day price">$120 <button class="register">Register: Session 1</button></p>',
        '<button class="register">Register: Session 1</button>',
//        '<p class="session">June 2013 - Session 1 - $120</p>',
        '<p class="day"><time datetime="2013-6-7 9:00:00">June 6 2013, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
        '<p class="day"><time datetime="2013-6-8 9:00:00">June 6 2013, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
        '<button class="register">Register: Session 2 - $120</button>',
//        '<p class="session">September 2013 - Session 2</p>',
        '<p class="day"><time datetime="2013-9-20 7:00:00">September 20 2013, 7:00</time><span class="am">AM</span> - 3:00<span class="pm">PM</span>',
//        '<p class="session">June 2013 - Session 1</p>',
//        '<p class="day"><time datetime="2013-6-7 9:00:00">June 6, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
//        '<p class="day"><time datetime="2013-6-8 9:00:00">June 6, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
//        '<button class="register">Register: Session 1</button>',
//        '<p class="session">September 2013 - Session 2</p>',
//        '<p class="day"><time datetime="2013-9-20 7:00:00">September 20, 7:00</time><span class="am">AM</span> - 3:00<span class="pm">PM</span>',
//        '<button class="register">Register: Session 2</button>'
    );
    $sessions = implode('', $accum);
    $sessionDiv = $this->Html->div('',$sessions,array('id'=>'featuredSession'));
//    $costLine = $this->Html->div('fdBackground',$this->Html->div('featureCost',$this->Html->tag('h3','Session 1 is 8 hours, $120 // Session 2 is 7 hours, $120')
////                . $this->Html->tag('h3','Session 1: 8 hours, $120')
//            ),
//            array(
////                'style'=>"background: url('/bindery/img/images/thumb/x640y480/{$feature['ContentCollection'][0]['Content']['Image']['img_file']}') no-repeat scroll 0px 0px transparent;"
//            )
//);
    $costLine = $this->Html->tag('h3','Session 1 is 8 hours, $120 // Session 2 is 7 hours, $120',array('class'=>'featureCost'));
    
    $featureHtml = $workshopPicture . $workshopTitle . $workshopContent . $costLine . $sessionDiv;
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
//    debug ($upcoming);

?>