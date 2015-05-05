$(document).ready(function () {
	DateTable = new dt({
		new_call: webroot + 'dates/dateRow',
		call_for_rows: false
	});
//	t = new CakeTable_v2_6();
});

var DateTable = {};

/**
 * Data entry table behavior
 * 
 * Data entry tables one data record per row. 
 * The last cell in the row has a remove/delete tool with class = .remove 
 * The last row (or only row) in the table has a 'New' button (class = .new) 
 *		that will add a new record row to the table.
 * The data will either be saved continuously as the fields change or the last 
 *		row will have a save/submit tool (class = .submit) that saves all the data
 *		
 * @param {object} config Override values for default properties
 */
function dt(config) {

//	this.init(config);

	// behavioral settings
	this.field_save = false,
			this.call_for_rows = false,
			// callpoints
			this.new_call = false,
			this.remove_call = false,
			this.field_save_call = false,
			this.submit_call = false,
			// element selectors
			this.table_selector = 'table.session_dates > tbody',
			this.control_row_selector = 'tr[id*="control"]',
			this.new_control = 'button[id*="new"]',
			this.submit_control = '.submit',
			// element reference containers
			this.row_html_template = '<tr id="row" class="date_row"> <td> <input type="hidden" name="data[Date][id]" id="DateId"/><div class="input text required"><label for="DateDate">Date</label><input name="data[Date][date]" class="cal-widget" type="text" id="DateDate" required="required"/></div> <p id="date_duration"></p> </td> <td> <label for="DateStartTime">Start Time</label><input name="data[Date][start_time]" type="text" id="DateStartTime"/><input name="data[Date][date_start_slide]" min="0" max="38" step="1" value="1" type="range" id="DateDateStartSlide"/> <!--<input id="date_start_slide" type="range" min="0" max="38" step="1" value="1" />--> </div> </td> <td> <label for="DateEndTime">End Time</label><input name="data[Date][end_time]" type="text" id="DateEndTime"/><input name="data[Date][date_end_slide]" min="4" max="42" step="1" value="12" type="range" id="DateDateEndSlide"/> <!--<input id="date_end_slide" type="range" min="4" max="42" step="1" value="12" />--> </div> </td> <td> <button type="button" class="remove">Remove</button> </td> </tr>',
			this.control_row = false,
			this.table = false,
			this.rows = false,
			this.scan = function () {
			},
			/**
			 * Configure and initialize the object on page load
			 * @param {object} config Override values for default properties
			 */
			this.init = function (config) {
				if (typeof (config) !== 'undefined') {
					this.configure(config);
				}
				$(document).on('mediate', this.scan);
				this.rows = {};
//				this.rows = new RecordWarehouse('Date');
				this.table = $(this.table_selector);
				this.control_row = $(this.control_row_selector);
				$(this.new_control).on('click',
						{
							self: this,
							call_for_rows: this.call_for_rows,
							callForNewRow: this.callForNewRow,
							control_row: this.control_row,
							rows: this.rows,
							row_html_template: this.row_html_template,
							sortDateRows: this.sortDateRows
						}, this.new
						);
			},
			// this will need a tool to keep thing is proper order
			// if it is going to serve as a call point for the new auto-generation behavior using day checkboxes
			// or possibly that will be a new method somewhere?
			this.new = function (e) {
				if (e.data.self.call_for_rows) {
					// we make an ajax call to get rows
					e.data.self.callForNewRow(e); // load a new row from server rather than use a stored template
				}
				var row = $(e.data.self.row_html_template)[0]; // make this an element, not a string
				$(e.data.self.control_row).before(bindery_page.add(row));
				
				// nudge the sliders into intialized state
				$(row).find('input').trigger('mousemove');
				
				$(row).find('input[id*="DateDate-"]').on('change', function() {
					var d = new Date($(this).val());
					$(this).data('date', d).attr('class' ,'cal-widget day'+DateSpan.prototype.days[d.getDay()]);
					e.data.sortDateRows($(this));
				});
				var new_row = bindery_page.fragment[$(bindery_page.last_node).attr('id')];
				cal.linkedDateField = bindery_page.fragment[new_row.fullId.replace('row', 'DateDate')].node;

			},
			this.callForNewRow = function (e) {
				$.ajax({
					type: "GET",
					dataType: "JSON",
					url: e.data.self.new_call,
					async: false,
					success: function (data) {
						e.data.self.row_html_template = data.row;
					},
					error: function (jqXHR, status, error) {

					}
				});

			},
			this.set = function(date_input, date_object) {
				$(date_input).data('original_date', new Date($(date_input).val()));
				$(date_input).val(date_object.toDateString()).trigger('change');
				this.sortDateRows(date_input);
			}
			/**
			 * Put the row containing this input into ascending order in the table of rows
			 * 
			 * @param {type} date_input
			 */
			this.sortDateRows = function (date_input) {
				var temp_row;
				var working_row = new DateRow($(date_input).parents('tr')[0]);
				var rows = $('table.session_dates > tbody > tr.date_row');
				var sorted = false;
				var i = 0
    
				if (rows.length > 1) {
					
					$(working_row.row).detach();
					while (i < rows.length){
						temp_row = new DateRow(rows[i]);
						if (working_row.uuid !== temp_row.uuid && working_row.date <= temp_row.date ) {
							$(temp_row.row).before($(working_row.row));
							sorted = true;
							i = rows.length + 1;
						}
						i++;
					};
					if (!sorted) {
						$('table.session_dates > tbody > tr[id*="control-"]').before($(working_row.row));
					}
				}
			},
			/**
			 * Overwrite the default properties with new values
			 * 
			 * @param {json object} config the values to substitute for the defaults
			 */
			this.configure = function (config) {
				for (var p in config) {
					this[p] = config[p];
				}
			};

	this.init(config);

};

function DateRow(jquery_tr) {
	this.row = jquery_tr;
	this.uuid = false;
	this.date_input = false;
	this.start_slider = false;
	this.end_slider = false;
	this.date = false; // date object for the input
	this.day = false;
	this.init = function () {
		this.uuid = $(this.row).attr('id').replace('row-', '');
		this.date_input = $(this.row).find('input[id="DateDate-'+this.uuid+'"]');
		this.date = this.date_input.data('date');
		this.day = this.date.getDay();
		this.start_slider = $(this.row).find('input[id="DateDateStartSlide-'+this.uuid+'"]');
		this.end_slider = $(this.row).find('input[id="DateDateEndSlide-'+this.uuid+'"]');
	}
	this.init();
}
// ========================================================================================
// ========================================================================================
// ========================================================================================
