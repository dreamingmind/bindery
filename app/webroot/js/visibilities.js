$(document).ready(function(){
    $('a.thumb img').each(function(){
        $(this).bind('mouseover', function(){
//            alert($(this).attr('popacity')
//            + '\n' + 
//            $(this).attr('nopacity'));
//            alert('hover');
            $('.previousButtons a img').fadeTo( 0, Number($(this).attr('popacity')));
            $('.nextButtons a img').fadeTo( 0, Number($(this).attr('nopacity')));
        });
    });
    
    $('.previousButtons').bind('mouseover', function(){
        $('.previousButtons a img').fadeTo(400,1);
    });
    
    $('.nextButtons').bind('mouseover', function(){
        $('.nextButtons a img').fadeTo(400,1);
    });
    
    function hidePN(){
        $('.previousButtons a img').fadeTo(700, .2);
        $('.nextButtons a img').fadeTo( 700, .2);
    }
    
    // functions to manage Blog TOC
    function intializeBlogTOC(){
        if (collections = $('.collection')){
            collections.each(function(){
                $('.'+$(this).attr('id')).hide();
                $(this).bind('click',function(){
                    compressBlogTOC();
                    $('.'+$(this).attr('id')).toggle(50, function() {
    // Animation complete.
                    })
                })
            })
        }
    }
    
    function compressBlogTOC() {
        $('.title_list').css('display','none');
    }
    
    $('ul.thumbList').bind('mouseleave',hidePN);
    
    hidePN();
    intializeBlogTOC();
});