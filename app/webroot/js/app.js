/**
 * General purpose Graphic coordinate methods
 * ======================================================
 */
/**
 * new jquery function to center something in the scrolled window
 * 
 * Sets the css left and top of the chained element
 */
jQuery.fn.center = function() {
//    this.css("position", "fixed");
    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
            $(window).scrollTop()) + "px");
    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
            $(window).scrollLeft()) + "px");
    return this;
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
 * For a button that has an href attr, make click act like clicking a link
 * 
 * @param {type} e
 * @returns {undefined}
 */
function buttonLink(e) {
	location.assign(webroot + e.currentTarget.getAttribute('href'));
}
/**
 * End general purpose Graphic coordinate methods
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

/**
 * Sweep the page for bindings indicated by HTML attribute hooks
 * 
 * Class any DOM element with event handlers.
 * Place a 'bind' attribute in the element in need of binding.
 * bind="focus.revealPic blur.hidePic" would bind two methods
 * to the object; the method named revealPic would be the focus handler
 * and hidePic would be the blur handler. All bound handlers
 * receive the event object as an argument
 * 
 * @param {string} target a selector to limit the scope of action
 * @returns The specified elements will be bound to handlers
 */
function bindHandlers(target) {
    if (typeof(target) == 'undefined') {
        var targets = $('*[bind*="."]');
    } else {
		var targets = $(target).find('*[bind*="."]')
	}
	targets.each(function(){
		var bindings = $(this).attr('bind').split(' ');
		for (i = 0; i < bindings.length; i++) {
			var handler = bindings[i].split('.');
			if (typeof(window[handler[1]]) === 'function') {
				// handler[0] is the event type
				// handler[1] is the handler name
				$(this).off(handler[0]).on(handler[0], window[handler[1]]);
			}
		}
	});
}

/**
 * Close flash messages that have the new 'X' button in them
 * 
 * ************************************************************************************************ get rid of this badly coupled code ==========
 * 
 * @returns {void}
 */
function closeFlash() {
	// This logic should not be here. excess coupling
	var cartNode = $(this).parent('div').parent('div').attr('id');
	if (cartCount() == '0' &&  cartNode == 'cart_pallet') {
		$(this).parent('div').parent('div').remove();
		$('div#pgMask').removeClass('cover');
	} else if (cartCount() == '0' &&  cartNode == 'cart_checkout'){
		var continueButton = $('button#continue').clone(true);
		$('div#cart_checkout').html('<p>Your cart is empty.</p>').append(continueButton);
	} else {
		
		// this is all that should be here I think
		$(this).parent('div').remove();
	}
}

function cartCount() {
	return $('#cart_badge span.count').html();
}

/**
 * Document ready section =========================================================================
 * ========================================================================= Document ready section
 * 
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
			alert(posting.responseText);
//            location.assign(posting.responseText);
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
	bindHandlers();
})
