$(document).ready(function(){
    
    // initials filter checkboxes
    $('.filters input[type="checkbox"]').attr('checked','checked').bind('change', function(){
        if($(this).attr('checked')){
            $('.'+$(this).attr('id')).css('visibility','visible');
        } else {
            $('.'+$(this).attr('id')).css('visibility','collapse');
        }
//          manageXXandYY();
    });
        
}) 