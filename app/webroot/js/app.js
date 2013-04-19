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
})
