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
foreach ($expired_sessions as $expired) {
//	foreach ($expired['WorkshopSession'] as $session) {
//		dmDebug::ddd($session, 'session');
		echo "<h2>{$expired['WorkshopSession']['title']}</h2>";
		echo "<p>{$expired['WorkshopSession']['first_day']}</p>";
		echo "<p>{$expired['WorkshopSession']['last_day']}</p>";
		foreach ($expired['Date'] as $date) {
			echo "<p>{$date['date']}</p>";
			echo "<p>{$date['start_time']}</p>";
			echo "<p>{$date['end_time']}</p>";
		}
//	}
}
dmDebug::ddd($expired_sessions, 'expired sessions');
dmDebug::ddd($feature, 'feature');