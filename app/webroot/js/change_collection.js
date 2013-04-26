$(document).ready(function(){
    
    alert('Number of Change trackers '+$('input[id*="changed"]').size());
    
    // Treatment settings for individual records
    // 'dont change'.change - reset all internal values to original values
    $('.individual_treatment > fieldset').find('input').each(function(){
//        alert('Individual treatment: '+$(this).attr('id'));
    });
    
    // Memorize all input conditions
    $('input').each(function(){
        if($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox'){
            // figure out how to store 'checked' condition
        } else if($(this).attr('type') == 'select') {
            // figure out how to store 'selected' option
        } else {
            $(this).attr('reset',this.value);
        }
    });
    
    // Restore input condition of this set of inputs
    function restoreInputValue(inputSet){
        //figure out how to do this
    }
});