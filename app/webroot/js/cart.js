$(document).ready(function(){
	
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