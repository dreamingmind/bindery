$(document).ready(function(){
//    $('a.thumb img').each(function(){
//        $(this).bind('mouseover', function(){
////            alert($(this).attr('popacity')
////            + '\n' + 
////            $(this).attr('nopacity'));
////            alert('hover');
//            $('.previousButtons a img').fadeTo( 0, Number($(this).attr('popacity')));
//            $('.nextButtons a img').fadeTo( 0, Number($(this).attr('nopacity')));
//        });
//    });
//    
//    $('.previousButtons').bind('mouseover', function(){
//        $('.previousButtons a img').fadeTo(400,1);
//    });
//    
//    $('.nextButtons').bind('mouseover', function(){
//        $('.nextButtons a img').fadeTo(400,1);
//    });
    
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
    
    function intializeRelatedButton(){
        $('button.related').bind('click',function(){
            if($('div.related').css('display') == 'none'){
                var x = this.offsetLeft;
                var y = this.offsetTop;
                var target = $('.'+$(this).attr('collection'));
                target.attr('class','open');
                target.clone().appendTo($('div.related'));
                $('div.related').css('top',y+15).css('left',x+60).css('display','inline');
            } else {
                $('div.related').css('display','none');
            }
        })
        $('div.related').bind('mouseleave',function(){
            $(this).css('display','none');
        })
    }
    
//    function compressBlogTOC() {
//        $('.title_list').css('display','none');
//    }
    
    $('ul.thumbList').bind('mouseleave',hidePN);
     
    function activeBlogMenuCheck(){
        var prefix = location.protocol+'//'+location.hostname;
        var activehref = location.href.replace(prefix, '');
        var target = $('a[href="'+activehref+'"]');
        target.parent().attr('class',target.parent().attr('class')+' active');
        if(!activehref.match('#')){
            $('ul.collection').attr('class',$('ul.collection').attr('class').replace('open','close'));
        } else {
            id = activehref.match(/\/(\d+)\//)
//            alert(id[1]);
            $('.collection'+id[1]).css('display','block').parent().css('list-style','square').children('a').css('color','black');
            $('#collections').css('list-style','square').children('a').css('color','black');
        }
    }
    
    
    hidePN();
    initializeBlogCollectionsReveal();
    initializeBlogArticleReveal();
    allowArticleClick();
    intializeRelatedButton();
    activeBlogMenuCheck();
});