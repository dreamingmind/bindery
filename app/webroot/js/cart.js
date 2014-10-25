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

function itemQuantityChange(e) {
	
	
	$.ajax({
		type: "GET",
		dataType: "JSON",
		url: 'carts/update_cart/' + id + '/' + qty,
		success: function(data) {
			
		},
		error: function(data) {
			
		}
	})

}
/**
 * Direct any PayPal buttons to the site cart processes
 */
//function capturePaypal() {
//	$('form[action*="paypal"]').find('input[type="submit"]').each(function(){
//		$(this).on('click'.addToCart);
//	})
//}
