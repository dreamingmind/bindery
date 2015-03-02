$(document).ready(function(){
	DateTable = new dt({new_call: webroot + 'dates/dateRow',
		call_for_rows: true
	});
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
	this.control_row_selector = 'tr.control',
	this.new_control = 'button.new',
	this.submit_control = '.submit',
	
	// element reference containers
	this.row_html_template = false,
	this.control_row = false,
	this.table = false,
	this.rows = false,
	
	this.scan = function(){
	},
	
	/**
	 * Configure and initialize the object on page load
	 */
	this.init = function(config){
		if (typeof(config) != 'undefined') {
			this.configure(config);
		}
		$(document).on('mediate', this.scan);
		this.rows = new record_warehouse('Date');
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
	
	this.new = function(e){
		if (e.data.self.call_for_rows) {
			e.data.self.callForNewRow(e);
			$(e.data.self.control_row).before(e.data.self.rows.add(e.data.self.row_html_template));
		} else {
			$(e.data.self.control_row).before(e.data.self.rows.add(e.data.self.row_html_template));
		}
	},
	
	this.callForNewRow = function(e){
		$.ajax({
			type: "GET",
			dataType: "JSON",
			url: e.data.self.new_call,
			async: false,
			success: function (data) {
				e.data.self.row_html_template = data.row;
			},
			error: function (jqXHR, status, error ) {
				
			}
		})

	},
	
	/**
	 * Overwrite the default properties with new values
	 * 
	 * @param {json object} config the values to substitute for the defaults
	 */
	this.configure = function(config) {
		for (var p in config) {
			this[p] = config[p];
		}
	}
	
	this.init(config);
	
};

// ========================================================================================
// ========================================================================================
// ========================================================================================

/**
 * Object to store, access and modify inputs buried in an html fragment
 * 
 * WARNING: The fragment must be one node (but it can have descendents) 
 * and it can't have comments or whitespace before the opening tag 
 * and it can't be an input of any kind
 * 
 * The first tag must have an id (string) 
 * All the IDs in the fragment will have -xxxxx appended to make them 
 * unique for the group. xxxxx will be a the date in seconds with microseconds
 * 
 */
function record_warehouse (model) {
	
	this.model = model;
	this.html_reference = {};
	this.fields = {};
	this.fragment_id = false;

	/**
	 * Add a new htlm fragment to the stack
	 * 
	 * 
	 * 
	 * @param {html} fragment
	 * @returns {Array} this last inserted element
	 */
	this.add = function(fragment){
		
		fragment_id = this.newFragmentId();
		this.html_reference[fragment_id] = $(fragment);
		this.fields[fragment_id] = {};
		self = this;
		parseFragment = this.parseFragment;
		// uniquify the wrapper element
		$(this.lastReference()).attr('id', this.idAttribute(this.lastReference())+'-'+fragment_id);

		// uniquify all the descendents that have IDs
		// and store references to the fields
		$(this.lastReference()).find('*').each(function(){
			self.parseFragment(self, this);
		});
		
		$(document).trigger('mediate', $(this.lastReference()));
		return this.lastReference();
	}
	
	/**
	 * Return the last stored html fragment
	 * 
	 * @returns {Array} 
	 */
	this.lastReference = function() {
		if (this.fragment_id) {
			return this.html_reference[this.fragment_id];
		}
		return false;
	}
	
	/**
	 * Return the element's id if it exists or false
	 * 
	 * @param {html} element
	 * @returns {String|Boolean}
	 */
	this.idAttribute = function(element){
		if (typeof($(element).attr('id')) !== 'undefined') {
			return $(element).attr('id');
		} else {
			return false;
		}
	}

	/**
	 * Return the element's id if it exists or false
	 * 
	 * @param {html} element
	 * @returns {String|Boolean}
	 */
	this.fieldName = function(element){
		if (typeof($(element).attr('name')) == 'undefined') {
			return false;
		}
		var match = $(element).attr('name').match(/\[([a-z_]*)\]$/);
		if (match[1] == 'undefined') {
			return false;
		}
		return match[1];
	}

	/**
	 * Get the time as seconds with microseconds to use as an element id modifier
	 * 
	 * Used to associate sets of related values
	 * 
	 * @returns {String}
	 */
	this.newFragmentId = function() {
		this.fragment_id = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
    return v.toString(16);
});
//		this.fragment_id = new Date().getTime().toString();
		return this.fragment_id;
	}
	
	this.parseFragment = function(self, fragment) {
		if (self.idAttribute(fragment)) {
			$(fragment).attr('id', self.idAttribute(fragment) + '-' + self.fragment_id);
			field = self.fieldName(fragment);
			if (field) {
				self.fields[self.fragment_id][field] = $(fragment);
			}
		}
	}		

};
