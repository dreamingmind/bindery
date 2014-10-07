$(document).ready(function(){
	capturePaypal();
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
		},
		error: function(data) {
			alert('AJAX ERROR\n' + data);
		}
	})
}

/**
 * Direct any PayPal buttons to the site cart processes
 */
function capturePaypal() {
	$('form[action*="paypal"]').find('input[type="submit"]').each(function(){
		$(this).on('click'.addToCart);
	})
}
