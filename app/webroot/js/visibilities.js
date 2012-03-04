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
        $('.previousButtons a img').fadeTo(100,1);
    });
    
    $('.nextButtons').bind('mouseover', function(){
        $('.nextButtons a img').fadeTo(100,1);
    });
    
    function hidePN(){
        $('.previousButtons a img').fadeTo( 'slow', 0);
        $('.nextButtons a img').fadeTo( 'slow', 0);
    }
    
    $('ul.thumbList').bind('mouseleave',hidePN);
    
    hidePN();
});