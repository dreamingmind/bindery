$(document).ready(function(){
	init();	
});

var bindery_page = new PageManager();

function init () {
	$('fieldset').each(function () {
		bindery_page.add(this);
	});
}
