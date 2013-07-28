    /**
     * Calculate positions and sizes for diagram parts setting page css
     */
    function diagramDiv(div, productGroup){
        
        // prepare our main data object 
        var params = new Object

        // intialize its core values
        setDiagramDefaults(params, div, productGroup);
        initializeDiagram(params);
        createDiagramCssRules(params);
        
//        for (var layer in params.layerSizes){
//alert('The div is '+params.divSize.width+' by '+params.divSize.height+'. \n\
//The live area is //'+params.liveArea.width+' by '+params.liveArea.height+'. \n\
//Layer //'+layer+' is set to '+params.layerSizes[layer]['size']['width']+'px wide and '+params.layerSizes[layer]['size']['height']+'px tall.\n\
//Width offest = //'+params.widthOffset+'/'+params.widthOffsetTotal+'.\n\
//Height offest = //'+params.heightOffset+'/'+params.heightOffsetTotal+'.\n\
//There are //'+params.layerCount+' layers.\n\
//Side margins = //'+params.margin.width+' and 2*margin='+params.margin.width*2+'.\n\
//Top/Bot margins = //'+params.margin.height+' and 2*margin='+params.margin.height*2);
//        }
    }
    
    /**
     * Set diagram div's default values
     */
    function setDiagramDefaults(params, div, productGroup){

        // establish some baseline control relationships
        params['offsetMinPercent'] = .05; // layer offset is least 10% of the container div's narrow dimension
        params['offsetMaxPercent'] = .75; // layer offset is at most 75% of the layer's size
        params['marginPercent'] = .08; // margin is 3%
        
        // store the DOM object and the product_group name
        params.div = div;
        params.product = $(div).attr('class');
        params.productGroup = productGroup;
        
        // analyze the diagramData left by the server for the product component layers to diagram
        params.layerNames = getDiagramLayers(productGroup);
        params.layerCount = params.layerNames.length;
        
    }
    
    /**
     * calc the diagram div's baseline parameters
     * 
     * Set the margin and offset starting % values
     * Calculate the actual pixel values for both
     * Assumes the first layer is going to be the largest
     */
    function initializeDiagram(params){
        
        // work out divSize, margin, liveArea
        initializeDiagramWrapper(params)

        // work out:
        // limitDirection, looseDirection ('width' or 'height')
        // limitCoordinate, looseCoordinate ('x' or 'y')
        findScaleLimit(params)
        
        // calulate limit direction offset
        // widthOffset, widthOffsetTotal or heightOffset, heightOffsetTotal
        setLimitOffset(params);

        // scale
        setScaleFactor(params);
        
        // add size properties to each layer and each json entry
        // params.layerSizes.--layerName--.size.width and blah.size.height
        // diagramData.--targetProperty--.--layerName--.size.width and blah.size.height
        scaleEachLayer(params);
        
        // calulate loose direction offset
        // widthOffset, widthOffsetTotal or heightOffset, heightOffsetTotal
        setLooseOffset(params);
        
        // Center the diagram in the loose direction
        adjustLooseMargin(params);        
    }
    
    /**
     * Create styles to control the diagram layers
     */
    function createDiagramCssRules(params){
        var rules = '';
        var count = 0;
        while (count < params.layerCount) {
            rules = rules + writeLayerCssRule(params, count);
            count++;
        }
        $('head').append('<style id="diagramStyle" type="text/css"><!--\n\
'+rules+' --></style>');
//        var sheet = $('#diagramStyle');
        // write rule for this layer
        // end loop
    }
    
    /**
     * Set outermost parameters for the diagram wrapper div
     * 
     * divSize
     * margin
     * liveArea
     **/
    function initializeDiagramWrapper(params){
        
        // create a divSize object, the diagram wrapper div
        params.divSize = new Object();
        size(params.divSize, parseInt($(params.div).css('width')), parseInt($(params.div).css('height')));
        
        // workout the actual margin in pixels
        var margin = new Object();
        if (params.divSize.width < params.divSize.height) {
            var value = scaleTo(params.divSize.width, params.marginPercent)
        } else {
            var value = scaleTo(params.divSize.height, params.marginPercent)
        }
        size(margin, value, value);
        params['margin'] = margin;
        
        // set the live-area size for the div
        params.liveArea = new Object();
        size(params.liveArea, params.divSize.width - (params.margin.width * 2), params.divSize.height - (params.margin.height * 2))
    }
    
    /**
     * Adjust the margin in the loose direction to center the diagram
     */
    function adjustLooseMargin(params){
        // the loose direction may not reach from margin to margin
        // if that is the case, adjust the margins to center things
        if (params.layerCount > 1) {
            var content = params[params.looseDirection+'OffsetTotal'] + params.layerSizes[params.layerNames[0]]['size'][params.looseDirection];
        } else {
            var content = params.layerSizes[params.layerNames[0]]['size'][params.looseDirection];
        }
        var remainder = params.liveArea[params.looseDirection] - content;
        if (remainder > 0) {
            remainder = parseInt(remainder/2);
            params.margin[params.looseDirection] += remainder;
        }
    }
    
    /**
     * Work out which dimension limits the layer size
     * 
     * Create a set of properties that will act as indexes
     * into other properties during later work.
     */
    function findScaleLimit(params){
        // determine the limiting dimension for scaling the layers
        // one direction (the true one) will have minimum offsets
        // and the other will have larger offests (up to offsetMax)
        params.scaleLimitBy = new Object();
        var hz = diagramData[params.productGroup][params.layerNames[0]]['x'] / params.liveArea.width;
        var vrt = diagramData[params.productGroup][params.layerNames[0]]['y'] / params.liveArea.height;
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
    }

    /**
     * workout the offset and total offset for the limit direction
     */
    function setLimitOffset(params){
        // caluculate the pixels used by offsetting in the limiting direction
        // work out both single offest and total offset
        if (params.layerCount > 1) {
            params[params.limitDirection+'Offset'] = scaleTo(params.liveArea[params.limitDirection], params.offsetMinPercent);
            params[params.limitDirection+'OffsetTotal'] = params[params.limitDirection+'Offset'] * (params.layerCount -1);
        } else {
            params[params.limitDirection+'Offset'] = 0;
            params[params.limitDirection+'OffsetTotal'] = 0;
        }
    }

    /**
     * workout the offset and total offset for the limit direction
     */
     function setLooseOffset(params){
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
        if (params[params.looseDirection+'Offset'] > params.layerSizes[params.layerNames[0]]['size'][params.looseDirection]*params.offsetMaxPercent) {
            params[params.looseDirection+'Offset'] = params.layerSizes[params.layerNames[0]]['size'][params.looseDirection]*params.offsetMaxPercent;
            params[params.looseDirection+'OffsetTotal'] = params[params.looseDirection+'Offset'] * (params.layerCount - 1);
        }
     }
     
    /**
     * Determine the scale for all layer components
     */
    function setScaleFactor(params){
        params.scale = new Object();
        params.scale = (params.liveArea[params.limitDirection] - params[params.limitDirection+'OffsetTotal']) / parseFloat(diagramData[params.productGroup][params.layerNames[0]][params.limitCoordinate]);
    }
    
    /**
     * Scale each layer
     * 
     * store properties in both params and diagramData (the json object)
     */
    function scaleEachLayer(params){
        // work through all the layers and set each one's actual size
        params.layerSizes = new Object();
        var count = 0;
        while (count < params.layerCount) {
            var pixelSize = new Object();
            size(pixelSize, 
                scaleTo(parseFloat(diagramData[params.productGroup][params.layerNames[0]]['x']), params.scale),
                scaleTo(parseFloat(diagramData[params.productGroup][params.layerNames[0]]['y']), params.scale)
            );
            params.layerSizes[params.layerNames[count]] = new Object();
            params.layerSizes[params.layerNames[count]]['size'] = pixelSize;
            diagramData[params.productGroup][params.layerNames[count]]['size'] = pixelSize;
            count++;
        }
    }

    function writeLayerCssRule(params, count){
        var color = new Array('blue', 'green', 'grey', 'maroon', 'orange');
//div#case.Journal {
//    height: 495px;
//    left: 30px;
//    padding: 0;
//    position: absolute;
//    top: 30px;
//    width: 386px;
//}
        var layer = params.layerNames[count];
        var product = params.product
        var left = (count * params.widthOffset) + params.margin.width;
        var top = count * params.heightOffset + params.margin.height;
        var width = params.layerSizes[params.layerNames[count]]['size']['width'];
        var height = params.layerSizes[params.layerNames[count]]['size']['height'];
        var zindex = 700 - (20*count);
        var backcolor = color[count];
        var rule = 
'div#{0}.{1} {\n\
    position: absolute;\n\
    padding: 0;\n\
    left: {2}px;\n\
    top: {3}px;\n\
    width: {4}px;\n\
    height: {5}px;\n\
    z-index: {6};\n\
    background-color: {7};\n\
}\n\
';
        return (rule.format(layer, product, left, top, width, height, zindex, backcolor));
        
    }
    
    /**
     * Scan json block to see how many diagram layers
     * 
     * Server writes data to json diagramData
     * productGroup is Diagram.product_group and Catalog.product_group (link)
     * json array is custom composed by Catalog Model
     * layers are primary diagramed product surfaces, case, liner, etc.
     */
    function getDiagramLayers(productGroup){
        var count = 0;
        var layer = new Array();
        for (var x in diagramData[productGroup]) {
            if (diagramData[productGroup].hasOwnProperty(x)) {
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
            var productGroup = $(this).attr('diagram');
            diagramDiv(productDiagram, productGroup);
        });
    }
 
    initCheckboxes();
    initTableToggleHooks(); 
    initProductSelections();
    initTableReveal();
    initProductRadios();
})
