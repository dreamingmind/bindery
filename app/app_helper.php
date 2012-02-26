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
 * @package       cake
 * @subpackage    cake.cake
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
 * @package       cake
 * @subpackage    cake.cake
 * 
 * @property HtmlHelper $HtmlHelper
 * @property FormHelper $FormHelper
 */
class AppHelper extends Helper {
    function output($str) {
        echo $str . "\n";
    }

    /**
     * @todo This is for the original layout and should be deleted once things are switched  over
     * @param type $userdata
     * @return type 
     */
    function accountTool($userdata) {
        $tool = "<div id='accountTool'><p>";
        if (isset($userdata) && $userdata != 0) {
            $tool .= $userdata['username'] . " | ";
            $tool .= HtmlHelper::link('Log Out', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'logout'));
        } else {
            $tool .= HtmlHelper::link('Log In', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'login'));
            $tool .= ' | ';
            $tool .= HtmlHelper::link('Register', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'register'));
        }
        return $tool . "</p></div>";
    }
    
    /**
     * Modified for new layout 12/11
     * @param type $userdata
     * @return type 
     */
    function accountTool_($userdata) {
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
//$number = 1;

// Make the image list items
foreach($collection as $entry) {
    //<img src="images/thumb/x54y54/IMG_9167.JPG" />
    if (isset($entry['Content']['Image']['img_file'])) {
        $image = HtmlHelper::image(
            $path . $entry['Content']['Image']['img_file'], array(
                'title' => $entry['Content']['Image']['title'],
                'alt' => $entry['Content']['Image']['alt']
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
                '#id'.$entry['Content']['id'],
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

// Make the next PAGE link
$nPageImg = HtmlHelper::image(
            'nxt_arrow_lt.png', array(
                'title' => 'Next page',
                'alt' => 'Next page arrow'
            )
        );
        $nLink = HtmlHelper::link( $nPageImg,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$nextPage.DS.
                    'id:'.$paginator->params['named']['id'],
                    array('escape'=>false,'class'=>'thumb')
                ) . '<br />';

// Make the next IMAGE link
$nImage = HtmlHelper::image(
            'nxt_arrow_lt.png', array(
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
                    array('escape'=>false,'class'=>'thumb')
                );
    } elseif ($this->params['action']=='newsfeed') {
$nLink .= HtmlHelper::link( $nImage,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$neighbors[$neighbors[$paginator->params['named']['id']]['next']]['page'].DS.
                    '#id'.$neighbors[$paginator->params['named']['id']]['next'],
                    array('escape'=>false,'class'=>'thumb')
                );
    }

// compile the next tags into an LI
$next = HtmlHelper::tag('li', $nLink, array('class'=>'thumbButton'));

// Previous page link
$pPageImg = HtmlHelper::image(
            'prev_arrow_lt.png', array(
                'title' => 'Previous page',
                'alt' => 'Previous page arrow'
            )
        );
$pLink = HtmlHelper::link( $pPageImg,
        DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
            'page:'.$previousPage.DS.
            'id:'.$paginator->params['named']['id'],
            array('escape'=>false,'class'=>'thumb')
        ) . '<br />';

// Previous page link
$pImage = HtmlHelper::image(
            'prev_arrow_lt.png', array(
                'title' => 'Previous image',
                'alt' => 'previous image arrow',
                'class' => 'npImageButton'
            )
        );
$pLink .= HtmlHelper::link( $pImage,
        DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
            'page:'.$neighbors[$neighbors[$paginator->params['named']['id']]['previous']]['page'].DS.
            'id:'.$neighbors[$paginator->params['named']['id']]['previous'],
            array('escape'=>false,'class'=>'thumb')
        );

// compile the previous tags into an LI
$previous = HtmlHelper::tag('li', $pLink, array('class'=>'thumbButton'));

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

   function newsfeedFilmStrip($collectionPage, $pageData) {
//       debug($collection);die;
        $previousPage = $pageData['previous'];
        $nextPage = $pageData['next'];

        $pname = (isset($this->params['pname'])) ? DS.  $this->params['pname'] : null;
        $page = DS.'page:'.$pageData['page'];
        $id = (isset($paginator->params['id'])) ? DS.'id:' : false;
//        debug($pname);
//        debug($page);
//        debug($id);
//        debug($previousPage);
//        debug($nextPage);
//        debug($collectionPage);
//        die;
        $li = null;
        $path = 'images'.DS.'thumb'.DS.'x54y54'.DS;
        $baseURL = DS.'products'.DS. $this->params['pname'].DS.$this->params['action'] ;
//        $number = 1+($paginator->params['paging']['ContentCollection']['page']-1) * $paginator->params['paging']['ContentCollection']['defaults']['limit'];
//$number = 1;

// Make the image list items
foreach($collectionPage as $entry) {
    //<img src="images/thumb/x54y54/IMG_9167.JPG" />
    if (isset($entry['img_file'])) {
        $image = HtmlHelper::image(
            $path . $entry['img_file'], array(
                'title' => $entry['title'],
                'alt' => $entry['alt']
            )
        );
    } else {
        $image = HtmlHelper::image('transparent.png',array('alt'=>'Missing Image',
            'width'=>'54','height'=>'54'));
    }
    
    //<a class="thumb" href="static_nav4.php#1">1<br /><img ... /></a>
    if ($this->params['action']=='gallery') {
        $link = HtmlHelper::link($entry['neighbors']['count'] . '<br />' . $image,
                 $baseURL. $page .DS.
                'id:'.$entry['content_id'],
                array('escape'=>false,'class'=>'thumb_link')
        );
    } elseif ($this->params['action']=='art') {
//        debug($this->params);
        $link = HtmlHelper::link($entry['neighbors']['count'] . '<br />' . $image,
            array(
//                'controller'=>$this->params['controller'],
                'action'=>$this->params['action'],
                'pass'=>$this->params['pass'],
                'page'=>$paginator->params['paging']['ContentCollection']['page'],
                'id'=>$entry['Content']['id']),
                array('escape'=>false,'class'=>'thumb_link')
        );
    } elseif ($this->params['action']=='newsfeed') {
        $link = HtmlHelper::link($entry['neighbors']['count'] . '<br />' . $image,
                '#id'.$entry['content_id'],
                array('escape'=>false,'class'=>'thumb_link')
        );
    }

    // this sets the 'active' styling
    if (isset($this->params['named']['id']) && $this->params['named']['id'] == $entry['content_id']) {
        $li .= HtmlHelper::tag('li', $link, array('class'=>'active'));
    } else {
        $li .= HtmlHelper::tag('li', $link);
    }
}

// Make the next PAGE link
    $nPageImg = HtmlHelper::image(
        'nxt_arrow_lt.png', array(
            'title' => 'Next page',
            'alt' => 'Next page arrow'
        )
    );
    $nLink = HtmlHelper::link( $nPageImg,
            $baseURL .DS. 
                'page:'.$nextPage,//.DS.
//                'id:'. $entry['neighbors']['next'],
                array('escape'=>false,'class'=>'thumb')
            ) . '<br />';

// Make the next IMAGE link
    $nImage = HtmlHelper::image(
        'nxt_arrow_lt.png', array(
            'title' => 'Next image',
            'alt' => 'Next image arrow',
            'class' => 'npImageButton'
        )
    );
    // Previous page link
    $pPageImg = HtmlHelper::image(
        'prev_arrow_lt.png', array(
            'title' => 'Previous page',
            'alt' => 'Previous page arrow'
        )
    );
    $pLink = HtmlHelper::link( $pPageImg,
        $baseURL.DS. 
            'page:'.$previousPage,//.DS.
//            'id:'.$entry['neighbors']['previous'],
            array('escape'=>false,'class'=>'thumb')
        ) . '<br />';

    // Previous page link
    $pImage = HtmlHelper::image(
        'prev_arrow_lt.png', array(
            'title' => 'Previous image',
            'alt' => 'previous image arrow',
            'class' => 'npImageButton'
        )
    );
    if ($this->params['action']=='gallery') {
        $nLink .= HtmlHelper::link( $nImage,
            $baseURL.DS. 
            'page:'.$nextPage.DS.
            'id:'.$entry['neighbors']['next_page'],
            array('escape'=>false,'class'=>'thumb')
        );
        $pLink .= HtmlHelper::link( $pImage,
            $baseURL.DS. 
            'page:'.$collectionPage[0]['neighbors']['previous_page'].DS.
            'id:'.$collectionPage[0]['neighbors']['previous'],
            array('escape'=>false,'class'=>'thumb')
        );
    } elseif ($this->params['action']=='newsfeed') {
        $nLink .= HtmlHelper::link( $nImage,
            $baseURL.DS. 
            'page:'.$entry['neighbors']['next_page'].DS.
            '#id'.$entry['neighbors']['next'],
            array('escape'=>false,'class'=>'thumb_next_image')
        );
        $pLink .= HtmlHelper::link( $pImage,
            $baseURL.DS. 
            'page:'.$collectionPage[0]['neighbors']['previous_page'].DS.
            '#id'.$collectionPage[0]['neighbors']['previous'],
            array('escape'=>false,'class'=>'thumb_previous_image')
        );
    }

    // compile the next tags into an LI
    $next = HtmlHelper::tag('li', $nLink, array('class'=>'thumbButton'));

//    $pLink .= HtmlHelper::link( $pImage,
//        $baseURL.DS. 
//            'page:'.$entry['neighbors']['previous_page'].DS.
//            'id:'.$entry['neighbors']['previous'],
//            array('escape'=>false,'class'=>'thumb')
//        );

    // compile the previous tags into an LI
    $previous = HtmlHelper::tag('li', $pLink, array('class'=>'thumbButton'));

    // merge the previous, image and next LIs
    $li = $previous . $li . $next;

    return HtmlHelper::tag(
        'nav',
        HtmlHelper::tag('ul', $li, array('class'=>'thumbList')),
        array('id'=>'galNav'));

    }
   

}
?>