$(document).ready(function(){
    
    // teach the form to try to submit each time the input is changed
    $('#jumpInput').change(function(){
        $('#ContentJumpForm').submit();
    });

    // and when the form submits, only let it go
    // if the input is within the valid range
    $('#ContentJumpForm').submit(function(){
    var input = new Number($('#jumpInput').val());
    var limit = new Number($('#highJump').html());
        if(input > limit || input < 1 || input == ''){
            $('#jumpMessage').html('Out of range. ');
            $('jumpInput').focus();
            return false //this stops the submit process
        } else {
            return true; // this allows the submit to proceed
        }
    });
    
});