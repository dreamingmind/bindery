/**
 * Make Billing address the same as the Shipping address
 */
function sameBilling() {
	// Billing won't show if its the same as shipping
	$('fieldset.Billing').addClass('hide');
	
	$('fieldset.Shipping').find('input').each(function() {
		var id = $(this).attr('id');
		// don't synch the record id!
		if (id != 'ShippingId') {
			var val = $(this).val();
			var target = id.replace('Shipping', 'Billing');
			// memorize billing address values in case we want to restore them
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

function establishCartSameValue() {
	var same = true;
	var empty = true;
	$('fieldset.Shipping input').each(function() {
		var bill = $(this).attr('id').replace('Shipping', '#Billing');
		if (bill != '#BillingId' && !(bill.match(/Foreign/))) { // this could also be done as !type=hidden
			same = same && ($(this).val() === $(bill).val());
			empty = empty && ($(bill).val() == '');
		}		
	})
	$('input#CartSame').prop('checked', same || empty);
	if (same || empty) {
		set_billing();
	}
}

function initContactName() {
	$('fieldset.contact input[id*="-name"]').on('change', function(e){
		if ($('#ShippingName1').val() == '') {
			$('#ShippingName1').val($(e.currentTarget).val());
		}
	})
}

	// start out with the addresses the same
$(document).ready(function() {

	// if we have these three collaborating elements, establish their start state
	if ($('fieldset.Shipping, fieldset.Billing, input#CartSame').length === 3) {
		establishCartSameValue();
	};
	
//	sameBilling();
	// make shipping synch to billing if 'same' is requested
	initShipping();
	
	initContactName();
})