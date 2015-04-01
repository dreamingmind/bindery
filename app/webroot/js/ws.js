$(document).ready(function(){
	init();	
});

var bindery_page = new PageManager();

/**
 * Make the data and control structure objects. Set behavior bindings
 */
function init () {
	// the page starts with a WorkshopSession record in a fieldset
	manageWorkshopSessionRecord();
	// the page has a table that can contain record rows
	manageSessionDateRecords();
	// the page displays existing sessions that can be used as templates for new sessions 
	manageSessionTemplates();
	// make behavior that triggers session creation from a template
	bindInitiateTemplateUseBehavior();
	// make a start-date change drag all other dates along
	bindStartDateChangeBehavior();
	// make an end-date changes ripple down through the date records
	bindEndDateChangeBehavior();
	/* END OF SESSION LISTING DRAG/DROP INITIALIZATION */
}

/**
 * Make the structural and data reference objects for the WorkshopSession record
 * 
 * In the PageManager object, the fieldset and control elements becomes 
 * ManagedNode objects and the fields all be come Field objects
 */
function manageWorkshopSessionRecord(){
	$('fieldset').each(function () {
		bindery_page.add(this);
	});
	newDayCheckSet(
		new Date($('input[id*="FirstDay-"]').val()), 
		new Date($('input[id*="LastDay-"]').val())
	);
}

/**
 * Make structural and data reference objects for the table the houses Date records
 */
function manageSessionDateRecords() {
	bindery_page.add($('table.session_dates'));
}

/**
 * Make existing sessions display elements into template control structures
 * 
 * The page displays past sessions (each having support data built by session_data_provider.js).
 * A ManagedNode object is made to wrap each one (for normalized access) and attached 
 * to the marker which will be the draggable element that invokes use of the template.
 */
function manageSessionTemplates() {
	$('li[id*="session_id-"]').each(function () {
		var u = $(this).attr('id').replace("session_id-", '');
		var li = new ManagedNode($(this));
		li.uuid = u; // use the record id rather than a uuid since record id points to the support data
		$(this).find('b').data(li);
	});
}	

/**
 * Make old session listings draggable data providers to session fieldset
 */
function bindInitiateTemplateUseBehavior() {
	$('li[id*="session_id-"] > b').draggable().css('color', 'firebrick').css('background-color', 'gray').css('cursor', 'pointer');
	$('fieldset[id*="workshop-"]').droppable({
		drop: function (event, ui) {
			alert('data drop');
			newSessionFromTemplate(event, ui);
		}
	}).css('background-color', 'yellow');
}

/**
 * Establish start date behaviors
 * 
 * Focus:
 * memorizes the current value
 * 
 * Change:
 * Calc the difference beween original and new date (delta)
 * Keep last_day the same interval from first_day (+delta)
 * Ripple the date change down through all the date records (each +delta)
 * 
 * @todo Possible decomposition of tasks makeDelta and setLastDate
 */
function bindStartDateChangeBehavior() {
	
	$('input[id*="FirstDay-"]')
		.on('focus', function(e) {
			$(e.currentTarget).data('original_date', new Date($(e.currentTarget).val()));
		})
		.on('change', function(e) {
			var current = bindery_page.fragment[$(e.currentTarget).attr('id')];
			current.date = new Date($(e.currentTarget).val());
			var original = {'date': $(e.currentTarget).data('original_date')};
			var delta = current.date - original.date;
			// this assumes one WorkshopSession record, one set of Date records linked to it, 
			// and no field-name overlaps with other tables
			var change_fields = ['last_day', 'date'];
			
			var last_day = bindery_page.record[current.uuid].last_day;
			last_day.date = new Date((+(new Date(last_day.value))) + delta);
			last_day.value = last_day.date.toDateString();
			
			$('input[id*="LastDay-"]').trigger('change');
		});
}

/**
 * Establish end date behaviors
 * 
 * Change:
 * Establish a new checkbox set for the range and let dates regenerate
 */
function bindEndDateChangeBehavior() {
	memorizeSessionDateTimePattern();
	$('input[id*="LastDay-"]')
		.on('change', function(e) {
			memorizeSessionDateTimePattern();
			newDayCheckSet(
				new Date($('input[id*="FirstDay-"]').val()), 
				new Date($('input[id*="LastDay-"]').val())
			);
			setCheckboxesFromMemorizedPattern();
			createDatesThroughCheckboxTriggers();
		});
}

/**
 * Make all Session date records based on the know pattern
 */
function createDatesThroughCheckboxTriggers() {
var checks = $('div.day_pattern > input');
	checks.each(function() {
		$(this).trigger('change');
	});
}

/**
 * Memorize the day checkboxes and time patterns for the days
 */
function memorizeSessionDateTimePattern() {
	memorizeCheckboxPattern(); // this is the pattern of days of the week for the workshop
	memorizeTimePattern(); // this is the time span for the first occurance of each day of the week
}

