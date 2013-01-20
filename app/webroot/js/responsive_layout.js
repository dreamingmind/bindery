$(document).ready(function(){
    
    var size_swaps = {"p":{"x1000y750":"x1000y750","x800y600":"x1000y750","x640y480":"x800y600","x500y375":"x640y480","x320y240":"x500y375","x160y120":"x320y240","x75y56":"x160y120"},"m":{"x1000y750":"x800y600","x800y600":"x640y480","x640y480":"x500y375","x500y375":"x320y240","x320y240":"x160y120","x160y120":"x160y120","x75y56":"x75y56"}};

    /**
     * Assign + and - click functions for blog page image size change
     */
    $('.zoom a.scale_tool').each(function(){
        $(this).bind('click', function(){
            resizeImages($(this).html());
        })
    });
    

    $('.local_zoom').each(assignLocalZooms, $(this).attr('id'));
        
    function assignLocalZooms(index, menu){
//        l_zoom = $('.local_zoom');
//        id = $(l_zoom[index]).attr('id');
        id = $(menu).attr('id');
        $(menu).children('a').each(function(){
            $(this).bind('click', function(){
                resizeImage(this);
            })
        });
//        alert()
//        $('.'+id).each(function(){
//            alert(this.tagName);
    };

    function resizeImage(element){
        var id = $(element).parent().attr('id');
        var change = $(element).html();
        var patt = new RegExp("x[0-9]+y[0-9]+");
        var src = $('img.'+id).attr('src');
        var index = patt.exec(src);
//        alert(size_swaps.p[index]+' : '+size_swaps.m[index]);
        if (change == '+'){
            $('img.'+id).attr('src',$('img.'+id).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.p[index]+'/'));
            $('div.'+id).attr('class', id+' entryText '+ size_swaps.p[index] + ' markdown');
        } else {
            $('img.'+id).attr('src',$('img.'+id).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.m[index]+'/'));
            $('div.'+id).attr('class', id+' entryText '+ size_swaps.m[index] + ' markdown');
        }
//        alert(src);
        
    }

    /*
     * Assign function to button that invokes the Sequencing panel
     */
     
     $('a.sequence_tool').bind('click', function(){
//         $('#sequence_panel').toggle();
         if($('#sequence_panel').length == 0){
             $('menu.zoom').before('<div id="sp"></div>');
             var path = location.pathname.replace(/blog/,'sequence')
//             alert(path);
             $('#sp').load(path);
         } else {
             $('#sp').detach();
         }
     });
     

    /**
     * User controllable layout features on the blog page
     */

    function resizeImages(change){
        var patt = new RegExp("x[0-9]+y[0-9]+");
        var src = $('img.scalable').attr('src');
//        var fn_class = src.slice(src.lastIndexOf('/')+1,src.length).replace('.','-');
        var index = patt.exec(src);
//        var cls = new String(index);
        if (change == '+'){
            $('img.scalable').each(function(){
                src = $(this).attr('src');
                fn_class = src.slice(src.lastIndexOf('/')+1,src.length).replace(/\./g,'').replace(/-/g,'');
                $(this).attr('src',$(this).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.p[index]+'/'));
                $('div.'+fn_class).attr('class', fn_class+' entryText '+ size_swaps.p[index]);
            });
        } else {
            $('img.scalable').each(function(){
                src = $(this).attr('src');
                fn_class = src.slice(src.lastIndexOf('/')+1,src.length).replace(/\./g,'').replace(/-/g,'');
                $(this).attr('src',$(this).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.m[index]+'/'))
                $('div.'+fn_class).attr('class', fn_class+' entryText '+ size_swaps.m[index]);
            });
        }
        
    }

//    function resizeImage(change, cid){
////        var size_swaps = {"p":{"x1000y750":"x1000y750","x800y600":"x1000y750","x640y480":"x800y600","x500y375":"x640y480","x320y240":"x500y375","x160y120":"x320y240","x75y56":"x160y120"},"m":{"x1000y750":"x800y600","x800y600":"x640y480","x640y480":"x500y375","x500y375":"x320y240","x320y240":"x160y120","x160y120":"x160y120","x75y56":"x75y56"}};
//        var patt = new RegExp("x[0-9]+y[0-9]+");
//        var src = $('img.scalable').attr('src');
//        var index = patt.exec(src);
//        var cls = String('.'+cid);
//        if (change == '+'){
////            alert(src.replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.p[index]+'/'));
//            
//                $(cls).attr('src',$(this).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.p[index]+'/'));
//                $(cls.nextSibling).attr('class','entryText '+ size_swaps.p[index]);
////                $('.'+index).addClass(size_swaps.p[index]);
//            
//        } else {
////            alert(src.replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.m[index]+'/'));
//                $(cls).attr('src',$(this).attr('src').replace(/\/x[0-9]+y[0-9]+\//,'/'+size_swaps.m[index]+'/'))
//                $(cls.nextSibling).attr('class','entryText '+ size_swaps.m[index]);
////                $('.'+index).;
//        }
//        
//    }


});