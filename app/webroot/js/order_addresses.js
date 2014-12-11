/**
 * Make Shipping address the same as the Billing address
 */
function sameBilling() {
	// Shipping won't show if its the same as billing
	$('fieldset.Billing').addClass('hide');
	$('fieldset.Shipping').find('input').each(function() {
		var id = $(this).attr('id');
		// don't synch the record id!
		if (id != 'ShippingId') {
			var val = $(this).val();
			var target = id.replace('Shipping', 'Billing');
			// memorize shipping address values in case we want to restore them
			$('fieldset.Billing').data(target, $('#' + target).val());
			// and set billing to match shipping 
			$('#' + target).val(val);
		}		
	})
}

/**
 * Make Billing address different than Shipping address
 */
function differentBilling() {
	$('fieldset.Billing').removeClass('hide');
	$('fieldset.Billing').find('input').each(function() {
		var id = $(this).attr('id');
		if (id != 'BillingId') {
			// restore the original Billing values
			$('#' + id).val($('fieldset.Billing').data(id));
		}		
	})
}

/**
 * Change address behaviors based on 'same' setting
 */
function set_billing() {
	if ($('#CartSame').prop('checked')) {
		sameBilling();
	} else {
		differentBilling();
	}
}

/**
 * Sync Shipping vals to Billing vals if 'same' is requested
 */
function initShipping() {
	$('fieldset.Shipping').find('input').each(function() {
		$(this).on('change', function(e) {
			if ($('#CartSame').prop('checked')) {
				var self = $(e.currentTarget);
				var id = $(self).attr('id');
				var target = id.replace('Shipping', 'Billing');
				$('#' + target).val($(self).val());
			}
		})
	})
}

$(document).ready(function() {
	// start out with the addresses the same
	sameBilling();
	// make shipping synch to billing if 'same' is requested
	initShipping();
})