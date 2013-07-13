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
     * Any <item option = "master" + [-nameSpace] class = "foo bar"> will make visible
     * <item option = "slave" + [-nameSpace] class = "foo" + ["foobar"]> OR <item option "slave" + [-nameSpace] class = "bar" + ["foobar"]>
     * and will make invisible any
     * <item option = "slave" + [-nameSpace] class != "foo"> And <item option = "slave" + [-nameSpace] class != "bar>
     * 
     * First grab all <item option = "slave" + [-nameSpace]> and hide
     * Then reveal each eligible item
     * 
     * To have a Slave node that is a Master to other nodes:
     * <p option="slave-alpha" class="message">
     *     <span option="master-beta" class="usage">
     *         You can have a closing belt (click for usage)
     *     </span>
     * </p>
     * In this case, the slave's slave must respond to both parents:
     * <p option="slave-alpha" class="message">
     *     <span option="slave-beta class="usage">
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
            // even if the button is down-tree, we need its form
            submitAddToCart($(this).parents('form'));
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
    function submitAddToCart(form){
        var productName = $(form).attr('id').replace(/orderform/,'');
        displayAddToCartMessage('Adding your item to the cart . . .', productName);
        var url = '/bindery/catalogs/order/blah';
        var order = serializeVisibleFields(form, productName);
        // now make the ajax call
        var posting = $.post(url, order, function(){
            displayAddToCartMessage(posting.responseText, productName);
        });
    }
    
    /**
     * Strip the form down to relevant fields and serialize
     * 
     * @todo remove unecessary fields
     */
    function serializeVisibleFields(form, productName){
        // massage the form here
        var fields = $(form).find('*[name~="'+productName+'"]');
        return $(fields).serialize();
    }
    
    /**
     * After productName add-to-cart ajax, put return message on page
     * 
     * @todo decide on a final plan for messaging
     */
    function displayAddToCartMessage(data, productName){
        $('div.'+productName+'message').empty().append('<p>'+data+'</p>');
    }
    
    initSiteSearchForm();
    initAdvancedSearchClick();
    initToggles();
    hideAllSlaveNodes();
    initTogglingSets();
    initAddToCartButtons();
})
