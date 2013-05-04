$(document).ready(function(){
    
    /**
     * establish starting indicator flags in the Master area
     * these show when individual settings diverge from
     * displayed master field values
     */
    $('#ImageDispatch').after('<span id="ContentCollectionCollectionId" class="MasterCollection individualFlag"> Individual settings vary</span>');
    $('#ImageHeading').after('<span id="ContentHeading" class="MasterHeading individualFlag"> Individual settings vary</span>');
    $('label[for="ImageMasterTreatmentClone"]').append('<span id="ContentId" class="MasterTreatment individualFlag"> Individual settings vary</span>');
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
        $('.fieldsets').find('input:not([type="radio"])').each(function(){
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
        
        // do the treatment radio buttons
        $('input[type="radio"]').each(function(){
            if($(this).attr('id').match(/master/i) != null){
                $(this).bind('change', function(){
                    if($(this).attr('id').match(/clone/i) != null){
                        // clicked master clone radio button
                        $('.individualTreatment input[value="clone"]').attr('checked','checked');
                        $('div[similar="ContentId"]').find('input').each(function(){
                            $(this).val('');
                            $(this).trigger('change');
                        });
                    } else {
                        // clicked relink or ignore master treatment button
                        $('.individualTreatment input[value="'+$(this).val()+'"]').attr('checked','checked');
                        $('div[similar="ContentId"]').find('input').each(function(){
                            doFieldReset($(this));
//                            $(this).val($(this).attr('reset'));
                            $(this).trigger('change');
                        });
                    }
                }) // end of MASTER radio button initializaton
            } else {
                // These are the individual treatment settings
                $(this).bind('change',function(){
                    var recordIndex = $(this).attr('id').match(/[0-9]+/);
                    var input = $('#'+recordIndex+'ContentId');
                    if($(this).attr('id').match(/clone/i) != null){
                        //clicked individual clone radio button
                        input.val('').trigger('change');
                    } else {
                        doFieldReset(input);
//                            $(this).val($(this).attr('reset'));
                        $(input).trigger('change');
                    }
                });
            }
        })
    }
    
     /**
     * If the field is different than its original value
     * make the label a reset tool. If the field value
     * matches the original value show a default label
     */
    function fieldChanged(field){
        //master fields have no numeric index
        var master = $(field).attr('class').match(/master/) != null;
        var label = $('label[for="'+$(field).attr('id')+'"]');
        if(!master){
            var recordIndex = parseInt(field.attr('id').match(/[0-9]+/));
        }
        if($(field).val() == $(field).attr('reset')){
            var labelText = $(label).text();
            $(label).text(labelText.replace('*',''))
                .unbind('click')
                .attr('title','')
                .css('cursor','auto')
                .css('color','black');
//                $('#'+recordIndex+'changed').val(function(){
//                    return  this.value - 9;
//                });
                masterFlagManagement(field);
        } else if($(label).css('color') != 'red') {
            //Only evaluate if this field wasn't previously changed
            $(label).text('*'+$(label).text())
                .bind('click',resetClick)
                .attr('title','Click to reset')
                .css('cursor','pointer')
                .css('color','red');
            if(!master){
                $('#'+recordIndex+'changed').val(function(){
                    return (parseInt(this.value) + 1);
                });
            }
            masterFlagManagement(field);
        }
    }
    
    
    function masterFlagManagement(field){
        if($(field).parent().attr('sync')){
            // if we have a field that can be set from master
            // do this scan, otherwise, bug out
            var similar = $(field).parent().attr('similar');
            var similarInputs = $('div[similar="'+similar+'"] input');
            var toChange = similarInputs
                .filter(function(){
                    return this.value.match(/[0-9]+/);
                });
            var recordIndex = parseInt(field.attr('id').match(/[0-9]+/));

            if(similar == 'ContentId'){
            // when the Content.id changes, analyze the set so master-block can be sync'd
            // Content.id is set by the Treatment radio button set, but it's used
            // as the trigger for flagging rather than the radio set
                if(toChange.length == 0){
                    //no IDs have values
                    $('#'+similar).css('display','none')
                    $('#ImageMasterTreatmentClone').attr('checked','checked');
                    // Now sync the individual radio button knowing it should be 'clone'
                    // Probably that radio triggered this and is ok, but just in case
                    // the user hand tweaked the id...
                    $('#Content'+recordIndex+'TreatmentClone').attr('checked','checked');
                } else if(similarInputs.length == toChange.length){
                    //all IDs have values
                    $('#'+similar).css('display','none')
                    if($('#ImageMasterTreatmentClone').attr('checked')){
                        $('#ImageMasterTreatmentRelink').attr('checked','checked');
                    }
                    // Now sync the individual radio button knowing it should be 'relink' or 'dont change'
                    // Probably that radio triggered this and is ok, but just in case
                    // the user hand tweaked the id...
                    if($('#Content'+recordIndex+'TreatmentClone').attr('checked')){
                        $('#Content'+recordIndex+'TreatmentRelink').attr('checked','checked');
                    }
                } else if(similarInputs.length > toChange.length){
                    //some but not all IDs have values
                    $('#'+similar).css('display','inline-block')
                    // Now sync the individual radio button
                    // Probably that radio triggered this and is ok, but just in case
                    // the user hand tweaked the id...
                    if($('#Content'+recordIndex+'TreatmentRelink').attr('checked') 
                            && field.attr('value') == ''){
                        $('#Content'+recordIndex+'TreatmentClone').attr('checked','checked');
                    } else if($('#Content'+recordIndex+'TreatmentClone').attr('checked') 
                            && field.attr('value') != ''){
                        $('#Content'+recordIndex+'TreatmentRelink').attr('checked','checked');
                    }
                }
            } else if(similar == 'ContentHeading'){
//                alert(similar);

            } else if(similar == 'ContentCollectionCollectionId'){
//                alert(similar);
            }

            // find all similar that match master setting
            // if count of found == total count of similar
            // hide the flag span
            // in every other case, show the flag span
        }
    }
        
    /**
     * Function to restore a field to its original value
     * then determine the proper state of its label
     */
    function resetClick(){
//        var input = $('label[for="'+$(field).attr('id')+'"]');
        var input = $('#'+$(this).attr('for'));
        doFieldReset(input);
//        $(input).val($(input).attr('reset')).trigger('change');
//        fieldChanged(input);
//        
//        var recordIndex = parseInt($(this).attr('for').match(/[0-9]+/));
//        $('#'+recordIndex+'changed').val(function(){
//            alert(this);
//            return  this.value - 1;
//        });
//        alert($(this).text());
    }
    
    function doFieldReset(input){
        if($(input).val() != $(input).attr('reset')){
            $(input).val($(input).attr('reset')).trigger('change');
            fieldChanged(input);

            var recordIndex = parseInt($(input).attr('id').match(/[0-9]+/));
            $('#'+recordIndex+'changed').val(function(){
    //            alert(this);
                return  this.value - 1;
            });
        }
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