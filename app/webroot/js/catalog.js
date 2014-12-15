/**
 *======================================
 * This section handles form preparation of the product diagram scaffold
 * =====================================
 */
/**
 * Calculate positions and sizes for diagram parts setting page css
 * 
 * Strucure:
 * Wrapper Div containing
 *    multipler Layer Divs displaying a major design surface material properly proportioned
 *        containing secondary design Component Divs showing material and properly proportioned
 * Layer Divs IDs are are not unique :-( but not causing problems
 * Layers and Coponents are slaved to both table-radios and option inputs for visibility control
 * Layers and Components have a div 'material' attribute. This connects
 * them to input 'material' attribute which will set the div background images.
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
//Layer //'+layer+' is set to '+params.layerSizes[layer]['width']+'px wide and '+params.layerSizes[layer]['height']+'px tall.\n\
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
    params['offsetMinPercent'] = .08; // layer offset is least 10% of the container div's narrow dimension
    params['offsetMaxPercent'] = .75; // layer offset is at most 75% of the layer's size
    params['marginPercent'] = .08; // margin is 3%
    params['beltThicknessPercent'] = .07; // relative to case
    params['vertBeltThicknessPercent'] = .11;
    params['beltLengthPercent'] = .45; // relative to case
    params['vertBeltLengthPercent'] = .35; // relative to case
    // belt loop size will serve for pen loops too
    params['beltloopThicknessPercent'] = .6; // relative to belt height
    params['beltloopCapacityAdjustment'] = 4; // pixesl relative to belt height


    // store the DOM object and the product_group name
    params.div = div;
    params.product = $(div).attr('class');
    params.productGroup = productGroup;

    // analyze the diagramData left by the server for the product component layers to diagram
    params.layerNames = getDiagramLayers(productGroup);
    params.layerCount = params.layerNames.length;

    // make a css rule container for later use
    params.componentRules = '';

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

    // calculate the size and position of the closing belt parts
    determineClosingBeltSpecs(params);
    writeClosingBeltCss(params);

    // special rule for top opening cases
    writeTopOpeningCss(params);

    determinePenLoopSpecs(params);
    params.componentRules = params.componentRules + writeComponentCssRule(params, 'penloop');

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
    rules = rules + params.componentRules;
    if ($('style#diagramStyle.'+params.product).length == 0) {
    $('head').append('<style id="diagramStyle" class="'+params.product+'" type="text/css"><!--\n\
'+rules+' --></style>');            
    } else {
    $('style#diagramStyle.'+params.product).replaceWith('<style id="diagramStyle" class="'+params.product+'" type="text/css"><!--\n\
'+rules+' --></style>');            
    }
//        var sheet = $('#diagramStyle');
    // write rule for this layer
    // end loop
}

/**
 * Set size and position for pen loops
 */
function determinePenLoopSpecs(params){
    params.penloop = new Object;
            size(params.penloop, 
            parseInt(params.beltloop.width), 
            parseInt(params.beltloop.height));
    point(params.penloop, 
            parseInt(params.baseSize.width - params.beltloop.width + 2),
            parseInt(params.beltloop.height * 1.7));
}

/**
 * Work out which belt to make and make it
 * 
 * Could be horizontal, could be vertical
 * Make the right one and its loop
 */
function determineClosingBeltSpecs(params){
    if (params.product == 'Top_Opening') {
        specVerticalBelt(params);
    } else {
        specHorizontalBelt(params);
    }
}
/**
 * Create size and position specs for a closing belt
 */
function specHorizontalBelt(params){
    params.belt = new Object();
    params.belt.loop = new Object;

    size(params.belt, 
            parseInt(params.baseSize.width * params.beltLengthPercent), 
            parseInt(params.baseSize.height * params.beltThicknessPercent));
    point(params.belt, 
            parseInt(params.baseSize.width - params.belt.width + 2),
            parseInt((params.baseSize.height / 2) - (params.belt.height / 2)));

    specHorizontalBeltLoop(params);
}

/**
 * Create size and position specs for a horizontal closing belt's loop
 */
function specHorizontalBeltLoop(params){
    params.beltloop = new Object;
            size(params.beltloop, 
            parseInt(params.belt.height * params.beltloopThicknessPercent), 
            parseInt(params.belt.height + params.beltloopCapacityAdjustment));
    point(params.beltloop, 
            parseInt(params.belt.x + (params.belt.width * .75)),
            parseInt(params.belt.y - (params.beltloopCapacityAdjustment / 2)));
}

