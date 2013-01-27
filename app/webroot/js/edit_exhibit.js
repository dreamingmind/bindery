$(document).ready(function(){
   $('#ContentEditExhibitForm button.edit').bind('click',function(){
       if(this.innerHTML == 'Edit'){
           loadEditForm($(this));
           $('#reference-grid').css('background','url("/bindery/img/exhibit-grid.png") repeat scroll 0 0 transparent');
       } else {
           cancelEditForm($(this));
           $('#reference-grid').css('background','none');
       }
   });
   
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
   
   function cancelEditForm(button){
       path = location.pathname.replace(/products\/[\S]+/,'contents/edit_exhibit/'+$('#ContentEditExhibitForm').attr('content_id'));
       button.html('Edit');
       $('.formContent').html('');

   }
   
   function toggleFieldsets(){
       $('legend').each(function(){
           $(this).bind('click',function(){
               $('.'+$(this).attr('id')).toggle(50, function(){
                   //Animation complete.
               })
           })
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
   
   /**
    * These next two funtions are too specific to the Exhibit setup I have
    * Some method for absracting the use of supplement data would be good
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