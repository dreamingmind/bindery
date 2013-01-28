$(document).ready(function(){
  
    /**
     * Initialize Markdown links
     * Make <a> tags with foreign destinations open a new window
     * 
     * Markdown allows links but no target parameter
     * So, for hrefs that start with http://, add 
     * a target = "_blank". All other hrefs can be left
     * as is. It's not clear where the markdown blocks that
     * need management will be, so add selector filters
     * rather than raking the whole page
     */
    
    function manage_href_target(){
        $('.markdown').find('a').each(function(){
            if ( $(this).attr('href').match(/http/) != null ) {
                $(this).attr('target','_blank');
            }
        });
    }
    
    /**
     * Initialize the mouseover-zoom for Markdown inline images on Blog page
     */
    function manage_images(){
        $('.markdown').find('img').each(function(){
//            alert($(this).attr('src'));
            $(this).bind('mouseover', hoverZoomIn);
//            $(this).bind('mouseleave', hoverZoomOut);
        });
    }
    
    /**
     * The mouseover-zoom function for Mardown inline images (blog page)
     */
    function hoverZoomIn(e){
        parentclass=$(this).parent().parent().attr('class').match(/x[0-9]+y[0-9]+/);
        x = new String(parentclass).match(/x[0-9]+/);
        x = new String(x).replace(/x/,'');
        x = new Number(x);

        y = new String(parentclass).match(/y[0-9]+/);
        y = new String(y).replace(/y/,'');
        y = new Number(y);
        var p = $(this);
        
        var offset = p.position();
        var left = offset.left-(x-160)+5;

        zoomed = $(this)
            .clone(false).bind('mouseleave',hoverZoomOut)
            .attr('src',$(this).attr('src').replace(/x[0-9]+y[0-9]+/,parentclass))
            .attr('id','zoomed')
            .attr('class','zoomed')
            .css('top',offset.top-((y-120)/2))
            .css('left',(left < 0)?0:left)
            .css('z-index',100);
        zoomed.insertBefore($(this).prev());
        $(this).prev('menu').css('display','none');
//        alert('X=' + e.pageX + 'Y=' + e.pageY);
    }
    
    /**
     * Reverse the mouseover-zoom on Mardown inline images (blog page)
     */
    function hoverZoomOut(){
        $(this).next(menu).css('display','block');
        $('.zoomed').remove();
    }
    
    /**
     * Initialize the Markdown inline images with a visual cue of mouseover-zoom (blog page)
     */
    function addHoverZoomMarker(){
        menu = $('<menu>').attr('class','local_zoom hover_zoom').html('<a class="local_scale_tool">&larr;</a>');
        menu.insertBefore($('.markdown').find('img'));
//        $('menu.hover_zoom').bind('mouseover',function(){
//            $(this).next('img').trigger('mouseover');
//            $(this).prev('img').trigger('mouseleave');
//        })
    }
    
    manage_href_target();
    addHoverZoomMarker();
    manage_images();

})