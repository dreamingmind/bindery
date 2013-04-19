$(document).ready(function(){
function initRequestClicks (){
    requestform = $('#featuredSession').html();
    $(requestform).find('legend').text('bill');
    alert (requestform);

}

initRequestClicks();

});