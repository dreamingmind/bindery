<?php
if($searchResults){
    debug($searchResults);
    foreach($searchResults as $category_name => $category_set){
        if($category_set){
            $this->set('category_name',$category_name);
            switch ($category_name){
                case 'dispatch':
                    $count = 0;
                    echo $html->tag('h2','Blog Articles',array('id'=>'searchCategory'));
                    foreach($category_set as $result){
                        $count++;
//                        debug($result);
                        $link = $html->siteSearchBlogBlock($this->viewVars, $result);
                        $this->Html->twoColLinks($count, $link);
                    }
                    if($count % 2 == 1){
                         // if we ended on an odd, we have to close the div
                         echo '</div>';
                    }
                    break;
                case 'exhibit':
                    $count = 0;
                    echo $html->tag('h2','Gallery Exhibits',array('id'=>'searchCategory'));
                    foreach($category_set as $result){
//                        debug($result);
                        $count++;
                        $link = $html->siteSearchGalleryBlock($this->viewVars, $result);
                        $this->Html->twoColLinks($count, $link);
                    }
                    if($count % 2 == 1){
                         // if we ended on an odd, we have to close the div
                         echo '</div>';
                    }
                    break;
                case 'art':
                    $count = 0;
                    echo $html->tag('h2','Art & Editions',array('id'=>'searchCategory'));
                    foreach($category_set as $result){
//                        debug($result);
                        $count++;
                        $link = $html->siteSearchArtBlock($this->viewVars, $result);
                        $this->Html->twoColLinks($count, $link);
                    }
                    if($count % 2 == 1){
                         // if we ended on an odd, we have to close the div
                         echo '</div>';
                    }
                    break;
                case 'workshop':
                    $count = 0;
                    echo $html->tag('h2','Workshops',array('id'=>'searchCategory'));
                    foreach($category_set as $result){
//                        debug($result);
                        $count++;
                        $link = $html->siteSearchWorkshopBlock($this->viewVars, $result);
                        $this->Html->twoColLinks($count, $link);
                    }
                    if($count % 2 == 1){
                         // if we ended on an odd, we have to close the div
                         echo '</div>';
                    }
                    break;
            }
        }
    }
//    debug($searchResults);
}
?>
