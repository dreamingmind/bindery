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
    
    function initProductSelections(){
        $('td > input[type="radio"]').bind('click', function(){
//            alert($(this).parent().attr('class'));
        })
    }
    
    function initTableReveal(){
        // roll up the tables to start
        // and put some instructions in their toggle bar
        $('*[id*="Toggle"].toggle').each(function(){
            $('.'+$(this).attr('id')).toggle(function(){

            });
            $(this).html($(this).html() + '<span class="instruction"> (Click to expand)</span>');
            $(this).bind('click', function(){
                if($(this).children('span.instruction').html() == ' (Click to expand)'){
                    $(this).children('span.instruction').html(' (Click to collapse)<span class="normal">Choose an item below to see design options.</span>')
                    $(this).css('height', '40px');
                } else {
                    $(this).children('span.instruction').html(' (Click to expand)')
                    $(this).css('height', '20px');
                }
            })
        });
    }
    
    function initProductRadios(){
        var productCategory = $('table[class*="Toggle"]').attr('id');
        alert(productCategory);
        $('table[class*="Toggle"]').find('input[type="radio"]').bind('click', function(){
            var title = $(this).parent().attr('class').replace(/([\d])+_([\d])+/g, '$1.$2').replace(/ /g, ' - ').replace(/_/g, ' ');
            $('p.optionTitle').html(title);
            $('input[id*="Description"]').attr('value', title);
        });
    }
    
    initCheckboxes();
    initTableToggleHooks(); 
    initProductSelections();
    initTableReveal();
    initProductRadios();
})