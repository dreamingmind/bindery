$(document).ready(function(){
	init();	
});

var bindery_page = new PageManager();

function init () {
	$('fieldset').each(function () {
		bindery_page.add(this);
	});
	bindery_page.add($('table.session_dates'));
	$('li[id*="session_id-"]').each(function() {
		var u = $(this).attr('id').replace("session_id-", '');
		var li = new ManagedNode($(this));
		li.uuid = u;
		$(this).find('b').data(li);
	});
	
	/**
	 * Make old session listings draggable data providers to session fieldset
	 */
	$('li[id*="session_id-"] > b').draggable().css('color', 'firebrick').css('background-color', 'gray').css('cursor', 'pointer');
	$('fieldset[id*="workshop-"]').droppable({
		drop: function(event, ui){
			newSessionFromTemplate(event, ui);
		}
	}).css('background-color', 'yellow')
	/* END OF SESSION LISTING DRAG/DROP INITIALIZATION */
}

function newSessionFromTemplate(event, ui){
	alert($(event.target).data('fullId'));
	alert($(ui.draggable).data('fullId'));
	var template = provider.sessions[$(ui.draggable).data('uuid')];
	var destination = bindery_page.record[$(event.target).data('uuid')];
	p = null;
	for (p in template) {
		if (typeof(template[p]) === String) {
			destination[p] = template[p];
		}
	}
	alert(ui);
}
