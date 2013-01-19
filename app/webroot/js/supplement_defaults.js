/* 
 * Used in Category/edit and Category/add
 * to manage the number of Supplement default key/value pairs
 * are in the form
 */
$(document).ready(function(){
    initializeClone();
    initializeRemove();
})

function initializeClone() {
    $('button.clone').each(function(){
        $(this).bind('click',function(){
             $(this.parentNode).clone(true).insertAfter(this.parentNode);
        })
    })
}

function initializeRemove() {
    $('button.remove').each(function(){
        $(this).bind('click',function(){
            if($('button.remove').length > 1){
                $(this.parentNode).remove();
            }
        })
    })
}
