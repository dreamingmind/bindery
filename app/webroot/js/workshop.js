$(document).ready(function(){
function initForm (){
    // var requestform = $('#featuredSession').html();
    // $(requestform).html($(requestform).find('legend').html('bill'));
    // alert (requestform);
$('legend').text(
$('input#RequestWorkshopName').val() + ' workshop');
var datereqblock = $('input#RequestWorkshopName').parent().html();
var drboutput=datereqblock.replace('type="text"','type="hidden"').replace('<label for="RequestWorkshopName">Heading</label>','');
$('input#RequestWorkshopName').parent().html(drboutput);
$('#RequestRequestForm').css('display','none');
$('.requesttoggle').clone().appendTo('.linkDiv');
$('.requesttoggle').bind('click',function (e){
  e.preventDefault();
  if ($(this).siblings('form').length != 0){
    if ($(this).siblings('form').css('display')=='none'){
      $(this).siblings('form').css('display','block');
    }else {
      $(this).siblings('form').css('display','none');
    }
  }else {
    //insert logic here to handle a different position between featured and standard sessions
    $(this).before($('#RequestRequestForm'));
    $('#RequestRequestForm').css('display','block');
    $('#RequestRequestForm legend').html($(this).parent().attr('heading'));
    $('#RequestWorkshopName').attr('value',$(this).parent().attr('heading'));
  }
  // $(this).siblings('form').toggle();
})
}
function initRequestClicks (){
// $('.requesttoggle').clone().appendTo('.linkDiv');
}

initForm();
initRequestClicks();

});