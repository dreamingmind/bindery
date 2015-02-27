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
        dataType: "HTML",
        data: data,
        url: 'localhost' + webroot + 'drawbridge/drawbridges/forgotPassword',
        success: function (data) {
            alert('We succeeded');
        },
        error: function (data, result, error) {
            alert('Result: ' + result);
            alert('Error: ' + error);
            alert('We failed');
        }
    })
}