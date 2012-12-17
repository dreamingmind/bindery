<?php
/* SVN FILE: $Id$ */
/**
 * Short description for file.
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       bindery
 * @subpackage    bindery.helper
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::import('Core', 'Helper', 'Session','Html');
/**
 * This is a placeholder class.
 * Create the same file in app/app_helper.php
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       bindery
 * @subpackage    bindery.helper
 * 
 * @property HtmlHelper $HtmlHelper
 * @property FormHelper $FormHelper
 */
class AppHelper extends Helper {
    function output($str) {
        echo $str . "\n";
    }
    
    /**
     * Modified for new layout 12/11
     * @param type $userdata
     * @return type 
     */
    function accountTool_($userdata) {
//        array_flip($this->Auth->allowedActions);
//        if(isset($this->Auth->allowedActions[$this->params['action']])){
//            $outController = 'pages';
//            $outAction = 'home';
//        } else {
//            $outController = $this->params['controller'];
//            $outAction = $this->params['action'];
//        }
        $tool = "<p>";
        if (isset($userdata) && $userdata != 0) {
            $tool .= $userdata['username'] . " | ";
            $tool .= HtmlHelper::link('Log Out', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'logout'));
        } else {
            $tool .= HtmlHelper::link('Log In', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'login'));
            $tool .= ' | ';
            $tool .= HtmlHelper::link('Register', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'register'));
        }
        return $tool;
    }

    /**
     * This is the main site search tool. Called from Layouts.
     * 
     * Every controller will have a search() method to catch POSTs from
     * this form to take context appropriate action.
     * 
     * Pass in an alternate controller if the active one isn't wanted
     * 
     * Pass in an array of hidden field data if the form post should carry
     * other page/state information.
     * 
     * @param string $searchController An alternate controller
     * @param array $hidden Hidden fields to carry with the search form
     * @return string Html-the div with search input and possibly hidden fields
     */
    function siteSearch($searchController=null, $hidden=null) {
        if ($searchController == null) {
            $searchController = Inflector::camelize( $this->params['controller']);
        }
        $tool = FormHelper::create($searchController, array(
//            'url'=> array('controller'=>$searchController,'action'=>$this->action)
            'url'=> array('controller'=> strtolower(Inflector::pluralize($searchController)),'action'=>'search')
        ));
        
        if ($hidden !=null) {
            foreach($hidden as $field=>$options) {
                $tool .= FormHelper::input($field,$options+array('type'=>'hidden'));
            }
        }
        
        // This is the new, more cakey version
        $tool .= FormHelper::input('searchInput', array(
                'type'=>'text',
                'value'=>' Search',
                'onblur'=>"if(this.value==''){this.value=' Search';}",
                'onfocus'=>"if(this.value==' Search'){this.value=''}",
                'class'=>'siteSearchInput inputBox',
                'label'=>false,
                'div'=>false
            ));
        $tool .= "<input class='siteSearchButton' type='image' 
            src='/bindery/img/magnify.p.png' value = 'Submit' alt='Submit' />";

        $tool .= FormHelper::end();

        return "<div id='siteSearchBox'>$tool</div>";
    }
        
    /**
     * Return next/previous links as appropriate
     * 
     * This was made to stick on a typical crud layout or other layout
     * where only the id needs to be provided in the link for proper function
     * 
     * @param string $model The name of the model being ID'd
     * @param array $neighbors A find('neighbors') result array
     * @return string an html link pair (if appropriate) in the form Previous | Next
     */
    function neighborRecords($model, $neighbors) {
        //print_r($neighbors);        print_r($model);
        
//        debug($this->Html);die;
        $tools = '';
        if(isset($neighbors['prev'][$model]['id'])) { 
            $tools .= $this->Html->link(__('Previous',true), array($neighbors['prev'][$model]['id'])); 
        }
        if (isset($neighbors['prev'][$model]['id']) && isset($neighbors['next'][$model]['id'])) {
            $tools .= '&nbsp;|&nbsp;';
        }
        if(isset($neighbors['next'][$model]['id'])) {
            $tools .= $this->Html->link(__('Next',true), array($neighbors['next'][$model]['id']));
        }
        $tools = ($tools == '') ? 'nothing' : $tools;
        return $tools;
    }
    
    /**
     * Prototype FilmStrip Generator
     * @todo make this into real code. Many missing data errors get through
     * @todo pack out 'short' lists to keep next/prev clickers in the same spot allways
     * @todo 'pack out' strategy: pull images from circlular wrap and show them or ghost them. How to handle nxt/prv clicks here-ideally redraw to correct target page
     * @todo still need the jump-box also
     * @todo page link construction needs to be more subtle to handle the many patterns that can occur. How about regex to insert page and id values into the whole url?
     * @todo this will probably need more parameters. Send in an array or figure out how to make properties available. HOLD on this for a while
     * 
     * @param array $collection The array of records to assemble into a film strip
     * @param object $paginator The paginator object currently in use in the view
     * @param array $neighbors array describing prev/next/page info for each picture in the filmstrip
     */

    function FilmStrip($collection, $paginator, $neighbors) {
//       debug($collection);die;
        $previousPage = ($paginator->params['paging']['ContentCollection']['prevPage'])
        ? $paginator->params['paging']['ContentCollection']['page'] -1
        : $paginator->params['paging']['ContentCollection']['pageCount'];

        $nextPage = ($paginator->params['paging']['ContentCollection']['nextPage'])
        ? $paginator->params['paging']['ContentCollection']['page'] + 1
        : 1;

$pname = (isset($paginator->params['pname'])) ? DS.$paginator->params['pname'] : null;
$page = (isset($paginator->params['paging']['ContentCollection']['page'])) ? DS.'page:'.$paginator->params['paging']['ContentCollection']['page'] : DS.'page:1';
$id = (isset($paginator->params['id'])) ? DS.'id:' : false;
//debug($collection);
//debug($filmStrip);
//debug($introduction);
//debug($exhibit);
//debug($this->params);

$li = null;
$path = 'images'.DS.'thumb'.DS.'x54y54'.DS;
$number = 1+($paginator->params['paging']['ContentCollection']['page']-1) * $paginator->params['paging']['ContentCollection']['defaults']['limit'];
$count = 0;
$tMin = 1;
$tMax = count($collection);


// Make the image list items
foreach($collection as $entry) {
    $count++;
    //<img src="images/thumb/x54y54/IMG_9167.JPG" />
    if (isset($entry['Content']['Image']['img_file'])) {
        $image = HtmlHelper::image(
            $path . $entry['Content']['Image']['img_file'], array(
                'title' => $entry['Content']['Image']['title'],
                'alt' => $entry['Content']['Image']['alt'],
                'popacity' => 1-($count-$tMin+1)/($tMax-$tMin+2),
                'nopacity' => ($count-$tMin+1)/($tMax-$tMin+2)
            )
        );
    } else {
        $image = HtmlHelper::image('transparent.png',array('alt'=>'Missing Image',
            'width'=>'54','height'=>'54'));
    }
    
    //<a class="thumb" href="static_nav4.php#1">1<br /><img ... /></a>
    if ($this->params['action']=='gallery') {
        $link = HtmlHelper::link($number++ . '<br />' . $image,
                 DS.'products'. $pname .DS.
                $paginator->params['action']. $page .DS.
                'id:'.$entry['Content']['id'],
                array('escape'=>false,'class'=>'thumb')
        );
    } elseif ($this->params['action']=='art') {
//        debug($this->params);
        $link = HtmlHelper::link($number++ . '<br />' . $image,
            array(
//                'controller'=>$this->params['controller'],
                'action'=>$this->params['action'],
                'pass'=>$this->params['pass'],
                'page'=>$paginator->params['paging']['ContentCollection']['page'],
                'id'=>$entry['Content']['id']),
                array('escape'=>false,'class'=>'thumb')
        );
    } elseif ($this->params['action']=='newsfeed') {
        $link = HtmlHelper::link($number++ . '<br />' . $image,
                'id#'.$entry['Content']['id'],
                array('escape'=>false,'class'=>'thumb')
        );
    }

    // this sets the 'active' styling
    if ($paginator->params['named']['id'] == $entry['Content']['id']) {
        $li .= HtmlHelper::tag('li', $link, array('class'=>'active'));
    } else {
        $li .= HtmlHelper::tag('li', $link);
    }
}

if($count < 9){
    $opacity = $count;
    while ($count < 9){
        $image = HtmlHelper::image('transparent.png',array('alt'=>'',
            'width'=>'54','height'=>'54',
            'popacity' => 1-($opacity-$tMin+1)/($tMax-$tMin+2),
            'nopacity' => ($opacity-$tMin+1)/($tMax-$tMin+2)
        ));
        $link = HtmlHelper::link(' <br />' . $image,
            '#',
            array('escape'=>false,'class'=>'thumb_link')
        );
        $li .= HtmlHelper::tag('li', $link);
        $count++;
    }
}
// Make the next PAGE link
$nPageImg = HtmlHelper::image(
            'nxt_arrow_drk.png', array(
                'title' => 'Next page',
                'alt' => 'Next page arrow'
            )
        );
        $nLink = HtmlHelper::link( $nPageImg,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$nextPage.DS.
                    'id:'.$paginator->params['named']['id'],
                    array('escape'=>false)
                ) . '<br />';

// Make the next IMAGE link
$nImage = HtmlHelper::image(
            'nxt_arrow_drk.png', array(
                'title' => 'Next image',
                'alt' => 'Next image arrow',
                'class' => 'npImageButton'
            )
        );
    if ($this->params['action']=='gallery') {
        $nLink .= HtmlHelper::link( $nImage,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$neighbors[$neighbors[$paginator->params['named']['id']]['next']]['page'].DS.
                    'id:'.$neighbors[$paginator->params['named']['id']]['next'],
                    array('escape'=>false)
                );
    } elseif ($this->params['action']=='newsfeed') {
$nLink .= HtmlHelper::link( $nImage,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$neighbors[$neighbors[$paginator->params['named']['id']]['next']]['page'].DS.
                    'id:'.$neighbors[$paginator->params['named']['id']]['next'],
                    array('escape'=>false)
                );
    }

// compile the next tags into an LI
$next = HtmlHelper::tag('li', $nLink, array('class'=>'thumbButton nextButtons'));

// Previous page link
$pPageImg = HtmlHelper::image(
            'prev_arrow_drk.png', array(
                'title' => 'Previous page',
                'alt' => 'Previous page arrow'
            )
        );
$pLink = HtmlHelper::link( $pPageImg,
        DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
            'page:'.$previousPage.DS.
            'id:'.$paginator->params['named']['id'],
            array('escape'=>false)
        ) . '<br />';

// Previous page link
$pImage = HtmlHelper::image(
            'prev_arrow_drk.png', array(
                'title' => 'Previous image',
                'alt' => 'previous image arrow',
                'class' => 'npImageButton'
            )
        );
$pLink .= HtmlHelper::link( $pImage,
        DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
            'page:'.$neighbors[$neighbors[$paginator->params['named']['id']]['previous']]['page'].DS.
            'id:'.$neighbors[$paginator->params['named']['id']]['previous'],
            array('escape'=>false)
        );

// compile the previous tags into an LI
$previous = HtmlHelper::tag('li', $pLink, array('class'=>'thumbButton previousButtons'));

// merge the previous, image and next LIs
$li = $previous . $li . $next;

return HtmlHelper::tag(
        'nav',
        HtmlHelper::tag('ul', $li, array('class'=>'thumbList')),
        array('id'=>'galNav'));

    }
    
    /**
     * Prepare a table-row style input
     * 
     * Add options to the input options to make a 
     * pair of cells: <td>label</td><td>input</td>
     * 
     * @param array $option The input options
     * @return string The html fragment 
     */
    function formTRow($options=null) {
        $options = ($options == null) ? array() : $options;
        return $options + array(
            'before'=>"\t\t<td>",
            'between'=>"</td>\r\t\t<td>",
            'after' => "</td>\r",
            'div' => false
        );
    }

    /**
     * Construct the full FilmStrip for Newsfeed pages
     * 
     * The FilmStrip is an unordered list wrapped in a <nav> tag.
     * 1st LI contains previous page and previous image clickers
     * 2nd through tMax LIs contain numbered image thumbnail clickers
     * Last LI contains next page and next image clickers
     * 
     * $collectionPage sample record
     *  [0] => Array
     *  (
     *      [id] => 416
     *      [heading] => Gift Grimoire
     *      [content] => I did a little preliminary dying on this ...
     *      [alt] => Laying the leather down on a baj relief book cover
     *      [title] => Gift Grimoire
     *      [content_collection_id] => 349
     *      [image_id] => 762
     *      [date] => 1355182020
     *      [img_file] => DSC01279x.jpg
     *      [collections] => Array
     *          (
     *              [62] => otherproducts
     *              [59] => publishing
     *              [72] => In the Studio
     *          )
     *
     *      [neighbors] => Array
     *          (
     *              [page] => 1
     *              [count] => 1
     *              [previous] => 398
     *              [previous_page] => 2
     *              [previous_count] => 11
     *              [next] => 408
     *              [next_page] => 1
     *              [next_count] => 2
     *          )
     *  )
     * 
     * $pageData sample record
     * Array
     *  (
     *      [count] => 11
     *      [page] => 1
     *      [pages] => 2
     *      [current] => 9
     *      [start] => 1
     *      [end] => 9
     *      [next] => 2
     *      [previous] => 2
     *  )
     * 
     * @param type $collectionPage Content record data and much more (see above)
     * @param type $pageData Array of info about this page, the next page, the previous page
     * @return type
     */
   function newsfeedFilmStrip($collectionPage, $pageData) {
//       debug($collection);die;
        $previousPage = $pageData['previous'];
        $nextPage = $pageData['next'];

//        $pname = (isset($this->params['pname'])) ? DS.  $this->params['pname'] : null;
        $page = DS.'page:'.$pageData['page'];
//        $id = (isset($paginator->params['id'])) ? DS.'id:' : false;
        $li = null;
        $path = 'images'.DS.'thumb'.DS.'x54y54'.DS;
        $baseURL = DS.'products'.DS. $this->params['pname'].DS.$this->params['action'] ;
//        $number = 1+($paginator->params['paging']['ContentCollection']['page']-1) * $paginator->params['paging']['ContentCollection']['defaults']['limit'];
        $number = 0;
        $tMin = 1;
        $tMax = count($collectionPage);

        // Make the image list items
        foreach($collectionPage as $entry) {
            $number++;

            if ($number == 1){
                // we'll need to know this one value later for prevPage link
                $previousImageID = $entry['neighbors']['previous'];
            }
        // <img nopacity="0.2" popacity="0.8" alt="An improve..." src="/bindery/img/images/thumb/x54y54/DSC01242.JPG">
            if (isset($entry['img_file'])) {
                $image = HtmlHelper::image(
                    $path . $entry['img_file'], array(
                        'title' => $entry['title'],
                        'alt' => $entry['alt'],
                        'popacity' => 1-($number-$tMin+1)/($tMax-$tMin+2),
                        'nopacity' => ($number-$tMin+1)/($tMax-$tMin+2)
                    )
                )."\n";
            } else {
                $image = HtmlHelper::image('transparent.png',array('alt'=>'Missing Image',
                    'width'=>'54','height'=>'54'))."\n";
            }

        // <a class="thumb_link thumb" href="/bindery/products/publishing/newsfeed/page:1/#id408">1<br /><img ... /></a>
                $link = HtmlHelper::link($entry['neighbors']['count'] . "<br />\n" . $image,
                         $baseURL. $page .DS.
                        '#id'.$entry['id'],
                        array('escape'=>false,'class'=>'thumb_link thumb')
                )."\n";

            // this sets the 'active' styling
            if (isset($this->params['named']['id']) && $this->params['named']['id'] == $entry['content_id']) {
                $li .= HtmlHelper::tag('li', $link, array('class'=>'active'))."\n";
            } else {
                $li .= HtmlHelper::tag('li', $link);
            }
        } // end of the loop creating the image clickers

//debug($number);

        if($number < 9){
            $opacity = $number;
            while ($number < 9){
                $image = HtmlHelper::image('transparent.png',array('alt'=>'Missing Image',
                    'width'=>'54','height'=>'54',
                        'popacity' => 1-($opacity-$tMin+1)/($tMax-$tMin+2),
                        'nopacity' => ($opacity-$tMin+1)/($tMax-$tMin+2)))."\n";
                $link = HtmlHelper::link(' <br />' . $image,
                    '#',
                    array('escape'=>false,'class'=>'thumb_link thumb')
                )."\n";
                $li .= HtmlHelper::tag('li', $link);
                $number++;
            }
        }
        
    // Make the next page <img>
    $nPageImg = HtmlHelper::image(
        'nxt_arrow_drk.png', array(
            'title' => 'Next page',
            'alt' => 'Next page arrow'
        )
    )."\n";
    
    // Make the next page <a>
    $nLink = HtmlHelper::link( $nPageImg,
            $baseURL .DS. 
                'page:'.$nextPage.DS.
                '#id'. $entry['neighbors']['next'],
                array('escape'=>false,'class'=>'next_page')
            ) . '<br />'."\n";
    
    // Make the next image <img>
    $nImage = HtmlHelper::image(
        'nxt_arrow_drk.png', array(
            'title' => 'Next image',
            'alt' => 'Next image arrow',
            'class' => 'npImageButton'
        )
    )."\n";
    
    // Make the pervious page <img>
    $pPageImg = HtmlHelper::image(
        'prev_arrow_drk.png', array(
            'title' => 'Previous page',
            'alt' => 'Previous page arrow'
        )
    )."\n";
    
    // Make the previous page <a>
    $pLink = HtmlHelper::link( $pPageImg,
        $baseURL.DS. 
            'page:'.$previousPage.DS.
            '#id'.$previousImageID,
            array('escape'=>false,'class'=>'previous_page')
        ) . '<br />'."\n";

    // Make the previous image <img>
    $pImage = HtmlHelper::image(
        'prev_arrow_drk.png', array(
            'title' => 'Previous image',
            'alt' => 'previous image arrow',
            'class' => 'npImageButton'
        )
    )."\n";

    // These are the bad links for next/previous image clickers on newsfeed
    // We have to know the current target image's id so the proper
    // $neighbors entry can be pulled.
    // Once corrected, this code will serve for initial page entry
    // but clicking a thumbnail or one of these next-image arrows
    // will have to use javascript to update everything.
    // The jumpbox will have to be fixed with javascript too.
    
    // Append and assemble the next image <a>
    $nLink .= HtmlHelper::link( $nImage,
        $baseURL.DS. 
        'page:'.$entry['neighbors']['next_page'].DS.
        '#id'.$entry['neighbors']['next'],
        array('escape'=>false,'class'=>'thumb_next_image')
    )."\n";

    // Append and assemble the next image <a>
    $pLink .= HtmlHelper::link( $pImage,
        $baseURL.DS. 
        'page:'.$collectionPage[0]['neighbors']['previous_page'].DS.
        '#id'.$collectionPage[0]['neighbors']['previous'],
        array('escape'=>false,'class'=>'thumb_previous_image')
    )."\n";

    // compile the next page/image tags into an LI
    $next = HtmlHelper::tag('li', $nLink, array('class'=>'thumbButton nextButtons'));

    // compile the previous page/image tags into an LI
    $previous = HtmlHelper::tag('li', $pLink, array('class'=>'thumbButton previousButtons'));

    // merge the 'previous' <li>, image thumbnail <li>s and 'next' <li> into one big list
    $li = $previous . $li . $next;

    // bundle the list into a <ul> and that into a <nav>
    return HtmlHelper::tag(
        'nav',
        HtmlHelper::tag('ul', $li, array('class'=>'thumbList')),
        array('id'=>'galNav'));

    }
   

}
?>