/**
 * Create size and position specs for a closing belt
 */
function specVerticalBelt(params){
    params.belt = new Object();
    params.belt.loop = new Object;

    size(params.belt, 
            parseInt(params.baseSize.width * (params.vertBeltThicknessPercent)), 
            parseInt(params.baseSize.height * params.vertBeltLengthPercent));
    point(params.belt, 
            parseInt((params.baseSize.width / 2) - (params.belt.width / 2)),
            parseInt(params.baseSize.height - params.belt.height + 2));

    specVerticalBeltLoop(params);
}

/**
 * Create size and position specs for a vertical closing belt's loop
 */
function specVerticalBeltLoop(params){
    params.beltloop = new Object;
            size(params.beltloop, 
            parseInt(params.belt.width + params.beltloopCapacityAdjustment),
            parseInt(params.belt.width * params.beltloopThicknessPercent*1.5));
    point(params.beltloop, 
            parseInt(params.belt.x - (params.beltloopCapacityAdjustment / 2)),
            parseInt(params.belt.y + (params.belt.height * .75)));
}

/**
 * Prep the belt css and put it on the output queue
 */
function writeClosingBeltCss(params){
        params.componentRules = params.componentRules + writeComponentCssRule(params, 'belt')
        params.componentRules = params.componentRules + writeComponentCssRule(params, 'beltloop');
    }

/**
 * Check for Top Opening products, write position rule
 */
function writeTopOpeningCss(params){
    if (params.product == 'Top_Opening' || params.product == 'Mini_Notebook') {
        params.boards = new Object();
        size(params.boards, params.baseSize.width, params.baseSize.height * .75);
        point(params.boards, 0, params.baseSize.height - params.boards.height);
        params.componentRules = params.componentRules + writeComponentCssRule(params, 'boards');
    }
}

/**
 * Write a typical size/position rule for a diagramed component
 * 
 * Layers use a different rule writer
 */
function writeComponentCssRule(params, componentName){
    var layer = componentName;
    var product = params.product
    var left = params[componentName].x;
    var top = params[componentName].y;
    var width = params[componentName].width;
    var height = params[componentName].height;
//        var zindex = 700 - (20*count);
//        var backcolor = color[count];
    var rule = 
'div#{0}.{1} {\n\
position: absolute;\n\
left: {2}px;\n\
top: {3}px;\n\
width: {4}px;\n\
height: {5}px;\n\
}\n\
';
    return (rule.format(layer, product, left, top, width, height));

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
        var content = params[params.looseDirection+'OffsetTotal'] + params.layerSizes[params.layerNames[0]][params.looseDirection];
    } else {
        var content = params.layerSizes[params.layerNames[0]][params.looseDirection];
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
    var looseSize = params.layerSizes[params.layerNames[0]][params.looseDirection];
    if (params.layerCount > 1) {
        params[params.looseDirection+'OffsetTotal'] = params.liveArea[params.looseDirection] - looseSize;
        params[params.looseDirection+'Offset'] = params[params.looseDirection+'OffsetTotal'] / (params.layerCount - 1);        
    } else {
        var remainder = params.liveArea[params.looseDirection] - looseSize;
        params[params.looseDirection+'Offset'] = remainder;
        params[params.looseDirection+'OffsetTotal'] = remainder;
    }
    if (params[params.looseDirection+'Offset'] > params.layerSizes[params.layerNames[0]][params.looseDirection]*params.offsetMaxPercent) {
        params[params.looseDirection+'Offset'] = params.layerSizes[params.layerNames[0]][params.looseDirection]*params.offsetMaxPercent;
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
        // umm... this is setting everything to the first layers aspect ratio...
        // saves css tweaks so leave it for now.
        size(pixelSize, 
            scaleTo(parseFloat(diagramData[params.productGroup][params.layerNames[0]]['x']), params.scale),
            scaleTo(parseFloat(diagramData[params.productGroup][params.layerNames[0]]['y']), params.scale)
        );
        params.layerSizes[params.layerNames[count]] = new Object();
        params.layerSizes[params.layerNames[count]] = pixelSize;
        diagramData[params.productGroup][params.layerNames[count]]['size'] = pixelSize;
        if (count == 0) {
            // make this easier to look up later
            params.baseSize = pixelSize;
        }
        count++;
    }
}

/**
 * Write a typical size/position rule for a diagram layer
 * 
 * Components use a different rule writer
 */
