$(document).ready(function(){
   $('#ContentEditExhibitForm button.edit').bind('click',function(){
       if(this.innerHTML == 'Edit'){
           loadEditForm($(this));
       } else {
           cancelEditForm($(this));
       }
   });
   
   function loadEditForm(button){
       path = location.pathname.replace(/products\/[\S]+/,'contents/edit_exhibit/'+$('#ContentEditExhibitForm').attr('content_id'));
       button.html('Cancel');
       $('.formContent').append().load(path,function(){
           toggleFieldsets();
           enableSubmit();
       });
//       toggleFieldsets();
   }
   
   function cancelEditForm(button){
       path = location.pathname.replace(/products\/[\S]+/,'contents/edit_exhibit/'+$('#ContentEditExhibitForm').attr('content_id'));
       button.html('Edit');
       $('.formContent').html('');

   }
   
   function toggleFieldsets(){
       $('legend').each(function(){
           $(this).bind('click',(function(){
               $('.'+$(this).attr('id')).toggle(50, function(){
                   //Animation complete.
               })
           }))
       })
   }
   
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
   
//   $('#{$fieldset->unique}').click(function() {
//      $('.{$fieldset->unique}').toggle(50, function() {
//      // Animation complete.
//      });
//   });

});