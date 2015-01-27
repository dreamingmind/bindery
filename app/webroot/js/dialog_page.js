
// This is the 'Class' definition
// it has methods and could have properties too
var contact_mediator = {
		
		prop : false,
		
	// stand in for a __constructor()
	init : function() {
		// put all the elements on the page under control of the mediator
		$('*').each(function() {
		// or $('.widgit').each(function() {
			$(this).on('click', function(e){
				contact_mediator.click(e, this);
			}),
			$(this).on('change', function(e){
				contact_mediator.change(e, this);
			})
		})
	},
	
	// click event behaviors
	click : function (e, element) {
		switch ($(element).attr('id')) {
			case 'action':
				contact_mediator.clickAction(e, element);
				break;
			case 'something':
				contact_mediator.clickAction(e, element);
				break;
			default:
				// anything not handled will fall through without action
				return;
		}
	},
	
// change event behaviors
	change : function (e, element) {
		switch ($(element).attr('id')) {
			case 'something':
				contact_mediator.changedSomething(e, element);
				break;
			default:
				// anything not handled will fall through without action
				return;
		}
	},
	
	// sample stub of concrete behavior
	changedSomething : function(e, element) {
		alert('changed : ' + $(element).attr('id'));
	},
	
	// sample stub of concrete behavior
	clickAction : function(e, element) {
		alert('clicked : ' + $(element).attr('id'));
	}
	
}

// This is outside the 'Class'
// and serves as the instantiation of the object
$(document).ready(function(){
	contact_mediator.init();
})

