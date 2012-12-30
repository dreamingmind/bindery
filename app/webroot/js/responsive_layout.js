$(document).ready(function(){
    /**
     * Assign + and - click functions for blog page image size change
     */
    $('.zoom a.scale_tool').each(function(){
        $(this).bind('click', function(){
            resizeImages($(this).html());
        })
    });
    
    /*
     * Assign function to button that invokes the Sequencing panel
     */
     
     $('a.sequence_tool').bind('click', function(){
//         $('#sequence_panel').toggle();
         if($('#sequence_panel').length == 0){
             $('menu.zoom').before('<div id="sp"></div>');
             $('#sp').load('contents/sequence');
         } else {
             $('#sp').detach();
         }
     });
     

    /**
     * User controllable layout features on the blog page
     */

    function resizeImages(change){
        var size_swaps = {"p":{"x1000y750":"x1000y750","x800y600":"x1000y750","x640y480":"x800y600","x500y375":"x640y480","x320y240":"x500y375","x160y120":"x320y240","x75y56":"x160y120"},"m":{"x1000y750":"x800y600","x800y600":"x640y480","x640y480":"x500y375","x500y375":"x320y240","x320y240":"x160y120","x160y120":"x75y56","x75y56":"x75y56"}};
        var patt = new RegExp("x[0-9]+y[0-9]+");
        var src = $('img.scalable').attr('src');
        var index = patt.exec(src);
        if (change == '+'){
//            alert(src.replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.p[index]+'/'));
            $('img.scalable').each(function(){
                $(this).attr('src',$(this).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.p[index]+'/'))
            });
        } else {
//            alert(src.replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.m[index]+'/'));
            $('img.scalable').each(function(){
                $(this).attr('src',$(this).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.m[index]+'/'))
            });
        }
        
    }

});