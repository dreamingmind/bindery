$(document).ready(function(){
    
    /**
     * establish starting indicator flags in the Master area
     * these show when individual settings diverge from
     * displayed master field values
     */
    $('#ImageDispatch').after('<span id="ContentCollectionCollectionId" class="MasterCollection individualFlag"> Individual settings vary</span>');
    $('#ImageHeading').after('<span class="MasterHeading individualFlag"> Individual settings vary</span>');
    $('label[for="ImageMasterTreatmentClone"]').append('<span class="MasterTreatment individualFlag"> Individual settings vary</span>');
    $('.individualFlag').css('display','none');
    /*
    * Memorize all input initial values
    */
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
    
    /**
     * Intitialize the behaviors of all inputs
     */
    function initFieldBehaviors(){
        // Content heading behavior: Master
        $('#ImageHeading').bind('change',function(){
            $('.content > h4').text($(this).attr('value'));
            $('input[id*="ContentHeading"]').attr('value',$(this).attr('value')).trigger('change')
            fieldChanged(this);
        })
        
        // Fieldset enclosed inputs
        $('.fieldsets').find('input').each(function(){
            $(this).bind('change',function(){
                fieldChanged($(this));
                // if the collection_id is changing we need
                // to syncronize the select lists. Change tracking
                // and value-reset will all be done on this field
                // and not on the individual select lists
                if($(this).attr('name').match(/data\[[0-9]+\]\[ContentCollection\]\[collection_id\]/)){
                    scanIndividualSelect($(this).val(), $(this).parent().parent().find('select'));
                }
            });
        });
    }
    
     /**
     * If the field is different than its original value
     * make the label a reset tool. If the field value
     * matches the original value show a default label
     */
    function fieldChanged(field){
        var label = $('label[for="'+$(field).attr('id')+'"]');
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
    
    /**
     * Function to restore a field to its original value
     * then determine the proper state of its label
     */
    function resetClick(){
//        var input = $('label[for="'+$(field).attr('id')+'"]');
        var input = $('#'+$(this).attr('for'));
        $(input).val($(input).attr('reset')).trigger('change');
        fieldChanged(input);
//        alert($(this).text());
    }
    
    /**
     * Given a collection_id, set the proper select list item
     */
    function scanIndividualSelect(collection_id, selects){
        alert(collection_id);
        selects.each(function(){
            if($(this).find('option[value="'+collection_id+'"]').length == 1){
                $(this).find('option').removeAttr('selected');
                $(this).find('option[value="'+collection_id+'"]').attr('selected','selected');
            } else {
                $(this).find('option').removeAttr('selected');
                $(this).find('option[value="0"]').attr('selected','selected');
            }
        })
    }
    
    memorize();
    initFieldBehaviors();
    
});