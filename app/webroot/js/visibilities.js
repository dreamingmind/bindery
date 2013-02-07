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
    
    // click function for top level
    // to reveal the list of Collection
    // in the menu
    function initializeBlogCollectionsReveal(){
        $('#collections').each(function(){
            var target = $(this).attr('id');
            $(this).bind('click',function(e){
                e.preventDefault();
                $('.'+target).toggle(50);
            })
//                alert($(this).html());
        })
    }
    
    // In blog menu, once Collections are showing
    // clicking on one must reveal its articles
    function initializeBlogArticleReveal(){
        $('.collection').each(function(){
            var target = $(this).attr('id');
            $(this).find('li').each(function(){
                if($(this).attr('class') != 'article'){
                    $(this).bind('click',function(e){
                        e.preventDefault();
                        $('.'+target).toggle(50);
                        e.stopPropagation();
                    })
                }
//                alert($(this).html());
            })
        })
    }
    
    // prevent click propagaion from aricles!
    function allowArticleClick(){
        $('.article').find('a').each(function(){
            $(this).bind('click',function(e){
//                e.allowDefault();
                e.stopPropagation();
            })
        })
    }
    
    function compressBlogTOC() {
        $('.title_list').css('display','none');
    }
    
    $('ul.thumbList').bind('mouseleave',hidePN);
    
    hidePN();
    initializeBlogCollectionsReveal();
    initializeBlogArticleReveal();
    allowArticleClick();
});