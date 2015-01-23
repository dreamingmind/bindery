$(document).ready(function(){
	
//	if ($('fieldset.Shipping, fieldset.Billing, input#CartSame').length === 3) {
//		establishCartSameValue();
//	};
//	capturePaypal();
})


//function establishCartSameValue() {
//	var check = true;
//	$('fieldset.Shipping input').each(function() {
//		var bill = $(this).attr('id').replace('Shipping', '#Billing');
//		if (bill != '#BillingId') {
//			check = check && ($(this).val() === $(bill).val())
//		}		
//	})
//	$('input#CartSame').prop('checked', check);
//	setBilling();
//}
/**
 * Add any product to the shopping cart
 * 
 * The PurchasesComponent will analize the POST data and make the 
 * concrete Product component to generate a new cart item. 
 * The fully operational (deathstar) cart display will be returned as
 * a floating div and placed after the clicked button. 
 * 
 * @param {event} e
 * @returns {void}
 */
function addToCart(e) {
	e.preventDefault();
	var postData = $(e.currentTarget).parents('form').serialize();
	
	$.ajax({
		type: "POST",
		dataType: "HTML",
		data: postData,
		url: webroot+'cart_items/addToCart',
		success: function(data) {
			$('body').append(data);
			$('div#cart_pallet').center().draggable();
			cartBadge();
			bindHandlers('div#cart_pallet');
			$('div#pgMask').addClass('cover').on('click', function(e) {
				$('button#continue').trigger('click');
			});
			if ($.wish) {
				$($.wish).remove();
				$.wish = false;
			}
				
		},
		error: function(data) {
			// ********************************************************************************************* This looks like stub code!
			alert('AJAX ERROR\n' + data);
//			function(xhr, status, error) {
//				var exception = xhr.responseText.match(/Invalid cart/);
//				if (exception == 'Invalid cart') {
//					$('div#cart_item-'+id).html('<p>The item was not found in your cart.</p><p>Try refreshing your page to get things sorted out.</p>');
//				}
//				bindHandlers('div#cart_item-'+id);
//			}
		}
	})
}

function addWishToCart(e) {
	$.wish = '#cart_item-' + $(e.currentTarget).parents('form').attr('id').match(/\d+/)[0];
	addToCart(e);
}

function saveChangesToCart(e) {
	e.preventDefault();
	var postData = $(e.currentTarget).parents('form').serialize();

	$.ajax({
		type: "POST",
		dataType: "HTML",
		data: postData,
		url: webroot+'cart_items/updateCart',
		success: function (data) {
			$('body').append(data);
			$('div#cart_pallet').center().draggable();
			cartBadge();
			bindHandlers('div#cart_pallet');
			$('div#pgMask').addClass('cover').on('click', function(e) {
				$('button#continue').trigger('click');
			});
			
		},
		error: function (data) {
			// ********************************************************************************************* This looks like stub code!
			alert('AJAX ERROR\n' + data);
		}
	})

}

function submitContacts(e) {
	e.preventDefault();
	var result = true;
	$('#CartContactsForm').find('input').each(function(e) {
		result = result && ($(this).val().length > 0);
	})
	if (result) {
		$.ajax({
			type: "POST",
			dataType: "HTML",
			data: $('#CartContactsForm').serialize(),
			url: webroot + 'carts/save_contacts',
			success: function (data) {
				var error = data.match(/error/) !== null;
				if (error) {
					$('#CartContactsForm > fieldset').after(data);
				} else {
					$('#CartContactsForm').replaceWith(data);
					$('div.mask').removeClass('cover');
				}
			},
			error: function (data) {
				alert('There was a problem contacting the server. Please try again.')
			}
		})

	} else {
		alert('Please provide all 4 pieces of information.');
	}
}

/**
 * Render a new cart badge and update the page
 * 
 * @returns {voic}
 */
 function cartBadge() {
	$.ajax({
		type: "GET",
		dataType: "HTML",
		url: webroot+'cart_items/newBadge/TRUE',
		success: function(data) {
			$('#cart_badge').replaceWith(data);
		},
		error: function(data) {
			alert('AJAX ERROR\n' + data);
		}
	})
	 
 }

