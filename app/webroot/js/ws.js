//var page = false;

$(document).ready(function(){
	init();	
	alert(bindery_page.field.length);
});

var bindery_page = new PageManager();

function init () {
//	bindery_page = new PageManager();
	
	$('fieldset').each(function () {
		bindery_page.add(this);
	});
}