function writeLayerCssRule(params, count){
    var layer = params.layerNames[count];
    var product = params.product
    var left = (count * params.widthOffset) + params.margin.width;
    var top = count * params.heightOffset + params.margin.height;
    var width = params.layerSizes[params.layerNames[count]]['width'];
    var height = params.layerSizes[params.layerNames[count]]['height'];
    var zindex = 700 - (20*count);
//        var backcolor = color[count];
    var rule = 
'div#{0}.{1} {\n\
position: absolute;\n\
padding: 0;\n\
left: {2}px;\n\
top: {3}px;\n\
width: {4}px;\n\
height: {5}px;\n\
z-index: {6};\n\
}\n\
';
    return (rule.format(layer, product, left, top, width, height, zindex));

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

/**
 *======================================
 * This section handles form input interactions
 * =====================================
 */
/**
 * Read the page inputs and establish proper view state
 */
function establishAppropriatePageState(){
    storeCatalogHandles();
//    var count = 0;
    catalog.productNames.live = new Object();
    // Compile a list of products selected previously
    for (var product in catalog.productNames) {
        detectPreviousProductPick(product);
    }
    // Render the page sections to match the previous inputs
    for (var product in catalog.productNames.live) {
        renderProduct(product);
    }
    
}

/**
 * Place the DOM elements in the catalog map object
 * 
 * Just to make code easier to read and write
 */
function storeCatalogHandles(){
//    var count = 0;
    for (var product in catalog.productNames) {
        // store handles for one product
        catalog.productNames[product]['toggle'] = $('p#'+product+'Toggle');
        catalog.productNames[product]['table'] = $('table#'+product);
        catalog.productNames[product]['productRadios'] = $('table#'+product).find('input[type="radio"]');
        catalog.productNames[product]['options'] = $('div.options.'+product+'Toggle');
        catalog.productNames[product]['titleNode'] = $(catalog.productNames[product]['options']).find('p.optionTitle');
        catalog.productNames[product]['titleInput'] = $(catalog.productNames[product]['options']).find('input[id*="Description"]');
        catalog.productNames[product]['caveatNode'] = $(catalog.productNames[product]['options']).find('div.caveatWrapper');
    }
}

/**
 * Estblish proper page state if a product is selected
 * 
 * If a product variant has been select in the radio matrix
 * go through the price and diagram rendering clicks indicated
 * in the form to make the page match the inputs
 */
function renderProduct(product) {
    var list = catalog.productNames;
    if (list.live[product]) {
		// When edition cart items we don't want the section to close
		// This may not need to be done at all anymore because of presentation changes I've chosen
//		if ($('h3#cart_edit').length == 0) {
//			$(list[product]['toggle']).trigger('click');
//		}
        $(list.live[product]).trigger('click');
        var selects = $(list[product]['options']).find('select').filter(':visible');
        for (var select in selects) {
            $(select).trigger('change');
        }
        var radios = $(list[product]['options']).find('[type="radio"]').filter(':visible');
        for (var radio in radios) {
            if(radios[radio].checked) {
                $(radios[radio]).trigger('click');
            }
        }
    }
}
/**
 * See if a specific product matrix has a selected item
 * 
 * This will indicate existing form data. User has refreshed
 * page and had made selections, or we came her with data
 * specifying a product and need to render the diagram and title
 */
function detectPreviousProductPick(product){
    var radios = catalog.productNames[product]['productRadios'];
    for (var radio in radios){
        if (radios[radio].checked) {
            catalog.productNames.live[product] =  radios[radio];
            return;
        }
    }
    catalog.productNames.live[product] =  false;
}

/**
 * Sum the current price
 * 
 * Make a sum and span property
 */
function priceSum(product){
    var price = 0;
    for (var costNode in catalog[product]) {
        price += parseInt(catalog[product][costNode]['price']);
    }
	var qty = parseInt($('input[name="data['+product+'][quantity]"]').val());
	var total = qty * price;
	
	$('input[name="data['+product+'][sum]"]').val(price);
	$('input[name="data['+product+'][total]"]').val(total);
	
    catalog.productNames[product]['sum'] = price;
    catalog.productNames[product]['total'] = total;
	
    return catalog.productNames[product]['priceSpan'] = '<span class="price">' + total + '</span><span class="caveat">Estimate</span> ';
}

/**
 * Quantity change must multiply the price, then render the new price
 * 
 * @param {event} e
 */
function qtyChange(e) {
	var product = determineProduct(e.currentTarget);
	writePricedTitle(product);
}

/**
 * Create and store the products title
 * 
 * Esentially crunch down all the table x and y
 * headers into a single string
 */
function makeProductTitle(product){
    return catalog.productNames[product]['title'] = $(catalog[product]['product']['handle']).parent().attr('class').replace(/([\d])+_([\d])+/g, '$1.$2').replace(/ /g, ' - ').replace(/_/g, ' ');
}

/**
 * The whole title/caveat enchilada
 * 
 * Sum the price
 * Make the title
 * Put title on the page
 * Call for the caveat process too
 */
function writePricedTitle(product){
    var price = priceSum(product);
    var title = makeProductTitle(product);
    // write the title to the page
    $(catalog.productNames[product]['titleNode']).html(price + title);
    // write the title to a form input for delivery to the server
    $(catalog.productNames[product]['titleInput']).attr('value', title);
	// write the new sum to the paypal button
	
    // Write the current caveats to the page
    writeCaveatSet(product);
}

/**
 * Build up the caveat strings and output them
 * 
 * make the caveats indicated by the catalog oject
 * flag the div with alert color if necessary
 * place the package on the page
 */
function writeCaveatSet(product){
    var outputPattern = '<p><span class="caveat"> - {0}</span></p>';
    var target = catalog.productNames[product]['caveat'];
    var caveatOut = outputPattern.format(caveat[target]);
    for (var option in catalog[product]) {
        target = catalog[product][option]['caveat']
        if (target) {
            caveatOut = outputPattern.format(caveat[target]) + caveatOut;
        }
    }
    var oldlength = ($(catalog.productNames[product]['caveatNode']).html()).length;
    if (caveatOut.length > oldlength) {
//        $('div#caveat').css('background-color', 'orange');
        $('div#caveat').addClass('warn');
		caveatToggle($('div#caveat'));
    } else if (caveatOut.length < oldlength) {
//        $('div#caveat').css('background-color', 'khaki');
        $('div#caveat').removeClass('warn');
		caveatToggle($('div#caveat'));
    }
    $(catalog.productNames[product]['caveatNode']).html(caveatOut);
}

    /**
     * Set up the click on a specific node to control the display-toggle of another node
     * 
     * Any <item class=toggle id=unique_name> will toggle <item class=unique_name> on click
     */
    function caveatToggle(node){
        $(node).off('click').on('click',function(){
            $('.'+$(node).attr('id')).toggle(50,function(){
                // animation complete.
            });
        })
    }
    
//function resetCaveatColor(){
//        $('div#caveat').css('background-color', 'khaki');
//}

/**
 * Record the handle and price for one option in a product
 * 
 * Assumes the option node has a price attribute with the $ price
 * Assumes the catalog.product.nodeName is part of param-node id
 */
function recordOptionState(product, option, inputObj){
//    var option = determineOptionNodeName(product, inputObj)
    catalog[product][option]['handle'] = inputObj;
    switch (option){
        case ('product') :
            catalog[product][option]['price'] = $(inputObj).attr('price');
            catalog[product][option]['caveat'] = 'Normal';
            break;
        case ('title'):
            setRadioStylePrice(product, option);
            setRadioStyleCaveat(product, option, 'titling');
            break;
        case ('belt'):
            setRadioStylePrice(product, option)
            break;
        case ('penloop'):
            setRadioStylePrice(product, option);
            setRadioStyleCaveat(product, option, 'penloop');
            break;
//        bookbody ordering in Reusable Journals is suspended for now
//        case ('bookbody'):
//            lookupBookbodyPrice(product, inputObj);
//            break;
    }
}

/**
 * Store the price +/- inicated by a radio button choice
 * 
 * This is for yes/no options which carry a $ charge.
 * Yes = value 1
 * No = value 0
 * price attribute carries the charge
 */
function setRadioStylePrice(product, option){
    var obj = catalog[product][option]['handle'];
    catalog[product][option]['price'] = $(obj).val() * $(obj).attr('price');
}

/**
 * Some options create uncertainty, flag them for caveats
 * 
 * A radio button option may introduce uncertainty into pricing
 * For those cases, a call gets made to flag the catalog object
 * with a caveat index. Later this will be used to construct 
 * the full caveat block
 */
function setRadioStyleCaveat(product, option, caveat){
    var obj = catalog[product][option]['handle'];
    catalog[product][option]['caveat'] = ($(obj).val() == '1') ? caveat : false;
}


//function lookupBookbodyPrice(product, inputObj){
//            // this time inputObj includes three selects
//            // there are two required values before I can calc
//            var required = true;
//            for (i=0; i < inputObj.length; i++) {
//                required = $(inputObj[i]).val() == -1 ? false : required;
//            }
//            if (required) {
//                // The first char of the (cover) product number
//                var one = ($(catalog[product]['product']['handle']).val())[0];
//                // The third char of the page count (the first select)
//                var two = ($(inputObj[0]).val())[2];
//                // and the code for printed or blank (the second select)
//                switch ($(inputObj[1]).val()) {
//                    case ('blank'):
//                        var three = 'bk';
//                        break;
//                    case ('Other'):
//                        var three = 'x';
//                        break;
//                    default :
//                        var three = 'pk';
//                        break
//                }
//                catalog[product]['bookbody']['price'] = parseInt(pagePricing[one+'8'+two+three]);
//                catalog[product]['bookbody']['caveat'] = false;
//            } else {
//                catalog[product]['bookbody']['price'] = 0;
//                catalog[product]['bookbody']['caveat'] = 'partialBookbody';
//            }    
//}


//function determineOptionNodeName(product, inputObj){
//    for (var name in catalog[product]) {
//        if ($(inputObj).)
//    }
//}

/**
 * main product radiobutton matrix selection process
 * 
 * When the user select a new product in the table,
 * run the radio button through the price/caveat system
 * the build the appropriate diagram
 */
function productRadioClick(e){
    var radioObject = e.currentTarget;
    var product = $(radioObject).parents('table').attr('id');
	$('#'+product+'Code').val($(radioObject).val());
    
    // write the catalog object entries
    recordOptionState(product, 'product', radioObject);
    writePricedTitle(product);
     
    var productDiagram = $('div#diagram[class="'+product+'"]');
    var productGroup = $(radioObject).attr('diagram');
    diagramDiv(productDiagram, productGroup);
}

/**
 * Given an option input node, discover which product it belongs to
 */
function determineProduct(optionNode){
	return $(optionNode).parents('form').children('table').attr('id');
}

/**
 * Manage quarterbound cover cloth details for products with liners
 * 
 * Notebooks and other products that have liners and the option for 
 * quarterbound usually have matching cover and liner cloth. But I 
 * have radio buttons to allow them the diverge. This takes special 
 * handling to be aware of the radio button settings when they are present
 * 
 * @param {type} e
 * @returns {undefined} */
function linerChange(e) {
	
	// This is where I can set a list of products that have the feature
	var allowed = {'Notebook' : true};
	
	var product = determineProduct(e.currentTarget);
	if (allowed[product]) {
		var fieldset = $(e.currentTarget).parents('fieldset');
		var idKey = fieldset.find('legend').attr('id');
		var f = fieldset.find('input[type="radio"]');
		if ($(f[0]).prop('checked') == false && $(f[1]).prop('checked') == false) {
			fieldset.find('input[id~="'+idKey+'-uniqueliner0"]').prop('checked', true);
			$(f[0]).on('click', function() {
				$(e.currentTarget).trigger('change');
			})
		}		
		if (fieldset.find('input[type="radio"]').val() == 0) {
			
		}
	}
	
}

$(document).ready(function(){

    /**
     * Make the checkboxes reduce the opacity of portions of the table
     * 
     * A simple visual filter
     */
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
    
    /**
     * Populate class attributes to make toggling elements
     * 
     * Get the id of one cell in the table and set
     * all the rows to that class. Makes rows the elements that
     * respond to the toggle which shows/hides the table
     */
    function initTableToggleHooks(){
        $('table').each(function(){
            var id = $(this).find('tr[class="table"] > td').attr('id');
            $(this).find('tr[class!="table"]').attr('class',id);
        })
    }
    
//    function initProductSelections(){
//        $('td > input[type="radio"]').bind('click', function(){
////            alert($(this).parent().attr('class'));
//        })
//    }
    
    /**
     * Set up the banner that shows/hides the product matrix
     * 
     * The table gets hidden to start.
     * Set up some instructions to display for the two
     * visibility conditions
     */
    function initTableReveal(){
        // roll up the tables to start
        // and put some instructions in their toggle bar
        $('*[id*="Toggle"].toggle').each(function(){
//            $('.'+$(this).attr('id')).toggle(function(){
//                
//            });
            $(this).html($(this).html() + '<span class="instruction"> (Click to collapse)<span class="normal">Choose an item below to see design options.</span>').css('height', '40px');
            $(this).on('click', function(){
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

	function initEditForm() {
		var els = $('form[id*="orderform"] *:visible');
		if (els.length == '1'){
			var id = $(els).attr('id');
			$(els).removeClass('toggle').off('click');
			$('.'+ id).removeClass(id).css('display', 'block');
//			els.trigger('click').trigger('click');
		}
	}

    /**
     * bind the handler to product matrix radio buttons
     */
    function initProductRadios(){
        $('table[class*="Toggle"]').find('input[type="radio"]').bind('click', productRadioClick);
    }
    
    /**
     * Bind the handler to closing belt option radio buttons
     */
    function initClosingBeltRadio(){
        $('.input.Closing_Belt[type="radio"]').bind('click', function(){
            var product = determineProduct(this);
            
            // write the catalog object entries
            recordOptionState(product, 'belt', this);
            writePricedTitle(product);
            
            $(this).parents('fieldset').children('legend').html('Closing Belt <span class="plus">+$'+catalog[product]['belt']['price']+'</span>');
        })
    }
    
    /**
     * Bind the handler to closing titling option radio buttons
     */
    function initTitlingRadio(){
        $('.input.Titling_Options[type="radio"]').bind('click', function(){
            var product = determineProduct(this);
            
            // write the catalog object entries
            recordOptionState(product, 'title', this);
            writePricedTitle(product);
            
            $(this).parents('fieldset').children('legend').html('Titling Options <span class="plus">+$'+catalog[product]['title']['price']+'</span>');
        })
    }
    
    /**
     * Bind the handler to closing pen loop option radio buttons
     */
    function initPenloopRadio(){
        $('.input.Pen_Loop[type="radio"]').bind('click', function(){
            var product = determineProduct(this);
            
            // write the catalog object entries
            recordOptionState(product, 'penloop', this);
            writePricedTitle(product);
            
            $(this).parents('fieldset').children('legend').html('PenLoop <span class="plus">+$'+catalog[product]['penloop']['price']+'</span>');
        })
    }
    
    // this is supressed for now in favor of ordering from the separate book body product matrix
    // price and caveat problems were cascading down from this approach
//    function initBookbodySelects(){
//        $('select.Bookbody').bind('change', function(){
//            var product = determineProduct(this);
//            
//            // write the catalog object entries
//            // this one sends all necessary inputs, not just the clicked one
//            recordOptionState(product, 'bookbody', $(catalog.productNames[product]['options']).find('.Bookbody'));
//            writePricedTitle(product);
//        })
//    }
    
    /**
     * Bind a handler to the caveat asterisk click
     * 
     * It also acts as a standard toggler
     */
    function initCaveatClick(){
        $('div#caveat').bind('click',function(){
            $(this).css('background-color', 'khaki')
        });
    }
    
    /**
     * Link selects to divs for background replacement in diagrams
     */
    function initMaterialImages(){
        var optionDiv = $('div.options').each(function(){
            var diagram = $('div#diagram');
            $(this).find('select').each(function(){
                if ($(this).attr('material') != undefined) {
                    $(this).bind('change', function(){
                        var material = $(this).attr('material');
                        var product = $(this).parents('fieldset').attr('option').replace('slave-','');
						var image = ($(this).val() == 0) ? 'transparent.png' : $(this).val() + '.jpg';
                        $(diagram).find('div.'+product+'[material="'+material+'"]')
                            .css('background','url("'+imagePath+'materials/fullsize/'+ image + '")');
                        // cover material may be controlling liners too
                        if (material == 'cloth board') {
                            if ($(this).parent('div').siblings('.radio').children('*[value="0"]').prop('checked')){
                                $(this).parent('div').siblings('.select').find('select[material="cloth liners"]').val($(this).val());
                                $(this).parent('div').siblings('.select').find('select[material="cloth liners"]').trigger('change');
                            }
                        }
                    });
                }
            });
        });
    }
    
    function initLinerRadios(){
        
    }
     
//    initCheckboxes();
    initTableToggleHooks();
	if ($('h3#new_product').length == 1) {
		initTableReveal();
	}
    initProductRadios();
    initMaterialImages();
    initClosingBeltRadio();
    initTitlingRadio();
    initPenloopRadio();
    initCaveatClick();
    establishAppropriatePageState();
//	if ($('h3#cart_edit').length == 1) {
//		initEditForm();
//	}
})
