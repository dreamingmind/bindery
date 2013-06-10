$(document).ready(function(){
    
    // initials filter checkboxes
    $('.filters input[type="checkbox"]').attr('checked','checked').bind('change', function(){
        if($(this).attr('checked')){
            $('.'+$(this).attr('id')).css('display','table-cell');
        } else {
            $('.'+$(this).attr('id')).css('display','none');
        }
          manageXXandYY();
    });
    
    function manageXXandYY(){
        var columns = $('.xx');
        columns.each(function(){
//            alert($(this).attr('class').replace('xx', '').replace(' ', ''));
            var childColumns = $('.x[style="display: table-cell;"]').filter($(this).attr('class').replace('xx', '').replace(' ', ''));
//            $('.x.'+$(this).attr('class')+'[style="dispaly: table-cell"]'.replace('xx', ''));
//            alert('columns'+childColumns.length);
        });
        var rows = $('.yy');
        rows.each(function(){
//            alert($(this).attr('class').replace('yy', '').replace(' ', ''));
            childColumns = $('.y[style="display: table-cell;"]').filter($(this).attr('class').replace('yy', '').replace(' ', ''));
//            alert('rows '+childColumns.length);
        });
    }
    
}) 