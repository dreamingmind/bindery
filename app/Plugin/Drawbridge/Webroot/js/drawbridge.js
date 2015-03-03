$(document).ready(function(){
   bindHandlers(); 
});

/**
 * Forgot password handler
 */
function forgotPassword() {
    var data = $('form').serialize();
    $.ajax({
        type: "POST",
        dataType: "JSON",
        data: data,
        url: webroot + 'drawbridge/drawbridges/forgotPassword',
        success: function (data) {
			if(data.result){
            alert('We succeeded');
		} else {
			$('div#detail').prepend(data.flash);
			bindHandlers();
			initToggles();
			
		}
        },
        error: function (data, result, error) {
            alert('Result: ' + result);
            alert('Error: ' + error);
            alert('We failed');
        }
    })
}