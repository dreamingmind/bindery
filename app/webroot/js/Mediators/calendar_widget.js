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
				$(this).append($('#calendar_widget'));
				$('b#marker').css('top', 'auto').css('left', 'auto');
				cal.linkCalToField(event.target);
			}
		});
	},
	
	/**
	 * Configure and initialize the object on page load
	 * @param {object} config Override values for default properties
	 */
	init: function(config){
		if (typeof(config) !== 'undefined') {
			cal.configure(config);
		}
		cal.intializeCalendar();
		$('#calendar_widget input#slide').trigger('change');
		cal.scan('', document);

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
					$(cal.linkedDateField).data('original_date', new Date($(cal.linkedDateField).val()));
					$(cal.linkedDateField).val(date.toDateString()).trigger('change');
				}
		});
		$('b#marker').draggable().css('color', 'firebrick').css('cursor', 'pointer');
	},
	
	linkCalToField: function(container){
		if (container.tagName === 'SPAN') {
			$(container).children('button').trigger('click');
//			var new_row = bindery_page.fragment[$(bindery_page.last_node).attr('id')];
//			cal.linkedDateField = bindery_page.fragment[new_row.fullId.replace('row', 'DateDate')].node;
		} else if ($(container).parent()[0].tagName === 'TD'){
			cal.linkedDateField = $(container).parent().find('input[id*="DateDate"]');
		} else if (container.tagName === 'DIV') {
			cal.linkedDateField = $(container).find('input[id*="Day-"]');
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
	 *
	 * @param {event} e
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

		var todaydate=new Date(); //DD added
		var scanfortoday=(y===todaydate.getFullYear() && m===todaydate.getMonth()+1)? todaydate.getDate() : 0; //DD added

		dim[1]=(((oD.getFullYear()%100!==0)&&(oD.getFullYear()%4===0))||(oD.getFullYear()%400===0))?29:28;
		var t='<div class="'+cM+'"><table class="'+cM+'" cols="7" cellpadding="0" border="'+brdr+'" cellspacing="0"><tr align="center">';
		t+='<td id="location_marker" colspan="7" align="center" class="'+cH+'">'
				+mn[m-1]+' - '+y+'<b id="marker"> ◉</b></td></tr><tr align="center">';
		for(s=0;s<7;s++)t+='<td class="'+cDW+'">'+"SMTWTFS".substr(s,1)+'</td>';
		t+='</tr><tr align="center">';
		for(i=1;i<=42;i++){
			var x=((i-oD.od>=0)&&(i-oD.od<dim[m-1]))? i-oD.od+1 : '&nbsp;';
			if (x===scanfortoday) //DD added
			x='<span id="today">'+x+'</span>'; //DD added
			t+='<td class="'+cD+'">'+x+'</td>';
			if(((i)%7===0)&&(i<36))t+='</tr><tr align="center">';
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

/**
 * 
 * @param {Date} start
 * @param {Date} end
 * @returns {DateSpan}
 */
DateSpan = function(start, end) {
	this.start_date = start;
	this.end_date = end;
//	this.daysInSpan = function() {
//		if( this.end_date - this.start_date >= this.week) {
//			return this.days;
//		} else {
//			var min = this.start_date.getDay() < this.end_date.getDay() ? this.start_date.getDay() : this.end_date.getDay();
//			var max = this.start_date.getDay() < this.end_date.getDay() ? this.end_date.getDay() : this.start_date.getDay();
//			return this.days.slice(min, max);
//		}
//	};
};

//defineProperty(DateSpan.prototype, 'constructor', DateSpan);
//defineProperty(DateSpan.prototype, 'days', ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']);
//defineProperty(DateSpan.prototype, 'second', 1000);
//defineProperty(DateSpan.prototype, 'minute', 60 * this.second);
//defineProperty(DateSpan.prototype, 'hour', 60 * this.minute);
//defineProperty(DateSpan.prototype, 'day', 24 * this.hour);
//defineProperty(DateSpan.prototype, 'week', 7 * this.day);
DateSpan.prototype = {
	constructor: DateSpan,
	days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
	day_names: {sun: 0, mon: 1, tue: 2, wed: 3, thu: 4, fri: 5, sat: 6},
	second: 1000,
	get minute() {
			return 60 * this.second;
		},
	get hour() {
			return 60 * this.minute;
		},
	get day() {
			return 24 * this.hour;
		},
	get week() {
			return 7 * this.day;
		},
	get days_in_span() {
		if( this.end_date - this.start_date >= this.week) {
			return this.days.slice(this.start_date.getDay(), this.start_date.getDay() + 7);
		} else {
			var a = this.start_date.getDay();
			var b = this.end_date.getDay();
			if (a <= b ) {
				var min = a;
				var max = b+1;
			} else {
				min = a;
				max = 8 + b;
			}
			return this.days.slice(min, max);
		}
	},
	daysInSpan: function() {
		var day = undefined;
		var checks = '';
		for (day in this.days_in_span) {
			checks += '<input id="day'+this.days_in_span[day]+'" type="checkbox" value="'+day+'" name="data[day][]"><label for="day'+this.days_in_span[day]+'">'+this.days_in_span[day]+'</label>';
		}
		return checks;
	},
	/**
	 * Return an array of date objects for every occurance of a day in the range, inclusive
	 * 
	 * @param {int|string} day 0-6, '0'-'6' or 3 letter day name
	 * @returns {Array|Boolean}
	 */
	every: function (day) {
		// adjust the arguement, accepting the three different alternatives
		if (parseInt(day) >= 0 && parseInt(day) <= 6) {
			var target_day = parseInt(day);
		} else if (day.match(/mon|tue|wed|thu|fri|sat|sun/i)) {
			var target_day = this.day_names[day.toLowerCase()];
		} else {
			return false;
		}
		
		var days = [];
		var date = new Date(this.start_date.valueOf());
		
		// get to the proper day of the week
		while (date.getDay() !== target_day) {
			date = new Date(date.valueOf() + this.day);
		}
		
		// generate the day for each week in the range
		// adjsuting test for daylight savings time which could prevent inclusion of last day
		while (date.valueOf() <= this.end_date.valueOf() ||
				date.valueOf() <= this.end_date.valueOf() - this.hour) {
			
			days.push(date);
			date = new Date(date.valueOf() + this.week); 
		}
		return days;
	}
};

BasicDate = function(date) {
	return date;
};

BasicDate.prototype = {
	constructor: BasicDate,
	toString: function() {
//		switch (type) {
//			case 'ymd':
				return this.date.getFullYear() + '-' + this.date.getMonth() + '-' + this.date.getDate();
//				break;
//			default:
//				return this.date.toString();
//		}
	},
	change: function(delta) {
		this.date = this.date + delta;
		return this;
	}
};