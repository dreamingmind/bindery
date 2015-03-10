$(document).ready(function () {
	DateTable = new dt({new_call: webroot + 'dates/dateRow',
		call_for_rows: true
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
			this.row_html_template = false,
			this.control_row = false,
			this.table = false,
			this.rows = false,
			this.scan = function () {
			},
			/**
			 * Configure and initialize the object on page load
			 */
			this.init = function (config) {
				if (typeof (config) != 'undefined') {
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
							row_html_template: this.row_html_template
						}, this.new
						);
			},
			this.new = function (e) {
				if (e.data.self.call_for_rows) {
					e.data.self.callForNewRow(e);
					$(e.data.self.control_row).before(bindery_page.add(e.data.self.row_html_template));
				} else {
					$(e.data.self.control_row).before(bindery_page.add(e.data.self.row_html_template));
				}
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
				})

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
			}

	this.init(config);

}
;

// ========================================================================================
// ========================================================================================
// ========================================================================================
