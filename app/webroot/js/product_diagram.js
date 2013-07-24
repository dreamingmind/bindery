$(document).ready(function(){
    
    function diagramDiv(div){
//        alert(productCategory);
        var x = parseInt($(div).css('width'));
        var y = parseInt($(div).css('height'));
        var z = $(div).children('div').length;
        alert(z);
        this.width = function(){ return x };
        this.height = function(){ return y };
        this.layers = function(){ return z };
        this.toString = function(){ return ('The DIV is ' + this.width() + 'px wide, ' + this.height() + 'px tall, and contains ' + this.layers() + ' layers.') };
    }
   
//With jQuery, you can use the data property.
//
////setting the function
//$('element').data('doSomething', function(arg) { ... });
////calling the function
//$('element').data('doSomething')(arg);


//    diagram = new DiagramDiv($('div#diagram'));
//    
//    alert(diagram.toString());
})