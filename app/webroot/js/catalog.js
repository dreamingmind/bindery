$(document).ready(function(){
    
    // initials filter checkboxes
    $('.filters input[type="checkbox"]').bind('change', function(){
//        alert($(this).attr('checked'));
          $('.'+$(this).attr('id')).fadeToggle("slow", "linear");
//        if($(this).attr('checked')){
//            $('.'+$(this).attr('id')).css('display','table-cell');
//        } else {
//            $('.'+$(this).attr('id')).css('display','none');
//        }
    })
    
})