$(document).ready(function(){
    
    /**
     * Bind clicks to the Edit button to toggle the form in and out of the page
     * Also lay the reference grid over the Exhibit picture
     * 
     * ContentEditDispatch/487Form
     * is the id
     * we need a class to get them all and walk through them
     */
   $('#ContentEditExhibitForm button.edit').bind('click',function(){
       if(this.innerHTML == 'Edit'){
           loadEditForm($(this));
           $('#reference-grid').css('background','url("/bindery/img/exhibit-grid.png") repeat scroll 0 0 transparent');
       } else {
           cancelEditForm($(this));
           $('#reference-grid').css('background','none');
       }
   });
   
   /**
    * This is the action on clicking the Edit button
    * Change the button to read Cancel
    * Construct path to the ajax form and bring it in
    * Intialize the Fieldset toggling
    * Enable the Submit button in the new form
    * Make the Supplement fieldset live-update the page
    */
   function loadEditForm(button){
       path = location.pathname.replace(/products\/[\S]+/,'contents/edit_exhibit/'+$('#ContentEditExhibitForm').attr('content_id'));
       button.html('Cancel');
       $('.formContent').append().load(path,function(){
           toggleFieldsets();
           enableSubmit();
           enableSupplementUpdates();
       });
//       toggleFieldsets();
   }
   
   /**
    * This is the action on clicking Cancel
    * Make the button read Edit
    * Dump the form
    */
   function cancelEditForm(button){
//       path = location.pathname.replace(/products\/[\S]+/,'contents/edit_exhibit/'+$('#ContentEditExhibitForm').attr('content_id'));
       button.html('Edit');
       $('.formContent').html('');

   }
   
   /**
    * This is the function to toggle the fieldsets open and closed
    */
   function toggleFieldsets(){
       $('legend').each(function(){
           $(this).bind('click',function(){
               $('.'+$(this).attr('id')).toggle(50, function(){
                   //Animation complete.
               })
           })
       })
   }
   
   /**
    * The Submit button
    * Post the data
    * Receive an all new age body and swap it in
    */
   function enableSubmit(){
       $('#editExhibitSubmit').bind('click',function(){
            $.post(
                location.pathname.replace(/products\/[\S]+/,'contents/edit_exhibit/'+$('#ContentEditExhibitForm').attr('content_id')),
                $('#ContentEditExhibitForm').serialize(),function(data){
                    $('body').html(data);
                }
            );
       })
   }
   
   /**
    * These next two funtions are too specific to the Exhibit setup I have
    * Some method for absracting the use of supplement data would be good
    * 
    * This first function binds the action for change
    */
   function enableSupplementUpdates(){
       $('.live_update').each(function(){
           $(this).bind('change',function(){
//               alert('new value '+ this.value);
               showSupplementChange(this);
               //do I want to find some way of identifying which category to process?
           })
       })
   }
   
   /**
    * Decide what data changed and update the page in the proper way
    * so the editor can see the effect of the new data
    */
   function showSupplementChange(input){
       id = $(input).attr('id');
       target = $('.'+id).val();
       setting = $('#'+id).val();
       if (target == 'headstyle' || target == 'pgraphstyle'){
           $('.proseblock'+target).attr('id',setting);
       } else {
           target = target.replace(/_val/,'');
           $('#proseblock').css(target,setting+'px');
//           alert(target);
       }
//        
   }
   
   
//   $('#{$fieldset->unique}').click(function() {
//      $('.{$fieldset->unique}').toggle(50, function() {
//      // Animation complete.
//      });
//   });

});