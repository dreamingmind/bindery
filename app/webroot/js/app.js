/**
 * General purpose Graphic coordinate methods
 * ======================================================
 */
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
 * End eneral purpose Graphic coordinate methods
 * ======================================================
 */
    
/**
 * General purpose String methods
 * ======================================================
 */
/**
 * Add sprintf() behavior to strings
 * targets in format string = {1}, {2}, {n...}
 */
//first, checks if it isn't implemented yet
if (!String.prototype.format) {
  String.prototype.format = function() {
    var args = arguments;
    return this.replace(/{(\d+)}/g, function(match, number) { 
      return typeof args[number] != 'undefined'
        ? args[number]
        : match
      ;
    });
  };
}
/**
 * End eneral purpose String methods
 * ======================================================
 */


$(document).ready(function(){
    $('#flashMessage').delay(6400).fadeOut(3200);

    function initSiteSearchForm(){
        var standardInput = $('input.siteSearchInput');
        standardInput.bind('blur',function(){
            if(this.value==''){
                discardStandardSearch();
//                $(this).css('color','#999').css('font-weight','normal');
//                this.value=' Search';
            }
        });
        standardInput.bind('focus',function(){
            if(this.value==' Search'){
                discardAdvancedSearch();
                this.value='';
                $(this).css('color','black').css('font-weight','bold');
            }
        });
    }
    
    /**
     * Set up the click on a node to control the display-toggle of another node
     * 
     * Any <item class=toggle id=unique_name> will toggle <item class=unique_name> on click
     */
    function initToggles(){
        $('.toggle').bind('click',function(){
            $('.'+$(this).attr('id')).toggle(50,function(){
                // animation complete.
            });
        })
    }
    
    /**
     * Set up the click of a node to control the mixed visibility of a set of nodes
     * 
     * Any <item option = "master" + [-nameSpace] setlist = "foo bar"> 
     * will make VISIBLE
     * <item option = "slave" + [-nameSpace] setlist = "foo" + " baz"> || <item option "slave" + [-nameSpace] setlist = "bar" + " baz">
     * and will make INVISIBLE any
     * <item option = "slave" + [-nameSpace] setlist != "foo"> && <item option = "setlist" + [-nameSpace] class != "bar">
     * 
     * First grab all <item option = "slave" + [-nameSpace]> and hide
     * Then reveal each eligible item
     * 
     * To have a Slave node that is a Master to other nodes:
     * <p option="slave-alpha" setlist="message">
     *     <span option="master-beta" setlist="usage">
     *         You can have a closing belt (click for usage)
     *     </span>
     * </p>
     * In this case, the slave's slave must respond to both parents:
     * <p option="slave-alpha" setlist="message">
     *     <span option="slave-beta setlist="usage">
     *         Good for journals, notebooks and portfolios
     *     </span>
     * </p>
     * 
     * @TODO Don't just do a display:none/display:block toggle
     *       This won't work in all cases. Add an attribute in the tag
     *       so each one can act in its own way.
     *       First idea - Words to parse into jquery .css() method:
     *       toggle = "display none display block"
     *       toggle = "opacity .3 opacity 1"
     *       
     * @TODO I could make the master clicks recursive so the 
     *       slave's slaves would toggle automatically, making
     *       the HTML code simler and less error prone
     */
    function initTogglingSets(){
        $('*[option|="master"]').each(function(){
            $(this).bind('click',function(){
            // set nameSpace (will be '-name' or null)
            var nameSpace = $(this).attr('option').replace(/^master/,'');
            // assemble a list of potentially eligible classes
            var eligibleSetList = $(this).attr('setlist').match(/[\w]+/g);
            // now hide all option= 'slave' + nameSpace
            hideSlaveNodes(nameSpace);
            // now reveal each eligible slave
            $(eligibleSetList).each(function(){
                $('*[option="slave' + nameSpace + '"][setlist~="' + this + '"]').css('display', 'block');
            });
            
            })
        });
    }
    
    /**
     * Hide every slave node for every master
     * 
     * Toggling sets start out with every slave node hidden
     */
    function hideAllSlaveNodes(){
        $('*[option|="master"]').each(function(){
            // set nameSpace (will be '-name' or null)
            var nameSpace = $(this).attr('option').replace(/^master/,'');
            hideSlaveNodes(nameSpace);
        });
    }
    
    /**
     * Hide all the slave nodes for a single master
     */
    function hideSlaveNodes(nameSpace){
        $('*[option="slave' + nameSpace + '"]').css('display', 'none');
    }

    function discardStandardSearch(){
        $('input.siteSearchInput').css('color','#999').css('font-weight','normal');
        $('input.siteSearchInput').val(' Search');
    }

    function initAdvancedSearchClick(){
        $('#advanced-search').children('a').bind('click',function(e){
            e.preventDefault();
            discardStandardSearch();
            $(this).html('LOADING: Advanced Search');
            $('#advanced-search').append().load($(this).attr('href'),
                function(){ //this add a function to the incoming HTML chunk
                    $('.cancel-advanced-search').bind('click',discardAdvancedSearch);
                    formatAdvancedSearchDates();
                });
            $('#advanced-search').attr('class', 'asfieldsets');
       });
    }

    function formatAdvancedSearchDates(){
        $('label[for$="year"]').css('width','36%').parent().css('display','inline-block').css('width','50%');
        $('label[for$="month"]').css('width','36%').parent().css('display','inline-block').css('width','50%');
        $('select[id$="year"]').css('width','59%').bind('change',resetWeek);
        $('select[id$="month"]').css('width','59%').bind('change',resetWeek);
        $('select[id$="week"]').bind('change',resetYearMonth);
//        , label[id~=month]')
    }

    function resetWeek(){
        $('select[id$="week"]').val('0');
    }

    function resetYearMonth(){
        $('select[id$="year"]').val('0');
        $('select[id$="month"]').val('0');
    }

    function discardAdvancedSearch(){
        $('#advanced-search').html('<a class="advanced-search" href="/bindery/contents/advanced_search">Advanced Search</a>');
        $('#advanced-search').attr('class', '');
        initAdvancedSearchClick();
    }
    
    /**
     * Set click function for prodcut Add-to-Cart buttons
     * 
     */
    function initAddToCartButtons(){
        $('button.orderButton').bind('click', function(event){
            event.preventDefault();
            submitAddToCart(this);
        })
    }

    /**
     * Ask server to add productName to cart, show resulting message
     * 
     * Ajax call
     * Expects form#orderformUniqeProductName as this form
     * and and will target div.messageUniqeProductName with the message
     * Also, necessary fields will have name~="UniqueProductName"
     * 
     * @todo construct the url properly
     */
    function submitAddToCart(button){
        var formObject = buildFormObjectFrom(button);
        displayAddToCartMessage('Adding your item to the cart . . .', formObject.name);
        var url = '/bindery/catalogs/order/blah';
        // now make the ajax call
//        var posting = $.post(url, formObject.serializedClone, function(){
//            displayAddToCartMessage(posting.responseText, formObject.name);
//        });
        var posting = $.post(url, formObject.serializedClone, function(){
            location.assign(posting.responseText);
//            displayAddToCartMessage(posting.responseText, formObject.name);
//        })
//        .done(function(posting.responseText){
//            alert(posting.responseText);
        });
    }
    
    /**
     * Create the values and element sets we'll need for an add-to-cart process
     * 
     * Given any form element, use its parent form
     */
    function buildFormObjectFrom(formElement){
        var obj = new Object();
        
        obj.originalForm = $(formElement).parents('form');
        
        obj.name = $(obj.originalForm).attr('id').replace(/orderform/,'');
        obj.messageContainer = $('div.'+obj.name+'message');
        
        obj.formClone = $(obj.originalForm).clone();
        $(obj.formClone).empty();
        
        obj.inputClone = $(obj.originalForm).find('fieldset:visible > div > div:visible, td > input[type="radio"], input[id*=Description]').clone();
        $(obj.formClone).append(obj.inputClone);
        obj.serializedClone = $(obj.formClone).serialize();
        
        return obj
    }
    
    /**
     * After productName add-to-cart ajax, put return message on page
     * 
     * @todo decide on a final plan for messaging
     */
    function displayAddToCartMessage(data, productName){
        $('div.'+productName+'message').empty().append(data);
    }
    
    initSiteSearchForm();
    initAdvancedSearchClick();
    initToggles();
    hideAllSlaveNodes();
    initTogglingSets();
    initAddToCartButtons();
})
