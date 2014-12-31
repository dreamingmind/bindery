/**
 * Sync Shipping vals to Billing vals if 'same' is requested
 */
function initContacts() {
	var name = $('fieldset.contact').find('input[id*="name"]').val();
	if($('#ShippingName1').val() == ''){
		$('#ShippingName1').val(name);
	}
}

$(document).ready(function(){
	
	if (action == 'index/') {
		// this has to run before order_address.js
		// so the address init processes for effected fields won't have 
		// the data they need to potentially pass along
		initContacts();
	}
})