<?php

/**
 * This element handles the creation of the feature element on upcoming and detail pages
 * 
 */
$featureHtml = '';
$detaillink = ($this->request->params['action']=='upcoming') ? $this->Html->link(' See Detail Article',array('action'=>'detail',$feature['Workshop']['slug'])) : '';
$workshopTitle = $this->Html->tag('h2', $feature['Workshop']['heading'].$detaillink, array('id' => 'featureHeading'));
$workshopPicture = $this->Html->image(
        "images/thumb/x160y120/{$feature['ContentCollection'][0]['Content']['Image']['img_file']}", array('id' => 'featurePicture'));
$workshopContent = TextHelper::truncate($this->Markdown->transform($feature['ContentCollection'][0]['Content']['content']), 550);
$sessioncount = count($feature['Session']);
//  sprintf slugging
$dateslug = '<p class="day"><time datetime="%s">%s</time><span class="%s">%s</span> - %s<span class="%s">%s</span>';
//    preset $starttimestamp & $endtimestamp for each loop
//    will use sprintf($dateslug,
//                      $starttimestamp,
//                      $date('M d Y, g:i',$starttimestamp),
//                      $date('a',$starttimestamp),
//                      $date('A',$starttimestamp),
//                      $date('g:i',$endtimestamp),
//                      $date('a',$endtimestamp),
//                      $date('A',$endtimestamp))
//  Variable setup
$sesnumber = 1;
$accum = $costaccum = array();
//  Button loop
foreach ($feature['Session'] as $wksession) {
    $s = ($sessioncount > 1) ? 'Session ' . $sesnumber . ' - ' : '';
    $cost = 'Register: '
            . $s
            . $this->Number->currency($wksession['cost'], 'USD', $options = array('before' => '$', 'places' => 0));
//    debug($cost);die;
    $accum[] = $this->Form->button($cost, array('class' => 'register'));
//      Date loop
    $durations[$sesnumber] = 0;
    foreach ($wksession['Date'] as $date) {
        $starttimestamp = strtotime($date['date'] . ' ' . $date['start_time']);
        $endtimestamp = strtotime($date['date'] . ' ' . $date['end_time']);
        $accum[] = sprintf($dateslug, $starttimestamp, date('M d Y, g:i', $starttimestamp), date('a', $starttimestamp), date('A', $starttimestamp), date('g:i', $endtimestamp), date('a', $endtimestamp), date('A', $endtimestamp));
        $durations[$sesnumber] += $endtimestamp - $starttimestamp;
    }
    $costaccum[] = 'Session ' . $sesnumber . ' is '
            . ($durations[$sesnumber++] / 3600) . ' hours, '
            . $this->Number->currency($wksession['cost'], 'USD', $options = array('before' => '$', 'places' => 0));
}
//    $accum = array(
//        '<button class="register">Register: Session 1 - $120</button>',
//        '<p class="day"><time datetime="2013-6-7 9:00:00">June 6 2013, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
//        '<p class="day"><time datetime="2013-6-8 9:00:00">June 6 2013, 9:00</time><span class="am">AM</span> - 2:00<span class="pm">PM</span>',
//        '<button class="register">Register: Session 2 - $120</button>',
//        '<p class="day"><time datetime="2013-9-20 7:00:00">September 20 2013, 7:00</time><span class="am">AM</span> - 3:00<span class="pm">PM</span>',
//    );
//Setup the feature inset to show existing sessions, if any, and allow users to request a new date
$sessions = '';
if (isset($feature['Session'][0])) {
    $sessions = implode('', $accum);
}
$sessions .= $this->element('workshop_date_request', array(
    'heading' => $feature['Workshop']['heading'],
    'id' => $feature['Workshop']['id']));

$sessionDiv = $this->Html->div('', $sessions, array('id' => 'featuredSession'));
$costLine = $this->Html->tag('h3', implode(' // ', $costaccum), array('class' => 'featureCost'));

$featureHtml = $workshopPicture . $workshopTitle . $workshopContent . $costLine . $sessionDiv;
echo $this->Html->div('', $this->Html->div('', $featureHtml, array(
            'id' => 'feature-overlay'
        )), array(
    'id' => 'feature-pic',
    'style' => "background: url('/bindery/img/images/thumb/x640y480/{$feature['ContentCollection'][0]['Content']['Image']['img_file']}') no-repeat scroll 0px 0px transparent;"
        )
);
?>
