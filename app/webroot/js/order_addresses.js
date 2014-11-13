/**
 * Make Shipping address the same as the Billing address
 */
function sameShipping() {
	$('fieldset.Shipping').addClass('hide');
	$('fieldset.Billing').find('input').each(function() {
		var id = $(this).attr('id');
		if (id != 'BillingId') {
			var val = $(this).val();
			var target = id.replace('Billing', 'Shipping');
			// memorize shipping address values in case we want to restore them
			$('fieldset.Shipping').data(target, $('#' + target).val());
			// and set shipping to match billing 
			$('#' + target).val(val);
		}		
	})
}

/**
 * Make Shipping address different than Billing address
 */
function differentShipping() {
	$('fieldset.Shipping').removeClass('hide');
	$('fieldset.Shipping').find('input').each(function() {
		var id = $(this).attr('id');
		if (id != 'ShippingId') {
			// restore the original Shipping values
			$('#' + id).val($('fieldset.Shipping').data(id));
		}		
	})
}

/**
 * Change address behaviors based on 'same' setting
 */
function set_shipping() {
	if ($('#CartSame').prop('checked')) {
		sameShipping();
	} else {
		differentShipping();
	}
}

/**
 * Sync Billing vals to Shipping vals if 'same' is requested
 */
function initBilling() {
	$('fieldset.Billing').find('input').each(function() {
		$(this).on('change', function(e) {
			if ($('#CartSame').prop('checked')) {
				var self = $(e.currentTarget);
				var id = $(self).attr('id');
				var target = id.replace('Billing', 'Shipping');
				$('#' + target).val($(self).val());
			}
		})
	})
}

$(document).ready(function() {
	// start out with the addresses the same
	sameShipping();
	// make billing synch to shipping if 'same' is requested
	initBilling();
})