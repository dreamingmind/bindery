function indicator_show(indicatorid) {
	$('#'+indicatorid).show();
}
function indicator_hide(indicatorid) {
	$('#'+indicatorid).hide();
}
function show_pictures() {
    name = $(this).attr('name');
    base = $(this).attr('base');
    thediv = $('#'+base).html();
    indicator_show(base+'indicator');
    $.ajax({
        url: '/bindery/dispatches/show_pictures/' + name,
        dataType: 'html',
        update: $('#'+base).html(),
        success: function(data,textStatus) {
            if ($('#'+base).html()==''){
                $('#'+base).prev().prev().html('Hide pictures');
                $('#'+base).html(data);
            } else {
                $('#'+base).prev().prev().html('Show pictures');
                $('#'+base).html('');
            }

            indicator_hide(base+'indicator');
        }
    });
    indicator_hide(base+'indicator');
}
function upload_alt() {
    base = $(this).attr('base');
    thediv = $('#'+base).html();
    indicator_show(base+'indicator');
    $.ajax({
        url: '/bindery/dispatches/upload_alt/',
        dataType: 'html',
        update: $('#'+base).html(),
        success: function(data,textStatus) {
            if ($('#'+base).html()==''){
                $('#'+base).prev().prev().html('Close form');
                //$();
                $('#'+base).html(data);
            } else {
                $('#'+base).prev().prev().html('Upload new file');
                $('#'+base).html('');
            }

            indicator_hide(base+'indicator');
        }
    });
    indicator_hide(base+'indicator');
}
function new_image_record() {
    var base = $(this).attr('base');
    var name = $(this).attr('name');
    var number = $(this).attr('number');
//    alert(exifData[base].FILE.FileName);
//    alert(exifData[base].FILE.MimeType);
    var divid = '#'+base;
    var thediv = $(divid).html();
    var pictarget = $(divid+'image');
    //indicator_show(base+'indicator');
    $.ajax({
        url: '/bindery/dispatches/new_image_record/'+name+'/'+number,
        dataType: 'html',
        update: $(divid).html(),
        success: function(data,textStatus) {
            if ($(divid).html()==''){
                $(divid).prev().prev().html('Close form');
                $(divid).html(data);
                //alert($('.name',data).val()+ " " + base + ' done');
                $('.name',$('#'+base)).val(exifData[base].FILE.FileName);
                $('.type',$('#'+base)).val(exifData[base].FILE.MimeType);
                $('.size',$('#'+base)).val(exifData[base].FILE.FileSize);
                $('.image_created',$('#'+base)).val(exifData[base].EXIF.DateTimeOriginal);
                $('.height',$('#'+base)).val(exifData[base].COMPUTED.Height);
                $('.width',$('#'+base)).val(exifData[base].COMPUTED.Width);
                $('.html_size',$('#'+base)).val(exifData[base].COMPUTED.html);

                pictarget.attr('src', '/bindery/img/dispatches/upload/'+name);
                $(pictarget).show();
            } else {
                $(divid).prev().prev().html('New record data');
                $(divid).html('');
                pictarget.attr('src','');
                $(pictarget).hide();
            }

            //indicator_hide(base+'indicator');
        }
    });
    //indicator_hide(base+'indicator');
}
function setupDisallowedScripts(){
    $('.uploadAltButton').each(function(){$(this).click(upload_alt)});
}
function setupDuplicateScripts(){
    $('.showPicturesButton').each(function(){$(this).click(show_pictures)});
}
function setupNewFileScripts(){
    $('.newRecordButton').each(function(){$(this).click(new_image_record)});
}
setupDisallowedScripts();
setupDuplicateScripts();
setupNewFileScripts();

