<!-- 
Loads everything necessary to have one year set of month calendars
The calendars have a red dot that can be dragged to a .widget element
which will then contain the calendar-->
<?php 
$this->start('scripts');
echo $this->Html->css('calendar');
echo $this->Html->script('Mediators/calendar_widget'); 
$this->end();
?>

<form id="calendar_widget">
	<div id="month_slider">
		<input id="slide" type="range" min="1" max="12" step="1" value="1" />
	</div>
	<div id="calendarspace">
		<!-- calendar renders here -->
	</div>

</form>