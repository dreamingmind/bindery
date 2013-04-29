$(document).ready(function(){
    
//    alert('Number of Change trackers '+$('input[id*="changed"]').size());
    
    // Treatment settings for individual records
    // 'dont change'.change - reset all internal values to original values
    $('.individual_treatment > fieldset').find('input').each(function(){
//        alert('Individual treatment: '+$(this).attr('id'));
    });
    
    // Memorize all input conditions
    function memorize(){
        // Radio buttons and checkboxes
        $('input').each(function(){
            if($(this).attr('type') == 'radio' || $(this).attr('type') == 'checkbox'){
                // figure out how to store 'checked' condition
                $(this).attr('reset',$(this).attr('checked'));
            } else {
                //everything else with an input tag
                $(this).attr('reset',this.value);
            }
        });
        // Select lists
        $('option[selected="selected"]').each(function(){
            $(this).parent().attr('reset',$(this).attr('value'));
        })
        // Textareas
        $('textarea').each(function(){
            $(this).attr('reset',$(this).text())
        })
    }
    
    // Restore input condition of this set of inputs
    function restoreInputValue(inputSet){
        //figure out how to do this
    }
    
    function initFieldBehaviors(){
        // Content heading behavior: Master
        $('#ImageHeading').bind('change',function(){
            if($('#ImageTreatmentIndividual').attr('checked') != true){
                $('.content > h4').text($(this).attr('value'));
                $('input[id*="ContentHeading"]').attr('value',$(this).attr('value'))
                fieldChanged(this);
            } else {
                alert('Must handle individually');
            }
        })
    }
    
    function fieldChanged(field){
        var label = $('label[for="'+$(field).attr('id')+'"]');
//        alert($(field).val());
//        alert($(field).attr('reset'));
        if($(field).val() == $(field).attr('reset')){
            var labelText = $(label).text();
            $(label).text(labelText.replace('*',''))
                .unbind('click')
                .attr('title','')
                .css('cursor','auto')
                .css('color','black');
        } else {
            $(label).text('*'+$(label).text())
                .bind('click',resetClick)
                .attr('title','Click to reset')
                .css('cursor','pointer')
                .css('color','red');
        }
    }
    
    function resetClick(){
//        var input = $('label[for="'+$(field).attr('id')+'"]');
        var input = $('#'+$(this).attr('for'));
        $(input).val($(input).attr('reset'));
        fieldChanged(input);
//        alert($(this).text());
    }
    
    memorize();
    initFieldBehaviors();
    
});