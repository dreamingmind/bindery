$(document).ready(function(){
    
    // initials filter checkboxes
    $('.filters input[type="checkbox"]').attr('checked','checked').bind('change', function(){
        if($(this).attr('checked')){
            setting = 1;
        } else {
            setting = .35;
        }
            $('.'+$(this).attr('id')).css('opacity',setting);
    });
        
}) 