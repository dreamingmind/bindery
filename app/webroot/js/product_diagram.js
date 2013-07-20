$(document).ready(function(){
    
    function DiagramDiv(div){
        var x = parseInt($(div).css('width'));
        var y = parseInt($(div).css('height'));
        var z = $(div).children('div').length;
        this.width = function(){ return x };
        this.height = function(){ return y };
        this.layers = function(){ return z };
        this.toString = function(){
            return 'The DIV is ' + this.width() + 'px wide, ' + this.height() + 'px tall, and contains ' + this.layers() + ' layers.';
        }
    }
    
    diagram = new DiagramDiv($('div#diagram'));
    
    alert(diagram.toString());
})
