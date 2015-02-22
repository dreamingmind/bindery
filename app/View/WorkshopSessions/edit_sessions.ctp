<?php
foreach ($feature['WorkshopSession'] as $session) {
	echo "<h2>{$session['title']}</h2>";
	echo "<p>{$session['first_day']}</p>";
	echo "<p>{$session['last_day']}</p>";
	foreach ($session['Date'] as $date) {
		echo "<p>{$date['date']}</p>";
		echo "<p>{$date['start_time']}</p>";
		echo "<p>{$date['end_time']}</p>";
	}
}
//dmDebug::ddd($expired_sessions, 'expired sessions');
//dmDebug::ddd($feature, 'feature');
foreach ($sessions as $session) {
//	$date = $session->read('{n}');
	echo NEWLINE.TAB.$this->Html->para('', $session->read('title')).NEWLINE; 
?>
	
	<ul>
<?php
	foreach ($session->read('{n}') as $day) {
		echo TAB.TAB.$this->Html->tag('li', $day->read('start_time') . '–' . $day->read('end_time')).NEWLINE;
	}
?>
	</ul>
<?php
}
?>
<?php
