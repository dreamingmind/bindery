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

setupReveals();

function insureOneMemeberChange(){}