//function constructSessionDatesFromMemorizedPattern() {
//	setCheckboxesFromMemorizedPattern();
//	createDatesWithTimeSpansFromMemorizedPattern()
//}

/**
 * Memorize the checked days and thier time span
 * 
 * Time span will be—for that day—the first date record's times
 * Old memorized data will persist unless overwritten
 */
function memorizeCheckboxPattern() {
	if (bindery_page.day_checkbox_data === undefined) {
		bindery_page.day_checkbox_data = {
			daySun: {}, dayMon: {}, dayTue: {}, dayWed: {},
			dayThu: {}, dayFri: {}, daySat: {},
		};
	}
	var checks = $('div.day_pattern > input');
	checks.each(function() {
		bindery_page.day_checkbox_data[$(this).attr('id')].check_state = $(this).prop('checked');
	});
	
	// now memorize the time patterns for any existing date records
	
}

/**
 * Memorize the start/end times for the first date record for each day of the week
 * 
 * Store these values with other day checkbox data so later we can auto 
 * create date records to fill a span of day and each day of the week will have 
 * the time span matching this memorized span for that day
 */
function memorizeTimePattern() {
	var set = $('tbody > tr[id*="row-"]');
	var i;
	var field_selector_baseline;
	var day;
	var day_property;
	for (var i = set.length - 1; i >= 0; i-- ) {
		field_selector_baseline = $(set[i]).attr('id');
		day = new Date($(field_selector_baseline.replace('row', '#DateDate')).val());
		day_property = 'day'+ DateSpan.prototype.days[day.getDay()];

		bindery_page.day_checkbox_data[day_property].start = 
				$(field_selector_baseline.replace('row', '#DateDateStartSlide')).val();

		bindery_page.day_checkbox_data[day_property].end = 
				$(field_selector_baseline.replace('row', '#DateDateEndSlide')).val();
	}
}

/**
 * Set the day check states from the memorize pattern
 */
function setCheckboxesFromMemorizedPattern() {
	for (var memorized_check in bindery_page.day_checkbox_data) {
		$('#'+memorized_check).
			prop('checked', bindery_page.day_checkbox_data[memorized_check].check_state).
			on('change', makeDatesForDay);
	}
}

/**
 * The change behavior for a Day checkbox
 * 
 * Unchecked will remove all Dates for that day
 * Checked will generate all the Dates on this Day within the Session date range 
 * and will set the time span if it's know 
 * 
 * @param {event} e
 */
function makeDatesForDay(e) {
	removeDatesForDay($(e.currentTarget).attr('id'));
	if ($(e.currentTarget).prop('checked')) {
		alert('now I should make new record rows');
	}
}

/**
 * Remove all the date rows for a single day of the week
 * 
 * @param {string} day_label dayWed, dayFri, etc
 */
function removeDatesForDay(day_label) {
	var date_inputs = $('input.'+day_label);
	if (date_inputs.length === 0) {
		return;
	}
	var all_rows = bindery_page.fragment.TR;
	$(date_inputs).each(function(){
		$(all_rows[ 'row-' + bindery_page.fragment[$(this).attr('id')].uuid ].node).remove();
	});
}

/**
 * Generate the checkboxes from the current Session start and end date
 * 
 * @param {Date} first_day
 * @param {Date} last_day
 * @returns {undefined}
 */
function newDayCheckSet(first_day, last_day) {
	if (!first_day instanceof Date || !last_day instanceof Date){
		return '';
	}
	var dateRange = new DateSpan(first_day, last_day);
	var new_check_set = dateRange.daysInSpan();
	$('div.day_pattern').html(new_check_set);
	$('div.day_pattern input').on('change', makeDatesForDay);
//	$('div.day_pattern input').on('change', function(){
////		makeDatesForDay(e);
//	});
}

/**
 * Create a new Workshop Session from the template of a previous session
 * 
 * This process is destructive to any data in the form. 
 * 
 * @param {droppable} event
 * @param {draggable} ui
 */
function newSessionFromTemplate(event, ui){
	$(ui.draggable).css('top', '5px').css('left', '10px');
	
	// make convenience vars for template data, Session inputs and Date records
	var template = provider.sessions[$(ui.draggable).data('uuid')].data;
	var destination = bindery_page.record[$(event.target).data('uuid')];
	var date_records = null; // define the pointer here
	
	// clone out the workshop session record
	// clone out the date records

	// analize the dates appropriate to this session
	// set the assumed date inputs
	
	p = null;
	for (p in template) {
		if (typeof(template[p]) === 'string') {
//			destination[p].node.val(template[p]);
			if (destination[p] !== undefined && p !== 'id') {
				destination[p].value = template[p];
			}			
			alert('p='+p);
			alert('val='+template[p]);
		}
	}
	alert(ui);
}
