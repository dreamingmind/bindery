$(document).ready(function(){
    
    function initDetailLinks() {
        var holdobject = $('.detaillink')
//        var newhref = new String($(holdobject).attr('href'));
//        newhref = newhref.replace('blog', 'contents/pull_detail');
//        $(holdobject).attr('href',newhref);
        $(holdobject).attr('href',$(holdobject).attr('href').replace('blog', 'contents/pull_detail'));
//        $(holdobject).text('Click me').after($(holdobject));
//        alert(newhref);
    }
    
    // overlap collection description and image
    // #detail > div#collectionIntro set position: absolute;
    // div#exhibit set position: absolute;
    // if we're have a page: param, toggle the description setup
    function initStyles(){
        if($('div#exhibit').length > 0){
            $('#detail > div#collectionIntro').css('position', 'absolute');
        } else {
            $('img#NTtopTransparent').css('height','100px');
        }
        $('div#exhibit').css('position', 'absolute');
        var uri = new String(document.location);
        $('span.show').css('cursor','pointer');
        if(uri.match(/page:/)){
            hideCollectionDescription();
        } else {
            showCollectionDescription();
        }
    }
    
    // toggle description
    // if visible, hide and say more >
    // else show and say < less
    function showCollectionDescription(){
        $('span.show').html('< less');
        $('span.show').unbind('click',showCollectionDescription).bind('click',hideCollectionDescription);
        $('#collectionIntro > p').css('display','block');
    }
    
    function hideCollectionDescription(){
        $('span.show').html('more >');
        $('span.show').unbind('click',hideCollectionDescription).bind('click',showCollectionDescription)
        $('#collectionIntro > p').css('display','none');
    }
    
//    initDetailLinks();
    initStyles();
    
})
