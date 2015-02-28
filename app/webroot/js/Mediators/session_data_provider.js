$(document).ready(function(){
	provider.init();
});

/**
 * Assumes management of a UL with id="session_data_provider-xxx" 
 * where xxx is the Workshop record id. 
 * 
 * Call with a different selector passed as the param for init 
 * but the alternate selector must still end with digits that are 
 * the id of the Workshop record and these must be the only 
 * digits in the element's id.
 * 
 * Both init arguments are optional, but if you provide 
 * an alternate selector you must provide range.
 * <parent id="session_data_provider-xxx"> // xxx is a collection id
 *		<child-descendent id="session_id-yyy>
 *			<trigger />
 *			<grandchild-descendent id="date_id-zzz"></grand-desc>
 *		</chi-desc>
 * </parent>
 */
var provider = {
	selector: 'ul[id*="session_data_provider"]',
	range: 'all',
	template_trigger: 'li[id*="session_id-"] > b',
	collection_id: false,
	sessions: false,

//	init: function(range, selector){
	init: function(config){
		if (typeof(config) != 'undefined') {
			provider.configure(config);
		}

		// load the json data that supports this service
		provider.collection_id = $(provider.selector).attr('id').match(/\d+/),
		$.getJSON( webroot + controller + 'provideSessionJson/' + provider.collection_id, 
			function( json ) {
				provider.sessions = json;
			}
		);
		// bind the click elements that will send data to a form
		var click_targets = $(provider.selector).find(provider.template_trigger).each(function(){
			var session_id = $(this).parent().attr('id').match(/\d+/);
			$(this)
				.attr('title', 'Click to fill the form with this session template')
				.attr('id', 'target_session_id-' + session_id)
				.css('cursor', 'pointer')
				.on('click', provider.template);
		});
	}, // END OF THE init() FUNCITON
	
	/**
	 * Overwrite the default properties with new values
	 * 
	 * @param {json object} config the values to substitute for the defaults
	 */
	configure: function(config) {
		for (var p in config) {
			provider[p] = config[p];
		}
	},
	
	template: function(e) {
		var template_id = $(e.currentTarget).attr('id').match(/\d+/);
		var template_data = provider.sessions[template_id];
	}
};