/**
 * Calculate positions and sizes for diagram parts setting page css
 * 
 * Strucure:
 * Wrapper Div containing
 *    multipler Layer Divs displaying a major desing surface material properly proportioned
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
 * Create size and position specs for a horizontal closing belt's loop
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

function writeLayerCssRule(params, count){
//        var color = new Array('blue', 'green', 'grey', 'maroon', 'orange');
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
        $(list[product]['toggle']).trigger('click');
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
    catalog.productNames[product]['sum'] = price;
    return catalog.productNames[product]['priceSpan'] = '<span class="price">$' + price + '</span><span class="caveat">Estimate</span> ';
}

function makeProductTitle(product){
    return catalog.productNames[product]['title'] = $(catalog[product]['product']['handle']).parent().attr('class').replace(/([\d])+_([\d])+/g, '$1.$2').replace(/ /g, ' - ').replace(/_/g, ' ');
}

function writePricedTitle(product){
    var price = priceSum(product);
    var title = makeProductTitle(product);
    // write the title to the page
    $(catalog.productNames[product]['titleNode']).html(price + title);
    // write the title to a form input for delivery to the server
    $(catalog.productNames[product]['titleInput']).attr('value', title);
    // Write the current caveats to the page
    writeCaveatSet(product);
}

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
    $(catalog.productNames[product]['caveatNode']).html(caveatOut);
}

/**
 * Record the handle and price for one option in a product
 * 
 * Assumes the option node has a price attribute with the $ price
 * Assumes the catalog.product.nodeName is part of param-node id
 */
function recordOptionState(product, name, inputObj){
//    var name = determineOptionNodeName(product, inputObj)
    catalog[product][name]['handle'] = inputObj;
    switch (name){
        case ('product') :
            catalog[product][name]['price'] = $(inputObj).attr('price');
            catalog[product][name]['caveat'] = 'Normal';
            break;
        case ('title'):
            setRadioStylePrice(product, name);
            setRadioStyleCaveat(product, name, 'titling');
            break;
        case ('belt'):
            setRadioStylePrice(product, name)
            break;
        case ('penloop'):
            setRadioStylePrice(product, name);
            setRadioStyleCaveat(product, name, 'penloop');
            break;
//        bookbody ordering in Reusable Journals is suspended for now
//        case ('bookbody'):
//            lookupBookbodyPrice(product, inputObj);
//            break;
    }
}

function setRadioStylePrice(product, name){
    var obj = catalog[product][name]['handle'];
    catalog[product][name]['price'] = $(obj).val() * $(obj).attr('price');
}

function setRadioStyleCaveat(product, name, caveat){
    var obj = catalog[product][name]['handle'];
    catalog[product][name]['caveat'] = ($(obj).val() == '1') ? caveat : false;
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

function productRadioClick(e){
    var radioObject = e.currentTarget;
    var product = $(radioObject).parents('table').attr('id');
    
    // write the catalog object entries
    recordOptionState(product, 'product', radioObject);
    writePricedTitle(product);
     
    var productDiagram = $('div#diagram[class="'+product+'"]');
    var productGroup = $(radioObject).attr('diagram');
    diagramDiv(productDiagram, productGroup);
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
    
//    function initProductSelections(){
//        $('td > input[type="radio"]').bind('click', function(){
////            alert($(this).parent().attr('class'));
//        })
//    }
    
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
        $('table[class*="Toggle"]').find('input[type="radio"]').bind('click', productRadioClick);
    }
    
    function initClosingBeltRadio(){
        $('.input.Closing_Belt[type="radio"]').bind('click', function(){
            var product = determineProduct(this);
            
            // write the catalog object entries
            recordOptionState(product, 'belt', this);
            writePricedTitle(product);
            
            $(this).parents('fieldset').children('legend').html('Closing Belt <span class="plus">+$'+catalog[product]['belt']['price']+'</span>');
        })
    }
    
    function initTitlingRadio(){
        $('.input.Titling_Options[type="radio"]').bind('click', function(){
            var product = determineProduct(this);
            
            // write the catalog object entries
            recordOptionState(product, 'title', this);
            writePricedTitle(product);
            
            $(this).parents('fieldset').children('legend').html('Titling Options <span class="plus">+$'+catalog[product]['title']['price']+'</span>');
        })
    }
    
    function initPenloopRadio(){
        $('.input.Pen_Loop[type="radio"]').bind('click', function(){
            var product = determineProduct(this);
            
            // write the catalog object entries
            recordOptionState(product, 'penloop', this);
            writePricedTitle(product);
            
            $(this).parents('fieldset').children('legend').html('PenLoop <span class="plus">+$'+catalog[product]['penloop']['price']+'</span>');
        })
    }
    
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
    
    function determineProduct(optionNode){
        return $(optionNode).parents('form').children('table').attr('id');
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
                        $(diagram).find('div.'+product+'[material="'+material+'"]')
                            .css('background','url("'+imagePath+'materials/fullsize/'+$(this).attr('value') + '.jpg")');
                        // cover material may be controlling liners too
                        if (material == 'cloth board') {
                            if (!$(this).parent('div').siblings('.radio').children('*[value="1"]').attr('checked')){
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
     
    initCheckboxes();
    initTableToggleHooks();
//    initProductSelections();
    initTableReveal();
    initProductRadios();
    initMaterialImages();
    initClosingBeltRadio();
    initTitlingRadio();
    initPenloopRadio();
//    initBookbodySelects();
    establishAppropriatePageState();
})
