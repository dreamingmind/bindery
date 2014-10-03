/**
 * Tools to keep all the inputs on content_collection in sync
 * 
 * Since there are typically 2 inputs that can be used to set
 * a field value (one master-set input and one individual-record input)
 * AND a third input which is the actual $this->data[blah], there is
 * a lot of potential for irrational page content.
 * 
 * The basic plan:
 *      - The data field change-event does the work of coordinating the 
 *        other page elements.
 *      - A field which must do this work is in a div with attribute
 *        'sync' which indicates the process must be done, and an
 *        attribute 'similar' which provides a way to locate all the 
 *        this field in the other records, and a <span> on the master
 *        field that will display info about the master field setting
 *        matches all the individual fields
 *      - When a data field changes, it gets a reset clicker on its
 *        label so it can be restored
 *      - When all matching fields come into allignment (same values)
 *        the master input is set to match. Otherwise the master's
 *        <span> tells things are based on individual/local settings
 *      - When a field changes it sets it own individual/local tool
 *        to match its value
 *        
 *      - So using a master or individual/local input, reaches in to 
 *        set the data field and the data field change-event reaches
 *        back up to sync all the associated inputs
 *        
 *      - Adding a recordIndex attribute would make it much easier
 *        to associate the individual/local inputs and their
 *        associated data fields.
 *        
 * The View is a bit of a mess. And this code is ineficient too.
 * There are some bugs related to multiple changes on collection_id.
 * This might clear up if I took the hard-coded UUID's out of 
 * the Fieldset Helper. It's only there to make the toggle work and
 * I can probably find a better way of doing that now.
 * 
 * Also, I set a 'reset' value on all my inputs but it appears
 * there is already a defaultValue property on them that will make
 * this unnecessary.
 * 
 * Use document.location.pathname to add alternative action
 * attributes to the submit button so, after submitting and 
 * processing the data we can come back to this page on the 
 * new article or the old
 */

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
            $(this).parent().attr('reset',$(this).val());
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
            $('.content > h4').text($(this).val());
            $('input[id*="ContentHeading"]').val($(this).val()).trigger('change')
            fieldChanged(this);
        })
        
        $('textarea').bind('change', function(){
            fieldChanged($(this));
        })
        // Fieldset enclosed inputs
        $('.fieldsets').find('input:not([type="radio"])').each(function(){
            $(this).bind('change',function(){
//                var recordIndex = $(this).attr('name').match(/[0-9]+/);
                fieldChanged($(this));
                // if the collection_id is changing we need
                // to syncronize the select lists. Change tracking
                // and value-reset will all be done on this field
                // and not on the individual select lists
//                if($(this).attr('name').match(/data\[[0-9]+\]\[ContentCollection\]\[collection_id\]/)){
//                    scanIndividualSelect($(this).val(), $('#'+recordIndex+'Individual').find('select'));
//                }
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
        });
        
        // do the select lists
        $('select').bind('change',function(){
            if($(this).attr('name').match(/master/)){
                $('input[id*="-collection_id"]').val($(this).val()).trigger('change');
            } else {
                var recordIndex = $(this).attr('name').match(/[0-9]+/);
                $('input[name="data['+recordIndex+'][ContentCollection][collection_id]"]').val($(this).val()).trigger('change');
//                $('input[name="data['+recordIndex+'][ContentCollection][collection_id]"]').trigger('change');
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
            var recordIndex = parseInt(field.attr('name').match(/[0-9]+/));
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
                    if($(this).val() == $(this).attr('reset')){
                        return $(this);
                    };
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
                            && field.val() == ''){
                        $('#Content'+recordIndex+'TreatmentClone').attr('checked','checked');
                    } else if($('#Content'+recordIndex+'TreatmentClone').attr('checked') 
                            && field.val() != ''){
                        $('#Content'+recordIndex+'TreatmentRelink').attr('checked','checked');
                    }
                }
            } else if(similar == 'ContentHeading'){
            // when the Content.id changes, analyze the set so master-block can be sync'd
            // Content.id is set by the Treatment radio button set, but it's used
            // as the trigger for flagging rather than the radio set
                if(toChange.length == 0){
                    //no Headings have changed
                    if($('#ImageHeading').val != field.val()){
                        $('#ImageHeading').val(field.val());
                    }
                    $('label[for="ImageHeading"]').text('*Heading')
                        .bind('click',resetClick)
                        .attr('title','Click to reset')
                        .css('cursor','pointer')
                        .css('color','red');
                    $('#'+similar).css('display','none')
//                    $('#ImageMasterTreatmentClone').attr('checked','checked');
//                    $('#Content'+recordIndex+'TreatmentClone').attr('checked','checked');
                } else if(similarInputs.length == toChange.length){
                    //all Headings have changed
                    if($('#ImageHeading').val != field.val()){
                        $('#ImageHeading').val(field.val());
                    }
                    $('label[for="ImageHeading"]').text('Heading')
                        .unbind('click')
                        .attr('title','')
                        .css('cursor','auto')
                        .css('color','black');
                    $('#'+similar).css('display','none')
                } else if(similarInputs.length > toChange.length){
                    //some but not all Headings have changed
                    $('#'+similar).css('display','inline-block')
                }
            } else if(similar == 'ContentCollectionCollectionId'){
                var recordIndex = $(field).attr('name').match(/[0-9]+/);
                if(toChange.length == 0){
                    //no Headings have changed
                    $('#'+similar).css('display','none')
                    scanIndividualSelect($(field).val(), $('#'+recordIndex+'Individual').find('select'));
                    scanIndividualSelect($(field).val(), $('.master').find('select'));
                } else if(similarInputs.length == toChange.length){
                    //all Headings have changed
                    $('#'+similar).css('display','none')
                    scanIndividualSelect($(field).val(), $('#'+recordIndex+'Individual').find('select'));
                    scanIndividualSelect($(field).val(), $('.master').find('select'));
                } else if(similarInputs.length > toChange.length){
                    //some but not all Headings have changed
                    $('#'+similar).css('display','inline-block')
                    scanIndividualSelect($(field).val(), $('#'+recordIndex+'Individual').find('select'));
                }
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
//        alert(collection_id);
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