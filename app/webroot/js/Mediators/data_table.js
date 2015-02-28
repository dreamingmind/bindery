$(document).ready(function(){
	dt.init();
});

/**
 * Data entry table behavior
 * 
 * Data entry tables one data record per row. 
 * The last cell in the row has a remove/delete tool with class = .remove 
 * The last row (or only row) in the table has a 'New' button (class = .new) 
 *		that will add a new record row to the table.
 * The data will either be saved continuously as the fields change or the last 
 *		row will have a save/submit tool (class = .submit) that saves all the data
 */
var dt = {
	// behavioral settings
	field_save: false,
	call_for_rows: false,
	
	// callpoints
	new_call: false,
	remove_call: false,
	field_save_call: false,
	submit_call: false,
	
	// element selectors
	table_selector: 'table.session_dates > tbody',
	control_row_selector: 'tr.control',
	new_control: 'button.new',
	submit_control: '.submit',
	
	// element reference containers
	row_html_template: '<tr id="row"><td class="cal-widget ui-droppable"></td><td><input type="hidden" id="DateId" name="data[Date][id]"><div class="input text required"><label for="DateDate">Date</label><input type="text" required="required" id="DateDate" name="data[Date][date]"></div><p id="date_duration"></p></td><td><label for="DateStartTime">Start Time</label><input type="text" id="DateStartTime" name="data[Date][start_time]"><input type="range" value="1" step="1" max="28" min="0" id="date_start_slide"></td><td><label for="DateEndTime">End Time</label><input type="text" id="DateEndTime" name="data[Date][end_time]"><input type="range" value="12" step="1" max="32" min="4" id="date_end_slide"></td><td><button class="remove" type="button">Remove</button></td></tr>',
	control_row: false,
	table: false,
	rows: false,
	
	scan: function(){
	},
	
	init: function(){
		$(document).on('mediate', dt.scan);
		dt.rows = row_warehouse;
		dt.table = $(dt.table_selector);
		dt.control_row = $(dt.control_row_selector);
		$(dt.new_control).on('click', dt.new);
	},
	
	new: function(){
		if (dt.call_for_rows) {
			$(dt.control_row).before(dt.rows.add(dt.callForNewRow()));
		} else {
			$(dt.control_row).before(dt.rows.add(dt.row_html_template));
		}
	}
	
};

/**
 * Object to store, access and modify TRs and the data record contained in them
 */
var row_warehouse = {
	stored: [],

	add: function(row){
		row_warehouse.stored.push($(row));
		var last = row_warehouse.stored.length-1;
		var now = new Date().getTime().toString();
		row_warehouse.stored[last].attr('id', row_warehouse.stored[last].attr('id')+'-'+now);

		row_warehouse.stored[last].find('*').each(function(){
			var id = $(this).attr('id');
			if (typeof(id) !== 'undefined') {
				$(this).attr('id', id+'-'+now);
			}
		});
		$(document).trigger('mediate', row_warehouse.stored[last]);
		return row_warehouse.stored[last];
	}
};
