$(document).ready(function(){
    
    // initials filter checkboxes
    $('.filters input[type="checkbox"]').attr('checked','checked').bind('change', function(){
        var product = $(this).attr('category');
//        alert(product);
        if($(this).attr('checked')){
            setting = 1;
        } else {
            setting = .35;
        }
//            $('.'+$(this).attr('id')).css('opacity',setting);
            $('.'+product+'.'+$(this).attr('id')).css('opacity',setting);
    });
    
    $('table').each(function(){
        var id = $('tr[class="table"] > td').attr('id');
        $(this).find('tr[class!="table"]').attr('class',id);
    })
})