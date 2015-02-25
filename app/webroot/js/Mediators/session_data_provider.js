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
	collection_id: false,
	sessions: false,

	init: function(range, selector){
		if (typeof(range) != 'undefined' && range.match(/all|current|expired/)) {
			provider.range = range;
		}
		if (typeof(selector) != 'undefined') {
			provider.selector = selector;
		}
		provider.collection_id = $(provider.selector).attr('id').match(/\d+/),
		$.getJSON( webroot + controller + 'provideSessionJson/' + provider.collection_id, 
			function( json ) {
				provider.sessions = json;
			}
		);
	}	
}