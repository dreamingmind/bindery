    /**
     * Calculate positions and sizes for diagram parts setting page css
     */
    function diagramDiv(div, targetProduct){
        
        // analyze the diagramData left by the server
        var layers = getDiagramLayers(targetProduct);

        // prepare our main data object and intialize its core values
        var params = new Object
        params.layerNames = layers;
        params.layerCount = layers.length;
        params.div = div;
        params.targetProduct = targetProduct;
        setDiagramParams(params);
        
        for (var layer in params.layerSizes){
            alert('The div is '+params.divSize.width+' by '+params.divSize.height+'. \n\
The live area is '+params.liveArea.width+' by '+params.liveArea.height+'. \n\
Layer '+layer+' is set to '+params.layerSizes[layer]['size']['width']+'px wide and '+params.layerSizes[layer]['size']['height']+'px tall.\n\
Width offest = '+params.widthOffset+'/'+params.widthOffsetTotal+'.\n\
Height offest = '+params.heightOffset+'/'+params.heightOffsetTotal+'.\n\
There are '+params.layerCount+' layers.\n\
Margin = '+params.margin+' and 2*margin='+params.margin*2);
        }
//        alert('layer '+params.layerCount+' is '+params.layerNames[params.layerCount-1]+' and there are '+params.layerCount+' layers.');
//        alert('The div is '+params.divSize.width+' by '+params.divSize.height);
//        alert('The liveArea is '+params.liveArea.width+' by '+params.liveArea.height);
//        alert('margin = '+params.margin);
//        calculateLiveArea(liveArea);
//        var z = count;
//        var x = diagramData[targetProduct]['case']['x'];
//        var y = diagramData[targetProduct]['case']['y'];
//        alert('x='+x+' y='+y+' z='+z);
        
        
//        var layers()
    }
    
    /**
     * Scale a number by a factor
     * 
     * If round = true return an integer
     * otherwise return a float
     */
    function scaleTo(original, factor, round){
        if(typeof(round)==='undefined') round=true;
        if (round) {
            return parseInt(original * factor);
        } else {
            return original * factor;
        }
    }
    
    /**
     * Return an assembled size ojbect
     */
    function size(obj, width, height){
        obj['width'] = width;
        obj['height'] = height;
    }
    
    /**
     * return an assembled point object
     */
    function point(obj, x, y){
        obj['x'] = x;
        obj['y'] = y;
    }
    
    /**
     * calc the diagram div's baseline parameters
     * 
     * Set the margin and offset starting % values
     * Calculate the actual pixel values for both
     * Assumes the first layer is going to be the largest
     */
    function setDiagramParams(params){
        
        // establish some baseline control relationships
        params['offsetMinPercent'] = .1; // layer offset is least 10% of the container div's narrow dimension
        params['offsetMaxPercent'] = .75; // layer offset is at most 75% of the layer's size
        params['marginPercent'] = .03; // margin is 3%
        
        // create a divSize object, the diagram wrapper div
        params.divSize = new Object();
        size(params.divSize, parseInt($(params.div).css('width')), parseInt($(params.div).css('height')));
        
        // workout the actual margin in pixels
        if (params.divSize.width < params.divSize.height) {
            params['margin'] = scaleTo(params.divSize.width, params.marginPercent);
        } else {
            params['margin'] = scaleTo(params.divSize.height, params.marginPercent);
        }
        
        // set the live-area size for the div
        params.liveArea = new Object();
        size(params.liveArea, params.divSize.width - (params.margin * 2), params.divSize.height - (params.margin * 2))
        
        // determine the limiting dimension for scaling the layers
        // one direction (the true one) will have minimum offsets
        // and the other will have larger offests (up to offsetMax)
        params.scaleLimitBy = new Object();
        var hz = diagramData[params.targetProduct][params.layerNames[0]]['x'] / params.liveArea.width;
        var vrt = diagramData[params.targetProduct][params.layerNames[0]]['y'] / params.liveArea.height;
        if (hz > vrt) {
            point(params.scaleLimitBy, true, false); // x = true, y = false
            params.limitDirection = 'width';
            params.looseDirection = 'height';
            params.limitCoordinate = 'x';
            params.looseCoordinate = 'y';
        } else {
            point(params.scaleLimitBy, false, true); // x = false, y = true
            params.limitDirection = 'height';
            params.looseDirection = 'width';
            params.limitCoordinate = 'y';
            params.looseCoordinate = 'x';
        }
        
        // caluculate the pixels used by offsetting in the limiting direction
        // work out both single offest and total offset
        if (params.layerCount > 1) {
            params[params.limitDirection+'Offset'] = scaleTo(params.liveArea[params.limitDirection], params.offsetMinPercent);
            params[params.limitDirection+'OffsetTotal'] = params[params.limitDirection+'Offset'] * (params.layerCount -1);
        } else {
            params[params.limitDirection+'Offset'] = 0;
            params[params.limitDirection+'OffsetTotal'] = 0;
        }
        
        // calculate the factor to use when scaling the layers
        params.scale = new Object();
        params.scale = (params.liveArea[params.limitDirection] - params[params.limitDirection+'OffsetTotal']) / parseFloat(diagramData[params.targetProduct][params.layerNames[0]][params.limitCoordinate]);
        
        // work through all the layers and set each one's actual size
        params.layerSizes = new Object();
        var count = 0;
        while (count < params.layerCount) {
            var pixelSize = new Object();
            size(pixelSize, 
                scaleTo(parseFloat(diagramData[params.targetProduct][params.layerNames[0]]['x']), params.scale),
                scaleTo(parseFloat(diagramData[params.targetProduct][params.layerNames[0]]['y']), params.scale)
            );
            params.layerSizes[params.layerNames[count]] = new Object();
            params.layerSizes[params.layerNames[count]]['size'] = pixelSize;
            diagramData[params.targetProduct][params.layerNames[count]]['size'] = pixelSize;
            count++;
        }
        
        // now work out the loose direcion offset values
        var looseSize = params.layerSizes[params.layerNames[0]]['size'][params.looseDirection];
        if (params.layerCount > 1) {
            params[params.looseDirection+'OffsetTotal'] = params.liveArea[params.looseDirection] - looseSize;
            params[params.looseDirection+'Offset'] = params[params.looseDirection+'OffsetTotal'] / (params.layerCount - 1);        
        } else {
            var remainder = params.liveArea[params.looseDirection] - looseSize;
            params[params.looseDirection+'Offset'] = remainder;
            params[params.looseDirection+'OffsetTotal'] = remainder;
        }
    }
    
    function getDiagramLayers(targetProduct){
        var count = 0;
        var layer = new Array();
        for (var x in diagramData[targetProduct]) {
            if (diagramData[targetProduct].hasOwnProperty(x)) {
                layer[count] = x;
               ++count;
               
            }
        }
        return layer;
    }
    
