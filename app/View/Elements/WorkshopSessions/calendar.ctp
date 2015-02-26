<?php echo $this->Html->script('basiccalendar')?>
<?php echo $this->Html->css('calendar')?>

<form id="calendar_widget">
	<div id="month_slider">
		<input id="slide" type="range" min="1" max="12" step="1" value="1" />
	</div>
	<div id="calendarspace">
		<script>
		document.write(buildCal(curmonth, curyear, "main", "month", "daysofweek", "days", 0))
		</script>
	</div>

</form>