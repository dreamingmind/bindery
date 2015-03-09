/*
The goal here is to make a constructor that takes two slider inputs 
of type Field as arguements and hooks them up to follow these rules.

<< LIST BEHAVIOR RULES HERE >>

This assumes the other 3 nodes required for the behavior could be deduced. 
They are the two time text inputs and the node that displays duration.

An optional 3rd argument could contain all the configuration values to 
override the defaul property values. The sliders must be of type Field.




 */
$(document).ready(function(){
	DateRange.init({
		time_min: new Date('2015','2','25','10','00','0'),
		time_max: new Date('2015','2','25','20','00','0'),
		minute_increment: 15
	});
});

/**
 * Makes two time inputs that collaborate as start-stop times
 * 
 * You can configure 
 *		time_min (earliest start time, default 7am)
 *		time_max (latest end time, default 11pm)
 *		time_increment (the slider jump points, default 30 minutes)
 *	As start time moves it constrains the range for end time. 
 *	Moving either also reports the duration
 * 
 */
var DateRange = {
	// ==============================================
	// CONFIGURABLE VALUES
	
	//year, month, day, hours, minutes, seconds, milliseconds
	time_min: new Date('2015','2','25','7','00','0'),
	time_max: new Date('2015','2','25','23','00','0'),
	minute_increment: 30, // in minutes
	
	// these 5 configurable IDs end up with '-xxxxxxxx' appended to make them unique for the record
	end_slider_id_prefix:		"date_end_slide",
	start_slider_id_prefix:		"date_start_slide",
	end_text_id_prefix:			'DateEndTime',
	start_text_id_prefix:		'DateStartTime',
	duration_display_id_prefix: 'date_duration', 
	
	// END OF CONFIGURABLE VALUES
	// ==============================================
	
	// these are the selectors to find all the inputs in the Dom
	// they are assembled by the system from the configured prefix values
	end_slider_selector: false,
	start_slider_selector: false,
	
	// these are the selectors that get id appended to find specific inputs
	// they are assembled by the system from the configured prefix values
	end_slider_input: false,
	start_slider_input: false,
	end_text_input: false,
	start_text_input: false,
	duration_display: false,

	milisecon_increment: false,
	// times from min to max by increment
	time: [],
	
	/*
	 * This is the mediate event-hanler on the document
	 * 
	 * initialize elements found in the html fragment
	 */
	scan: function(e, fragment){
		DateRange.initEndSlide($(fragment).find(DateRange.end_slider_selector));
		DateRange.intiStartSlide($(fragment).find(DateRange.start_slider_selector));	
	},
	
	/**
	 * Configure and initialize the object on page load
	 */
	init: function(config){
		if (typeof(config) != 'undefined') {
			DateRange.configure(config);
		}
		DateRange.assembleSelectors();
		DateRange.millisecond_increment = parseInt(DateRange.minute_increment) * 60 * 1000
		DateRange.fill_time();
		DateRange.scan('', document);
		$(document).on('mediate', DateRange.scan);
	},
	
	/**
	 * Set the initial max end val and bind the slider behavior
	 * 
	 * @param object slides jQuery collection of found elements
	 */
	initEndSlide: function(slides) {
		slides.each(function(){
			$(this).attr('max', DateRange.time.length-1)
				.mousemove(function(e){
					var u_id = $(e.currentTarget).attr('id').match(/\d+/);
					var end = $(e.currentTarget).val();
					$(DateRange.end_text_input+u_id).val(DateRange.time[end]);

					DateRange.duration(u_id);
				});
		})
	},
	
	/**
	 * Set the initial max start val and bind the slider behavior
	 * 
	 * @param object slides jQuery collection of found elements
	 */
	intiStartSlide: function(slides) {
		slides.each(function(){
			$(this).attr('max', DateRange.time.length - 5)
				.mousemove(function(e){
					var u_id = $(e.currentTarget).attr('id').match(/\d+/);
					var start = $(e.currentTarget).val();

					$(DateRange.start_text_input+u_id).val(DateRange.time[start]);
					$(DateRange.end_slider_input+u_id)
						.attr('min', parseInt(start) + 3)
						.trigger('mousemove');

					DateRange.duration(u_id);
				});
		})
	},
	
	/**
	 * Calculate and display the current duration between start and end in decimal hours
	 */
	duration: function(u_id){
		var denominator = 60 / parseInt(DateRange.minute_increment);
		var end = parseInt($(DateRange.end_slider_input+u_id).val());
		var start = parseInt($(DateRange.start_slider_input+u_id).val());
		var duration = parseInt(((end - start) / denominator)*100)/100;
		$(DateRange.duration_display+u_id).html(duration.toString() + ' hour session');
	},
	
	/**
	 * Fill time array with all values from min to max by increment
	 */
	fill_time: function (){
		var start = DateRange.time_min.getTime();
		var end = DateRange.time_max.getTime();
		for (var i = start; i <= end; i+=DateRange.millisecond_increment) {
			DateRange.time.push(DateRange.hm(new Date(i)));
		}
	},
	
	/**
	 * Make a formatted time 3:00 PM
	 * 
	 * @return {string} the formatted time string
	 */
	hm: function(time){
		var min = time.getMinutes().toString().length == 1 ? ':0' : ':';
		var meridian = time.getHours() > 11 ? 1 : 0;
		var noon = time.getHours() > 12 ? 1 : 0;
		return (time.getHours() - (noon * 12)) + min + time.getMinutes() + (meridian ? ' PM' : ' AM');
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
	},
	
	/**
	 * From the prefix values, make all the prefix values for the system
	 */
	assembleSelectors: function() {
		DateRange.end_slider_selector = 'input[id*="'+DateRange.end_slider_id_prefix+'"]',
		DateRange.start_slider_selector = 'input[id*="'+DateRange.start_slider_id_prefix+'"]',
		
		DateRange.end_slider_input = '#'+DateRange.end_slider_id_prefix+'-',
		DateRange.start_slider_input = '#'+DateRange.start_slider_id_prefix+'-',
		DateRange.end_text_input = '#'+DateRange.end_text_id_prefix+'-',
		DateRange.start_text_input = '#'+DateRange.start_text_id_prefix+'-',
		DateRange.duration_display = '#'+DateRange.duration_display_id_prefix+'-'
	}
}