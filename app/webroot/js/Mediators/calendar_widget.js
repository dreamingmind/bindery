/**
 * Place calendar.ctp on a page and this will operate
 */

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
	linkedDateField: false,
	
	/*
	 * This is the mediate event-hanler on the document
	 * 
	 * initialize elements found in the html fragment
	 */
	scan: function(e, fragment){
		$(fragment).find('.cal-widget').parent().droppable({
			greedy: true,
			accept: '#marker',
			drop: function(event, ui){
				alert('cal drop');
				$(this).append($('#calendar_widget'));
				$('b#marker').css('top', 'auto').css('left', 'auto');
				cal.linkedDateField($(this).children('.cal-widget'));
			}
		})
	},
	
	/**
	 * Configure and initialize the object on page load
	 */
	init: function(config){
		if (typeof(config) != 'undefined') {
			cal.configure(config);
		}
		cal.intializeCalendar();
		$('#calendar_widget input#slide').trigger('change');
		cal.scan('', document)

		$(document).on('mediate', cal.scan);
//		cal.renderCalendar(cal.cur_month, cal.cur_year);
	},
	
	renderCalendar: function(show_month, show_year) {
		var calendarstr = cal.buildCal(show_month, show_year, "main", "month", "daysofweek", "days", 0);
		$("#calendar_widget #calendarspace").html(calendarstr);
		$("#calendar_widget #calendarspace td.days")
			.css('cursor', 'pointer')
			.on('click', function(){
				var date = new Date(cal.months[cal.user_month]+' '+$(this).html().match(/\d+/)+', '+cal.user_year);
				if (cal.linkedDateField){
					$(cal.linkedDateField).val(date.toDateString());
				}
		});
		$('b#marker').draggable().css('color', 'firebrick').css('cursor', 'pointer');
	},
	
		linkCalToField: function(container){
		if (container.tagName == 'TD'){
			cal.linkedDateField = $(container).parent().find('input[id*="DateDate"]');
		} else if (container.tagName == 'DIV') {
			cal.linkedDateField = $(container).find('input[id$="Day"]');
		}
		
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
			.on('change', cal.changeMonth)
			.on('mousemove', cal.changeMonth);
	},
	
	/**
	 * Handle a new calendar slider position
	 */
	changeMonth: function(e) {
		var wrap = ($(e.currentTarget).val()-12)>0 ? 1 : 0;
		cal.user_month = $(e.currentTarget).val() - (12*wrap);
		cal.user_year = cal.cur_year + wrap;
		cal.renderCalendar(cal.user_month, cal.user_year);
	},
	
	buildCal: function(m, y, cM, cH, cDW, cD, brdr){
		var mn=['January','February','March','April','May','June','July','August','September','October','November','December'];
		var dim=[31,0,31,30,31,30,31,31,30,31,30,31];

		var oD = new Date(y, m-1, 1); //DD replaced line to fix date bug when current day is 31st
		oD.od=oD.getDay()+1; //DD replaced line to fix date bug when current day is 31st

		var todaydate=new Date() //DD added
		var scanfortoday=(y==todaydate.getFullYear() && m==todaydate.getMonth()+1)? todaydate.getDate() : 0 //DD added

		dim[1]=(((oD.getFullYear()%100!=0)&&(oD.getFullYear()%4==0))||(oD.getFullYear()%400==0))?29:28;
		var t='<div class="'+cM+'"><table class="'+cM+'" cols="7" cellpadding="0" border="'+brdr+'" cellspacing="0"><tr align="center">';
		t+='<td id="location_marker" colspan="7" align="center" class="'+cH+'">'
				+mn[m-1]+' - '+y+'<b id="marker"> ◉</b></td></tr><tr align="center">';
		for(s=0;s<7;s++)t+='<td class="'+cDW+'">'+"SMTWTFS".substr(s,1)+'</td>';
		t+='</tr><tr align="center">';
		for(i=1;i<=42;i++){
			var x=((i-oD.od>=0)&&(i-oD.od<dim[m-1]))? i-oD.od+1 : '&nbsp;';
			if (x==scanfortoday) //DD added
			x='<span id="today">'+x+'</span>' //DD added
			t+='<td class="'+cD+'">'+x+'</td>';
			if(((i)%7==0)&&(i<36))t+='</tr><tr align="center">';
		}
		return t+='</tr></table></div>';
	},
	
	/**
	 * Overwrite the default properties with new values
	 * 
	 * @param {json object} config the values to substitute for the defaults
	 */
	configure: function(config) {
		for (var p in config) {
			DateRange[p] = config[p];
		}
	}

};