/**
 * Toggle cart items between Summary and Detail display
 * 
 * Uses the toggleData json object that was sent with the cart
 */
function itemDetailToggle(e) {
	e.preventDefault();
	var id = $(e.currentTarget).attr('href').match(/[checkout|cart].*\/(\d*)/)[1];
	var mode = $(e.currentTarget).html();
	var wrapper = $('#cart_item-' + id);
	
	if (mode === 'Expand') {
		var fetch = 'full';
		mode = 'Collapse';
		var old_class = 'item_summary'
		var div_class = 'item_detail';
	} else {
		var fetch = 'summary';
		mode = 'Expand';
		var old_class = 'item_detail'
		var div_class = 'item_summary';
	}
	
	wrapper.removeClass(old_class).addClass(div_class);

	wrapper.find('.item_text').html('');
	wrapper.find('.item_text')
			.append(toggleData[id]['product_name'][fetch])
			.append(toggleData[id]['blurb'][fetch])
			.append(toggleData[id]['options'][fetch]);
	
	wrapper.find('a.toggleDetail').html(mode);
	
//	alert('Toggle display mode for item ' + id);
}

function updateQuantity(e) {
	
	var qtyInput = $(e.currentTarget);
	// validate numeric quantity and watch for ZERO
	var qty = qtyInput.val();
	var id = qtyInput.attr('id').match(/\d*/)[0];
	
	// insist on numbers
	if (qty.match(/[^0-9]/)) {
		alert('You can only set quantity to a positive number');
		qtyInput.val(1);
		
	// on ZERO, confirm the desire to remove the item
	} else if ( qty == '0') {
		var response = confirm('Setting quantity to zero will remove this item from the cart. Proceed?');
		if (response) {
			$('div#cart_item-'+id).find('a.tool.remove').trigger('click');
		} else {
			qtyInput.val(1);
		}
		
	// on a good, numeric input, do the ajax to update the item
	} else {
		var itemTotal = $('span#item_total-'+id);
		var subtotal = $('div.cart_summary > p > span.cart_subtotal')

		$.ajax({
			type: "PUT",
			dataType: "HTML",
			url: webroot+'cart_items/updateQuantity/' + id + '/' + qty,
			success: function(data) {
				qtyInput.siblings('#check').animate({opacity: 1,}, 100 ).delay(5000).animate({opacity: 0}, 1200);
				// remove old flash messages
				$('div.flash.message').remove();

				if ($(data).find('div.flash.message').length === 0) {
					// get rid of any remaining flash messages. multiples don't work right
					$('div.flash').remove();
					
					// update the item total
					var newItemTotal = $(data).find('span#item_total-' + id).html();
					$(itemTotal).html(newItemTotal);
					
					// update the cart subtotal
					var newSubtotal = $(data).find('p > span.cart_subtotal').html();
					$(subtotal).html(newSubtotal);
					
					// record the new 'old' value
					qtyInput.attr('old_val', qty);
				} else {
					qtyInput.parents('div[id*="cart_item-"]').append($(data).find('div.flash.message'));
					bindHandlers('div.flash.message');
					qtyInput.val(qtyInput.attr('old_val'));
				}	
			// the flash messages aren't being rendered or handled here. not such a good thing =======================================================fix me
			},
		error: function(xhr, status, error) {
			var exception = xhr.responseText.match(/Invalid cart/);
			if (exception == 'Invalid cart') {
				$('div#cart_item-'+id).html('<p>The item was not found in your cart.</p><p>Try refreshing your page to get things sorted out.</p>');
			}
			bindHandlers('div#cart_item-'+id);
		}
		})
	}
//	alert(qty);
//	alert(id);
}

function wishItem(e) {
	e.preventDefault();
	var id = $(e.currentTarget).attr('href').match(/wish\/(\d*)/)[1];
	$.ajax({
		type: "POST",
		dataType: "JSON",
		data: '',
		url: webroot + 'cart_items/wish/' + id,
		success: function (data) {
			removalSuccess(data, id);
		},
		error: function (data) {
			
		}
	})

}

/**
 * Remove specified cart items and refresh the screen
 * 
 * Removal takes a row out of the cart pallet or cart checkout page 
 * and updates the cart badge. This may be the last page, so 
 * special processes need to take care of that. 
 * 
 * @param {event} e
 * @returns {void}
 */
