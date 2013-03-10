<?php
if($searchResults){
    foreach($searchResults as $category_name => $category_set){
        if($category_set){
            switch ($category_name){
                case 'dispatch':
                    echo $html->tag('h2','Blog Articles');
                    foreach($category_set as $result){
//                        debug($result);
                        echo $html->siteSearchBlogBlock($result);
                    }
                    break;
                case 'exhibit':
                case 'art':
                    echo $html->tag('h2','Gallery Exhibits');
                    foreach($category_set as $result){
//                        debug($result);
                        echo $html->siteSearchGalleryBlock($result);
                    }
                    break;
                case 'workshop':
                    echo $html->tag('h2','Workshops');
                    foreach($category_set as $result){
//                        debug($result);
                        echo $html->siteSearchWorkshopBlock($result);
                    }
                    break;
            }
        }
    }
    debug($searchResults);
}
?>
