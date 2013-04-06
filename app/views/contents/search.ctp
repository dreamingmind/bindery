<?php
if($searchResults){
    foreach($searchResults as $category_name => $category_set){
        if($category_set){
            $this->set('category_name',$category_name);
            switch ($category_name){
                case 'dispatch':
                    echo $html->tag('h2','Blog Articles');
                    foreach($category_set as $result){
//                        debug($result);
                        echo $html->siteSearchBlogBlock($this->viewVars, $result);
                    }
                    break;
                case 'exhibit':
                    echo $html->tag('h2','Gallery Exhibits');
                    foreach($category_set as $result){
//                        debug($result);
                        echo $html->siteSearchGalleryBlock($this->viewVars, $result);
                    }
                    break;
                case 'art':
                    echo $html->tag('h2','Art & Editions');
                    foreach($category_set as $result){
//                        debug($result);
                        echo $html->siteSearchGalleryBlock($this->viewVars, $result);
                    }
                    break;
                case 'workshop':
                    echo $html->tag('h2','Workshops');
                    foreach($category_set as $result){
//                        debug($result);
                        echo $html->siteSearchWorkshopBlock($this->viewVars, $result);
                    }
                    break;
            }
        }
    }
    debug($searchResults);
}
?>
