function showDetails () {
    $('#recordData'+$(this).attr('name')).show(300);
}

function hideDetails(){
    $('#recordData'+$(this).attr('name')).hide(300);
}

function showForm () {
    $('#recordForm'+$(this).attr('name')).show(300);
}

function hideForm(){
    $('#recordForm'+$(this).attr('name')).hide(300);
}

function setupReveals(){
    $('.showDetails').each(function(){$(this).click(showDetails)});
    $('.hideDetails').each(function(){$(this).click(hideDetails)});
    $('.showForm').each(function(){$(this).click(showForm)});
    $('.hideForm').each(function(){$(this).click(hideForm)});
}

function initGoTo(){
    $('#ImageUploadsets').bind('change',function(){
        var loc = new String(location);
        var upload = $('#ImageUploadsets').find(':selected').attr('value');
        loc = loc.replace(/grid[\/]*[\d]*/i,'grid/' + upload);
        location.replace(loc);
    });
}

setupReveals();
initGoTo();

function insureOneMemeberChange(){}