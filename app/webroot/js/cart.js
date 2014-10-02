$(document).ready(function(){
	
})

function addToCart(e) {
	var postData = $(e.currentTarget).parents('form').serialize();
	
	$.ajax({
		type: "POST",
		dataType: "HTML",
		data: '',
		url: webroot+'carts/addToCart',
		success: function(data) {
			alert('AJAX SUCCESS\n' + data);
		},
		error: function(data) {
			alert('AJAX ERROR\n' + data);
		}
	})

}