<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Navigation
 */
/**
 * GalNav Helper
 * 
 * @package       bindery
 * @subpackage    bindery.Navigation
 */
class GalNavHelper extends HtmlHelper {

    var $helpers = array('Paginator');

	function pictureListItem() {
	//<li%s><p><span class='number'>%s</span><a href='%s'><br/><img src='%s' title='Example%s' alt='Example %s' /></a></p></li>\n
            echo String::insert(
                "<li :liClass><p><span class='number'>:number</span><a href=:url><br/><img src=:imgUrl title='Example:number' alt=:alt /></a></p></li>\n", 
                array(
                    'liClass' => '', 
                    'number' => $count, 
                    'url' => array('id'=>$record['Dispatch']['id']),
                    'imgUrl' => DS.'bindery2.0'.DS.'img'.DS.'images'.DS.'thumb'.DS.'x75y56'.DS.$record['Dispatch']['image'],
                    'alt' => $record['Dispatch']['alt']
                )
            );
        }

    /**
     * Create and return the gallery thumbnail page
     *
     * Makes an UL list of numbered thumbnail images that link to specific gallery pages
     * The numbers are so I can have direct discussion with customers on the phone
     * "go to Journals, then to page 2, then click item 12"
     * 
     * @todo This version has been modified in preoductGalleryThumbnails_x to change the divs for the new layout (12/11). When that version is properly re-writen and the changeoer is done, this should be deleted.
     * @param array $productExhibits Records for the current page of gallery thumbnails
     * @return string HTML of current gallery thumbnail page in a DIV
     */
    function productGalleryThumbnails($productExhibits) {
        $page = $this->Paginator->counter('%page%');
        $c = $this->Paginator->counter('%start%');
        $controller = explode(DS, $this->request->request->url);
        $product = (isset($this->request->params['pname']) && $this->request->params['pname'] != null) ? $this->request->params['pname'] . DS : null;
        $block = "";
        $cumm = '';

        $block = "<div class='gaWrapper'>
            <div class='galNav'>
              <ul>";
              //debug(IMAGES);
        
        foreach($productExhibits as $record) {
            $l = $this->link(
                $this->image(
                    'images'.DS.'thumb'.DS.'x54y54'.DS.$record['Exhibit']['img_file'],
                    array(
                        'alt'=>$record['Exhibit']['alt'],
                        'heading'=>$record['Exhibit']['heading']
                    )),
                $product.'gallery'.DS.$record['Exhibit']['id'].DS.'page:'.$page,
                array('escape'=> FALSE));
            $liClass = '';
            $number = $c++;
            $cumm .= "<li $liClass><p><span class='number'>$number</span>$l</p></li>\n";

        }

//    foreach($productExhibits as $record) {
//        $cumm .= String::insert(
//            "<li :liClass><p><span class='number'>:number</span><a href=:url><br/><img src=:imgUrl title=':heading' alt=:alt /></a></p></li>\n",
//            array(
//                'liClass' => '',
//                'number' => $c++,
//                'url' => APP_PATH.DS.$controller['0'].DS.$product.'gallery'.DS.$record['Exhibit']['id'].DS.'page:'.$page,
//                'imgUrl' => APP_PATH.DS.'img'.DS.'exhibits'.DS.'thumb'.DS.'x54y54'.DS.$record['Exhibit']['img_file'],
//                'alt' => $record['Exhibit']['alt'],
//                'heading' => $record['Exhibit']['heading']
//            )//                //'url' => DS.'bindery'.DS.$controller['0'].DS.$product.'gallery'.DS.$record['Exhibit']['id'].DS.'page:'.$page,

//        );
//    }
    $block .= $cumm . "</ul>\n\t\t</div> <!-- end of galNav -->\n\t</div> <!-- end of galWrapper -->";

    return $block;
    }

    /**
     * Produce and return the set of prev/page/next links for Product pages
     *
     * This does some housekeeping on the URL before building the links
     * because the action is completely hidden in the url and the
     * native tools make wrong guesses about link construction
     */
    function productPageLinks() {
        if (isset($this->request->params['pname'])) {
            $this->Paginator->options['url'] = array('action'=>$this->request->params['pname']);
            $controls = "{$this->Paginator->prev('Previous', null, null, array('class'=>'disabled'))} | {$this->Paginator->numbers()} | {$this->Paginator->next('Next', null, null, array('class'=>'disabled'))} <!-- THUMBNAIL PAGE SET NAVIGATION LINKS? -->";
        } else {
            $controls = str_replace('view/', '', "{$this->Paginator->prev('Previous', null, null, array('class'=>'disabled'))} | {$this->Paginator->numbers()} | {$this->Paginator->next('Next', null, null, array('class'=>'disabled'))} <!-- THUMBNAIL PAGE SET NAVIGATION LINKS? -->");
        }
        
        return"<div id='pagenav'>
            $controls
            </div>";
    }
    /**
     * Updated version 12/11
     * Create and return the gallery thumbnail page
     *
     * Makes an UL list of numbered thumbnail images that link to specific gallery pages
     * The numbers are so I can have direct discussion with customers on the phone
     * "go to Journals, then to page 2, then click item 12"
     * 
     * @param array $productExhibits Records for the current page of gallery thumbnails
     * @return string HTML of current gallery thumbnail page in a DIV
     */
    function productGalleryThumbnails_x($productExhibits) {
        $page = $this->Paginator->counter('%page%');
        $c = $this->Paginator->counter('%start%');
        $controller = explode(DS, $this->request->request->url);
        $product = (isset($this->request->params['pname']) && $this->request->params['pname'] != null) ? $this->request->params['pname'] . DS : null;
        $block = "";
        $cumm = '';

        $block = "<nav class='galNav'>
              <ul>";
              //debug(IMAGES);
        
        foreach($productExhibits as $record) {
            $l = $this->link(
                $this->image(
                    'images'.DS.'thumb'.DS.'x54y54'.DS.$record['Exhibit']['img_file'],
                    array(
                        'alt'=>$record['Exhibit']['alt'],
                        'heading'=>$record['Exhibit']['heading']
                    )),
                $product.'gallery'.DS.$record['Exhibit']['id'].DS.'page:'.$page,
                array('escape'=> FALSE));
            $liClass = '';
            $number = $c++;
            $cumm .= "<li $liClass><p><span class='number'>$number</span>$l</p></li>\n";

        }
    $block .= $cumm . "</ul>\n\t\t</nav> <!-- end of galNav -->\n";

    return $block;
    }

}