$(document).ready(function(){

    function initCheckboxes(){
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
    }
    
    function initTableToggleHooks(){
        $('table').each(function(){
            var id = $(this).find('tr[class="table"] > td').attr('id');
            $(this).find('tr[class!="table"]').attr('class',id);
        })
    }
    
    initCheckboxes();
    initTableToggleHooks(); 
    // Roll up the tables to start
    $('*[id*="Toggle"].toggle').each(function(){
        $('.'+$(this).attr('id')).toggle(function(){
            
        });
    });
})