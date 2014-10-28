$(document).ready(function(){
//	capturePaypal();
})

function addToCart(e) {
	e.preventDefault();
	var postData = $(e.currentTarget).parents('form').serialize();
	
	$.ajax({
		type: "POST",
		dataType: "HTML",
		data: postData,
		url: webroot+'carts/addToCart',
		success: function(data) {
			$(e.currentTarget).after(data);
			cartBadge();
			bindHandlers('div#cart_pallet');
			$('div#pgMask').addClass('cover');
		},
		error: function(data) {
			alert('AJAX ERROR\n' + data);
		}
	})
}

 function cartBadge() {
	$.ajax({
		type: "GET",
		dataType: "HTML",
		url: webroot+'carts/newBadge',
		success: function(data) {
			$('#cart_badge').replaceWith(data);
		},
		error: function(data) {
			alert('AJAX ERROR\n' + data);
		}
	})
	 
 }

function itemDetailToggle(e) {
	e.preventDefault();
	var id = $(e.currentTarget).attr('href').match(/carts\/(\d*)/)[1];
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
			.append(toggleData[id]['design_name'][fetch])
			.append(toggleData[id]['blurb'][fetch])
			.append(toggleData[id]['options'][fetch]);
	
	wrapper.find('a.toggleDetail').html(mode);
	
//	alert('Toggle display mode for item ' + id);
}

function updateQuantity(e) {
	
	var qty = $(e.currentTarget).val();
	var id = $(e.currentTarget).attr('id').match(/\d*/)[0];
	if (qty.match(/[^0-9]/)) {
		alert('You can only set quantity to a positive number');
		$(e.currentTarget).val(1);
	} else if ( qty == '0') {
		var response = confirm('Setting quantity to zero will remove this item from the cart. Proceed?');
		if (response) {
			$('div#cart_item-'+id).find('a.tool.remove').trigger('click');
		} else {
			$(e.currentTarget).val(1);
		}
	} else {
		$.ajax({
			type: "PUT",
			dataType: "HTML",
			url: webroot+'carts/update_cart/' + id + '/' + qty,
			success: function(data) {

			},
			error: function(data) {

			}
		})
	}
//	alert(qty);
//	alert(id);
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
	var id = $(e.currentTarget).attr('href').match(/delete\/(\d*)/)[1];
	var cartBadge = $('#cart_badge');
	
	$.ajax({
		type: "DELETE",
		dataType: "HTML",
		url: webroot + 'carts/delete/' + id,
		success: function(data) {
			// get rid of any remaining flash messages. multiples don't work right
			$('div.flash').remove();
			
			// update the badge
			var newBadge = $(data).find('#cart_badge');
			$(cartBadge).replaceWith(newBadge);
			
			// success/failure messages get placed differently in the DOM
			var was = data.match(/was removed/);
			var was_not = data.match(/was not removed/);
			if (was == 'was removed') {
				$('div#cart_item-'+id).replaceWith($(data).find('div.flash'));
				if (cartCount() == '0') {
					$('#successMessage span').html('Your cart is empty.');
				}
				bindHandlers('#successMessage');
			} else if (was_not == 'was not removed') {
				$('div#cart_item-'+id).prepend($(data).find('div.flash'));
				bindHandlers('div#cart_item-'+id);
			}
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

function continueShopping(e) {
	if (action == 'checkout/') {
		location.assign($(e.currentTarget).attr('href'));
	} else {
		$('#pgMask').removeClass('cover');
		$('div#cart_pallet').remove();
	}
}

function checkout(e){
	e.preventDefault();
	location.assign(webroot + 'carts/checkout');
}
/**
 * Direct any PayPal buttons to the site cart processes
 */
//function capturePaypal() {
//	$('form[action*="paypal"]').find('input[type="submit"]').each(function(){
//		$(this).on('click'.addToCart);
//	})
//}
