$(document).ready(function(){
        
    //Walk through thumbnails setting click function
    $('.thumb_link').each(function(){
        $(this).bind('click', function(){
            setPrevNextImageLinks($(this).attr('href'));
            clearActiveThumb();
            $(this.parentNode).addClass('active');
        })
    });
    
//    //Set click for previous image button
    $('.thumb_previous_image').bind('click', function(event){
        event.preventDefault();
        uri = $('.thumb_previous_image').attr('href');
        window.open(uri,'_self', '');
        index = uri.match(/id[0-9]+/)
        setPrevNextImageLinks(uri);
        setThumbFromURI(uri);
    });
   
//    //Set click for next image button
    $('.thumb_next_image').bind('click', function(event){
        event.preventDefault();
        uri = $('.thumb_next_image').attr('href');
        window.open(uri, '_self', '');
        setPrevNextImageLinks(uri);
        setThumbFromURI(uri);
    });
    
    //set active thumb on entry from uri
    //or to first thumbnail if no uri indicator
    function setThumbFromURI(uri){
        if(uri==null){
            uri = document.documentURI;
        }
        var patt = new RegExp(document.domain);
        uri = uri.replace(/http:\/\//,'').replace(patt,'');
        clearActiveThumb();
        
        if(uri.match(/#id[0-9]+/)){
            ab = uri;
        } else {
            ab = $('.thumb_link:first').attr('href');
        }
        
        $('.thumb_link[href='+ab+']').parent().addClass('active');
    };

    //Set proper next/prev image links from a passed uri
    function setPrevNextImageLinks(uri){
        if(uri==null){
            uri = document.documentURI;
        }
        var patt = new RegExp(document.domain);
        uri = uri.replace(/http:\/\//,'').replace(patt,'');
        index = uri.match(/id[0-9]+/);
        $('.thumb_previous_image').attr('href', uri
            .replace(/page:[0-9]+/, 
            'page:'+collectionPage[index].neighbors.previous_page)
            .replace(/#id[0-9]+/, 
            '#id'+ collectionPage[index].neighbors.previous));
        $('.thumb_next_image').attr('href', uri
            .replace(/page:[0-9]+/, 
            'page:'+collectionPage[index].neighbors.next_page)
            .replace(/#id[0-9]+/, 
            '#id'+ collectionPage[index].neighbors.next));
    }
    
    //clear the active thumb styling
    function clearActiveThumb(){
        if($('.thumbList li.active').html()!= null){
            $('.thumbList li.active').removeClass('active');
        }
    };
    
    //Entering the page. Highlight something
//    cp(); //try to insure the content collection json data is ready when the scripts run
    setThumbFromURI(document.documentURI);    
    setPrevNextImageLinks(document.documentURI);
    
});
