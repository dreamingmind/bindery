$(document).ready(function(){
function initForm (){
    // var requestform = $('#featuredSession').html();
    // $(requestform).html($(requestform).find('legend').html('bill'));
    // alert (requestform);
$('legend').text(
$('input#WorkshopHeading').val() + ' workshop');
var datereqblock = $('input#WorkshopHeading').parent().html();
var drboutput=datereqblock.replace('type="text"','type="hidden"').replace('<label for="WorkshopHeading">Heading</label>','');
$('input#WorkshopHeading').parent().html(drboutput);
$('#WorkshopRequestForm').css('display','none');
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
    $(this).before($('#WorkshopRequestForm'));
    $('#WorkshopRequestForm').css('display','block');
    $('#WorkshopRequestForm legend').html($(this).parent().attr('heading'));
    $('#WorkshopHeading').attr('value',$(this).parent().attr('heading'));
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