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
    
    initDetailLinks();
    
})