function removeItem(e) {
	e.preventDefault();
	var id = $(e.currentTarget).attr('href').match(/remove\/(\d*)/)[1];
	var cartBadge = $('#cart_badge');
	var subtotal = $('div.cart_summary > p > span.cart_subtotal')
	
	$.ajax({
		type: "DELETE",
		dataType: "JSON",
		url: webroot + 'cart_items/remove/' + id,
		success: function(data) {
			removalSuccess(data, id);
		},
		error: function(xhr, status, error) {
			var exception = xhr.responseText.match(/Invalid cart/);
			if (exception == 'Invalid cart') {
				$('div#cart_item-'+id).html('<p>The item was not found in your cart.</p><p>You can confirm it\'s removal on checkout</p>');
			}
			bindHandlers('div#cart_item-'+id);
		}
	})

}

	function removalSuccess(data, id) {
		var cartBadge = $('#cart_badge');
		var wishBadge = $('#wish_badge');
		var subtotal = $('div.cart_summary > p > span.cart_subtotal')
	
		// get rid of any remaining flash messages. multiples don't work right
		$('div.flash').remove();

		// update the badge
//			var newBadge = $(data).find('#cart_badge');
		$(cartBadge).replaceWith(data.cart_badge);
		$(wishBadge).replaceWith(data.wish_badge);

		// update the cart subtotal
//			var newSubtotal = $(data).find('p > span.cart_subtotal').html();
		$(subtotal).html(data.cart_subtotal);

		// success/failure messages get placed differently in the DOM
		if (data.result === 'success') {
			$('div#cart_item-' + id).replaceWith(data.flash);
//				if (cartCount() == '0') {
//					$('#successMessage span').html('Your cart is empty.');
//				}
			bindHandlers('#successMessage');

		} else if (data.result === 'failure') {
			$('div#cart_item-' + id).prepend(data.flash);
			bindHandlers('div#cart_item-' + id);

		} else if (data.result === 'empty') {
			// swap out all content for this flash message
			if ($('#cart_pallet').length > 0) {
				var continueButton = $('#continue').clone(true);
				$('#cart_pallet').html(data.flash);
				$('#cart_pallet').append(continueButton);
				$('#continue').addClass('hide');
			} else if ($('#checkout').length > 0) {
				$('#checkout').html(data.flash);
			}
		}
		if (was == 'was removed' || empty == 'Your cart is empty.') {
//				var url = $(data).find('#url').html();
//				$.ajax({
//					type: "GET",
//					dataType: "HTML",
//					url: url,
//					success: function (data) {
//						
//					},
//					error: function (data) {
//						
//					}
//				})

		}
	}			

/**
 * Dismiss the shopping cart
 * 
 * If it's a pallet, it will be disappeared. 
 * If we're in checkout process, we'll return to the referring page.
 * 
 * @param {event} e
 * @returns {void}
 */
function continueShopping(e) {
	if (controller == 'checkout/') {
		location.assign($(e.currentTarget).attr('href'));
	} else {
		$('#pgMask').removeClass('cover').off('click');
		$('div#cart_pallet').remove();
	}
}

/**
 * Get thee to the first checkout-process page
 * 
 * @param {event} e
 * @returns {void}
 */
function checkout(e){
	e.preventDefault();
	location.assign(webroot + 'checkout');
}

function pay_check(e) {
	location.assign(webroot + 'carts/checkout_address');
}

function pay_express(e){
	var method = $(e.currentTarget).attr('method');
	if (method == 'paypal') {
		location.assign(webroot + 'carts/express');
//		$.ajax({
//			type: "GET",
//			dataType: "HTML",
//			url: webroot + 'cart_items/pay/paypal',
//			success: function(data) {
//				$('body').append(data);
//				$('#doBuy').trigger('click');
//			},
//			error: function(data) {
//				alert('error');
//			}
//		})

	}
}
/**
 * Direct any PayPal buttons to the site cart processes
 */
//function capturePaypal() {
//	$('form[action*="paypal"]').find('input[type="submit"]').each(function(){
//		$(this).on('click'.addToCart);
//	})
//}
