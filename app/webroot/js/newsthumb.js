$(document).ready(function(){
    
    //Walk through thumbnails setting click function
    $('.thumb_link').each(function(){
        $(this).bind('click', function(){
            
            setPrevNextImageLinks($(this).attr('href'));
            clearActiveThumb();
            $(this.parentNode).addClass('active');
        })
    });
    
    //Set click for previous image button
    $('.thumb_previous_image').bind('click', function(){
      hr = $('.thumb_previous_image').attr('href');
        setThumbFromURI(hr);
        setPrevNextImageLinks(hr);
    });
    
    //Set click for next image button
    $('.thumb_next_image').bind('click', function(event){
        hr = $('.thumb_next_image').attr('href');
        setThumbFromURI(hr);
        setPrevNextImageLinks(hr);
    });
    
    //set active thumb on entry from uri
    //or to first thumbnail if no uri indicator
    function setThumbFromURI(uri){
        clearActiveThumb();
        
        if(uri.match(/#id[0-9]+/)){
            ab = uri.match(/#id[0-9]+/);
        } else {
            ab = $('.thumb_link:first').attr('href');
        }
        
        $('.thumb_link[href='+ab+']').parent().addClass('active');
    };
    
    //Set proper next/prev image links from a passed uri
    function setPrevNextImageLinks(uri){
        
        index = uri.match(/id[0-9]+/)
        
        plink = $('.thumb_previous_image').attr('href')
            .replace(/page:[0-9]+/, 
            'page:'+collectionPage[index].neighbors.previous_page)
            .replace(/#id[0-9]+/, 
            '#id'+ collectionPage[index].neighbors.previous);
            
        $('.thumb_previous_image').attr('href',plink);

        nlink = $('.thumb_next_image').attr('href')
            .replace(/page:[0-9]+/, 
            'page:'+collectionPage[index].neighbors.next_page)
            .replace(/#id[0-9]+/, 
            '#id'+ collectionPage[index].neighbors.next);
            
        $('.thumb_next_image').attr('href',nlink);
    }
    
    //clear the active thumb styling
    function clearActiveThumb(){
        if($('.thumbList li.active').html()!= null){
            $('.thumbList li.active').removeClass('active');
        }
    };
    
    //Entering the page. Highlight something
    setThumbFromURI(document.documentURI);    
    setPrevNextImageLinks(document.documentURI);
});
