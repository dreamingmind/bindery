$(document).ready(function(){
  
    /**
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
    
    function manage_images(){
        $('.markdown').find('img').each(function(){
//            alert($(this).attr('src'));
            $(this).bind('mouseover', function(){
                parentclass=$(this).parent().parent().attr('class').match(/x[0-9]+y[0-9]+/);
                $(this).attr('src',$(this).attr('src').replace(/x[0-9]+y[0-9]+/,parentclass));
//                alert($(this).parent().parent().attr('class'));
            });
            $(this).bind('mouseleave',function(){
                $(this).attr('src',$(this).attr('src').replace(/x[0-9]+y[0-9]+/,'x160y120'));
            })
        });
    }
    
    manage_href_target();
    manage_images();

})