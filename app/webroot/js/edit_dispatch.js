$(document).ready(function(){

    /**
     * Bind clicks to the Edit button to toggle the form in and out of the page
     * Also lay the reference grid over the Exhibit picture
     */
   $('form [id*=#ContentEditDispatchForm"]').children('.edit').bind('click',function(){
       if(this.innerHTML == 'Edit'){
           loadEditForm($(this));
       } else {
           cancelEditForm($(this));
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
//       path = location.pathname.replace(/products\/[\S]+/,'contents/edit_dispatch/'+$('#ContentEditDispatchForm').attr('content_id'));
       var path = $(button).parent().attr('action');
       var id = $(button).parent().attr('content_id');
       button.html('Cancel');
       $('.formContent'+id).append().load(path,function(){
           toggleFieldsets();
           enableSubmit();
       });
//       toggleFieldsets();
   }
   
   /**
    * This is the action on clicking Cancel
    * Make the button read Edit
    * Dump the form
    */
   function cancelEditForm(button){
       var id = $(button).parent().attr('content_id');
       button.html('Edit');
       $('.formContent'+id).html('');

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
       $('#editDispatchSubmit').bind('click',function(){
            $.post(
                location.pathname.replace(/products\/[\S]+/,'contents/edit_dispatch/'+$('#ContentEditDispatchForm').attr('content_id')),
                $('#ContentEditDispatchForm').serialize(),function(data){
                    //Can I make this entry specific rather than whole-page?
                    $('body').html(data);
                }
            );
       })
   }
   

});