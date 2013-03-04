$(document).ready(function(){
    $('#flashMessage').delay(6400).fadeOut(3200);
    
    function initSiteSearchForm(){
        var standardInput = $('input.siteSearchInput');
        standardInput.bind('blur',function(){
            if(this.value==''){
                $(this).css('color','#999').css('font-weight','normal');
                this.value=' Search';
            }
        });
        standardInput.bind('focus',function(){
            if(this.value==' Search'){
                this.value='';
                $(this).css('color','black').css('font-weight','bold');
            }
        });
    }
    
    function initAdvancedSearch(){
        $('#advanced-search').children('a').bind('click',function(e){
            e.preventDefault();
            $(this).html('LOADING: Advanced Search');
            $('#advanced-search').append().load($(this).attr('href'),
                function(){ //this add a function to the incoming HTML chunk
                    $('.cancel-advanced-search').bind('click',discardAdvancedSearch);
                });
            $('#advanced-search').attr('class', 'asfieldsets');
       });
    }
    
    function discardAdvancedSearch(){
        $('#advanced-search').html('<a class="advanced-search" href="/bindery/contents/advanced_search">Advanced Search</a>');
        $('#advanced-search').attr('class', '');
        initAdvancedSearch();
    }
    
    initSiteSearchForm();
    initAdvancedSearch();
})
