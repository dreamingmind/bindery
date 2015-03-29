$(document).ready(function(){
	init();	
});

var bindery_page = new PageManager();

/**
 * Make the data and control structure objects. Set behavior bindings
 */
function init () {
	// the page starts with a WorkshopSession record in a fieldset
	manageWorkshopSessionRecord();
	// the page has a table that can contain record rows
	manageSessionDateRecords();
	// the page displays existing sessions that can be used as templates for new sessions 
	manageSessionTemplates();
	// make behavior that triggers session creation from a template
	bindInitiateTemplateUseBehavior();
	// make a start-date change drag all other dates along
	bindStartDateChangeBehavior();
	/* END OF SESSION LISTING DRAG/DROP INITIALIZATION */
}

/**
 * Make the structural and data reference objects for the WorkshopSession record
 * 
 * In the PageManager object, the fieldset and control elements becomes 
 * ManagedNode objects and the fields all be come Field objects
 */
function manageWorkshopSessionRecord(){
	$('fieldset').each(function () {
		bindery_page.add(this);
	});

}

/**
 * Make structural and data reference objects for the table the houses Date records
 */
function manageSessionDateRecords() {
	bindery_page.add($('table.session_dates'));
}

/**
 * Make existing sessions display elements into template control structures
 * 
 * The page displays past sessions (each having support data built by session_data_provider.js).
 * A ManagedNode object is made to wrap each one (for normalized access) and attached 
 * to the marker which will be the draggable element that invokes use of the template.
 */
function manageSessionTemplates() {
	$('li[id*="session_id-"]').each(function () {
		var u = $(this).attr('id').replace("session_id-", '');
		var li = new ManagedNode($(this));
		li.uuid = u; // use the record id rather than a uuid since record id points to the support data
		$(this).find('b').data(li);
	});
}	

/**
 * Make old session listings draggable data providers to session fieldset
 */
function bindInitiateTemplateUseBehavior() {
	$('li[id*="session_id-"] > b').draggable().css('color', 'firebrick').css('background-color', 'gray').css('cursor', 'pointer');
	$('fieldset[id*="workshop-"]').droppable({
		drop: function (event, ui) {
			alert('data drop');
			newSessionFromTemplate(event, ui);
		}
	}).css('background-color', 'yellow')
}

function bindStartDateChangeBehavior() {
	
	$('input[id*="FirstDay-"]')
		.on('focus', function(e) {
			$(e.currentTarget).data('original_date', new Date($(e.currentTarget).val()))
		})
		.on('change', function(e) {
			var current = bindery_page.fragment[$(e.currentTarget).attr('id')];
			current.date = new Date($(e.currentTarget).val());
			var original = {'date': $(e.currentTarget).data('original_date')};
			var delta = current.date - original.date;
			// this assumes one WorkshopSession record, one set of Date records linked to it, 
			// and no field-name overlaps with other tables
			var change_fields = ['last_day', 'date'];
			
			var last_day = bindery_page.record[current.uuid].last_day;
			last_day.date = new Date((+(new Date(last_day.value))) + delta);
			//+(new Date()) + (1000 * 60 * 60 * 24 * 7)
			last_day.value = last_day.date.toDateString();
//			last_day.value = last_day.date.getFullYear() + '-' + last_day.date.getMonth() + '-' + last_day.date.getDate();
		})
}
/**
 * Create a new Workshop Session from the template of a previous session
 * 
 * This process is destructive to any data in the form. 
 * 
 * @param {droppable} event
 * @param {draggable} ui
 */
function newSessionFromTemplate(event, ui){
	$(ui.draggable).css('top', '5px').css('left', '10px');
	
	// make convenience vars for template data, Session inputs and Date records
	var template = provider.sessions[$(ui.draggable).data('uuid')].data;
	var destination = bindery_page.record[$(event.target).data('uuid')];
	var date_records = null; // define the pointer here
	
	// clone out the workshop session record
	// clone out the date records

	// analize the dates appropriate to this session
	// set the assumed date inputs
	
	p = null;
	for (p in template) {
		if (typeof(template[p]) === 'string') {
//			destination[p].node.val(template[p]);
			if (destination[p] !== undefined && p !== 'id') {
				destination[p].value = template[p];
			}			
			alert('p='+p);
			alert('val='+template[p]);
		}
	}
	alert(ui);
}
