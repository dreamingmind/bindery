<!-- Elements/WorkshopSessions/single_session.ctp -->
<?php 
// expects WorkshopSession data:
//	[workshopsession_field] ...
//	[Date]
//		[n]
//			[date_field] ...
//		[n]
//			[date_field] ...


//	$s = ($sessioncount > 1) ? 'Session ' . $sesnumber . ' - ' : '';
//    $cost = 'Register: '
//            . $s
//            . $this->Number->currency($wksession['cost'], 'USD', $options = array('before' => '$', 'places' => 0));
////    debug($cost);die;
//    $accum[] = $this->Form->button($cost, array('class' => 'register'));
//	
////      Date loop
//	$dateslug = '<p class="day"><time datetime="%s">%s</time><span class="%s">%s</span> - %s<span class="%s">%s</span>';
//    $durations[$sesnumber] = 0;
//    foreach ($wksession['Date'] as $date) {
//        $starttimestamp = strtotime($date['date'] . ' ' . $date['start_time']);
//        $endtimestamp = strtotime($date['date'] . ' ' . $date['end_time']);
//        $accum[] = sprintf($dateslug, 
//				$starttimestamp, 
//				date('M d Y, g:i', $starttimestamp), date('a', $starttimestamp), 
//				date('A', $starttimestamp), date('g:i', $endtimestamp), 
//				date('a', $endtimestamp), date('A', $endtimestamp));
//        $durations[$sesnumber] += $endtimestamp - $starttimestamp;
//    }
//    $costaccum[] = 'Session ' . $sesnumber . ' is '
//            . ($durations[$sesnumber++] / 3600) . ' hours, '
//            . $this->Number->currency($wksession['cost'], 'USD', $options = array('before' => '$', 'places' => 0));
?>
<!-- END Elements/WorkshopSessions/single_session.ctp END -->