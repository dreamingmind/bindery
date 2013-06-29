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
     * Any <item option="master[-nameSpace]" class="foo bar"> will make visible
     * <item option="slave[-nameSpace]" class="foo"> OR <item option[-nameSpace]="slave" class="bar">
     * and will make invisible any
     * <item option="slave[-nameSpace]" class="!foo"> And <item option="slave[-nameSpace]" class="!bar>
     * 
     * First grab all <item option="slave[-nameSpace]"> and hide
     * Then reveal each eligible item
     * 
     * Resist the temptation to make Masters control multiple Slave groups
     * or to have Slaves controlled by multiple Masters. Though possible in theory
     * this is likely to create absurd complications on the server-side when trying to
     * process incomming Form data (if this is used to control a form). Much better to clone 
     * nodes into multiple nameSpaces; something that can be done with js
     * once the page loads or from the View.
     */
    function initTogglingSets(){
        $('[option~="master"]').each().bind('click',function(){
            // set nameSpace (will be '-name' or null)
            var nameSpace = $(this).attr('option').replace(/master/,'');
            // assemble a list of potentially eligible classes
            var eligibleClassList = null; // make an array here
            
            // now hide all option= 'slave' + nameSpace
            
            // now reveal each eligible slave
            
        });
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

    initSiteSearchForm();
    initAdvancedSearchClick();
    initToggles();
})
