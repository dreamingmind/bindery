$(document).ready(function(){
	cal.init();
});

// cal widget
var cal = {
	months: ['December','January','February','March','April','May','June',
			'July','August','September','October','November','December'],
			
	days: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
	context: $('#calendar_widget'),
	today_date: new Date(),
	// today's month and year
	cur_month: false,
	cur_year: false,
	// month and year indicated by the slider
	user_month: false,
	user_year: false,
	
	init: function() {
		cal.intializeCalendar();
		$('#calendar_widget input#slide').trigger('change');
//		cal.renderCalendar(cal.cur_month, cal.cur_year);
	},
	
	/**
	 * Establish calendar state on page load
	 * 
	 * Range will be one year starting from this month
	 */
	intializeCalendar: function() {
		cal.cur_month = cal.user_month = cal.today_date.getMonth()+1;
		cal.cur_year = cal.user_year = cal.today_date.getFullYear();
		var slider = $('#calendar_widget input#slide');
		$(slider)
			.attr('min', cal.cur_month)
			.attr('value', cal.cur_month)
			.attr('max', cal.cur_month+11)
			.on('change', cal.changeMonth);
	},
	
	renderCalendar: function(show_month, show_year) {
		var calendarstr = buildCal(show_month, show_year, "main", "month", "daysofweek", "days", 0);
		$("#calendar_widget #calendarspace").html(calendarstr);
		$("#calendar_widget #calendarspace td.days")
			.css('cursor', 'pointer')
			.on('click', function(){
				var date = new Date(cal.months[cal.user_month]+' '+$(this).html().match(/\d+/)+', '+cal.user_year);
				alert(date.toDateString());
		});
		$('b#marker').draggable().css('color', 'firebrick').css('cursor', 'pointer');
		$('.widget').droppable({
			drop: function(event, ui){
				$(this).append($('#calendar_widget'));
				$('b#marker').css('top', 'auto').css('left', 'auto');
			}
		});
	},
	
	/**
	 * Handle a new calendar slider position
	 */
	changeMonth: function(e) {
		var wrap = ($(e.currentTarget).val()-12)>0 ? 1 : 0;
		cal.user_month = $(e.currentTarget).val() - (12*wrap);
		cal.user_year = cal.cur_year + wrap;
		cal.renderCalendar(cal.user_month, cal.user_year);
	}
};