$(document).ready(function(){

    function initCheckboxes(){
        // initials filter checkboxes
        $('.filters input[type="checkbox"]').attr('checked','checked').bind('change', function(){
            var product = $(this).attr('category');
    //        alert(product);
            if($(this).attr('checked')){
                setting = 1;
            } else {
                setting = .35;
            }
    //            $('.'+$(this).attr('id')).css('opacity',setting);
                $('.'+product+'.'+$(this).attr('id')).css('opacity',setting);
        });
    }
    
    function initTableToggleHooks(){
        $('table').each(function(){
            var id = $(this).find('tr[class="table"] > td').attr('id');
            $(this).find('tr[class!="table"]').attr('class',id);
        })
    }
    
    function initProductSelections(){
        $('td > input[type="radio"]').bind('click', function(){
//            alert($(this).parent().attr('class'));
        })
    }
    
    function initTableReveal(){
        // roll up the tables to start
        // and put some instructions in their toggle bar
        $('*[id*="Toggle"].toggle').each(function(){
            $('.'+$(this).attr('id')).toggle(function(){
                
            });
            $(this).html($(this).html() + '<span class="instruction"> (Click to expand)</span>');
            $(this).bind('click', function(){
                if($(this).children('span.instruction').html() == ' (Click to expand)'){
                    $(this).children('span.instruction').html(' (Click to collapse)<span class="normal">Choose an item below to see design options.</span>')
                    $(this).css('height', '40px');
                } else {
                    $(this).children('span.instruction').html(' (Click to expand)')
                    $(this).css('height', '20px');
                }
            })
        });
    }



    function initProductRadios(){
        $('table[class*="Toggle"]').find('input[type="radio"]').bind('click', function(){
            var title = $(this).parent().attr('class').replace(/([\d])+_([\d])+/g, '$1.$2').replace(/ /g, ' - ').replace(/_/g, ' ');
            $('p.optionTitle').html(title);
            $('input[id*="Description"]').attr('value', title);
            var productCategory = $(this).parents('table').attr('id');
//            diagram = new diagramDiv($('div#diagram[class="'+productCategory+'"]'));
            var productDiagram = $('div#diagram[class="'+productCategory+'"]');
            var targetProduct = $(this).attr('diagram');
            diagramDiv(productDiagram, targetProduct);
        });
    }
 
    initCheckboxes();
    initTableToggleHooks(); 
    initProductSelections();
    initTableReveal();
    initProductRadios();
})