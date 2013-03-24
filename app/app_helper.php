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
    
    var $helpers = array ('Html','Time', 'Session', 'Form');
    
    function output($str, $tab = '') {
        echo "$tab$str\r";
    }
    
    /**
     * An accumulation/decumulation tool to build strings of tabs to format html output
     * 
     * @param string $tab A string with some number of tab characters
     * @param boolean $mode True to add a tab, false to remove one
     * @return string A string full of tabs or empty
     */
    function tab($tab, $mode = true){
        if($mode){
            return $tab . "\t";
        } elseif (strlen($tab)){
            return substr($tab, 0, -1);
        } else {
            return '';
        }
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
            $tool .= $this->Html->link('Log Out', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'logout'));
        } else {
            $tool .= $this->Html->link('Log In', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'login'));
            $tool .= ' | ';
            $tool .= $this->Html->link('Register', array('plugin' => null, 'prefix' => null, 'controller' => 'users', 'action' => 'register'));
        }
        return $tool;
    }
    
    /**
     * Extend the abilities of TextHelpers truncate()
     * 
     * This can version can force truncation of strings that 
     * fall below the truncation length, and allows setting
     * the number of chars to remove in such a case
     * 
     * @param string $text The string to truncate
     * @param type $length The max allowable length
     * @param type $force
     * @param type $force_length
     * @return type
     */
    function truncateText($text, $length = 100, $options = array()){
		$default = array(
			'force' => false, 'force_cut' => 10
		);
		$options = array_merge($default, $options);
		extract($options);
    //if text is shorter than lengh and $force is true, $force_length chars will drop anyway
        if($force){
            $count= strlen($text);
            $length = ($count<$length) ? $count-$force_cut : $length;
        }
        return TextHelper::truncate($text,$length,$options);
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
     * @return string Html-the div with search input and possibly hidden fields
     */
    function siteSearch($searchController=null) {
        if ($searchController == null) {
            $searchController = 'contents';
        }
        $tool = FormHelper::create($searchController, array(
            'url'=> array('controller'=> $searchController,'action'=>'search')
        ));
//        debug($this);die;
        $tool .= FormHelper::input('controller',array(
            'value' => $this->params['controller'],
            'name' => 'data[controller]',
            'type' => 'hidden'
            ))
            . FormHelper::input('action',array(
            'value' => $this->params['action'],
            'name' => 'data[action]',
            'type' => 'hidden'
            ));
//        if ($hidden !=null) {
//            foreach($hidden as $field=>$options) {
//                $tool .= FormHelper::input($field,$options+array('type'=>'hidden'));
//            }
//        }
        
        // This is the new, more cakey version
        $tool .= FormHelper::input('searchInput', array(
                'type'=>'text',
                'value'=>' Search',
                'name'=>'data[Standard][searchInput]',
//                'onblur'=>"if(this.value==''){this.value=' Search';}",
//                'onfocus'=>"if(this.value==' Search'){this.value=''}",
                'class'=>'siteSearchInput inputBox',
                'label'=>false,
                'div'=>false
            ));
        $tool .= "<input class='siteSearchButton' type='image' 
            src='/bindery/img/magnify.p.png' value = 'Submit' alt='Submit' />";
        $tool .= $this->Html->div('',
                $this->Html->link(
                'Advanced Search',
                "/contents/advanced_search",
                array(
                    'class' => 'advanced-search'
                )),
                array('id'=>'advanced-search')
             );

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
     * FilmStrip Generator for gallery pages
     * 
     * Loop throught the page data assembling the filmstrip,
     * previous/next links and .active highlighting
     * 
     * @param type $collection the data for this page
     * @param type $paginator paginator object
     * @param array $neighbors content_id indexed array describing all records in collection and their neighbors
     * @return html The filmstrip UL wrapped in a nav tag
     */
    function FilmStrip($collection, $paginator, $neighbors) {

        $previousPage = ($paginator->params['paging']['ContentCollection']['prevPage'])
        ? $paginator->params['paging']['ContentCollection']['page'] -1
        : $paginator->params['paging']['ContentCollection']['pageCount'];

        $pname = (isset($paginator->params['pname'])) ? DS.$paginator->params['pname'] : null;
        $page = (isset($paginator->params['paging']['ContentCollection']['page'])) ? DS.'page:'.$paginator->params['paging']['ContentCollection']['page'] : DS.'page:1';
        $id = (isset($paginator->params['id'])) ? DS.'id:' : false;

        $li = null;
        $path = 'images'.DS.'thumb'.DS.'x54y54'.DS;
        $number = 1+($paginator->params['paging']['ContentCollection']['page']-1) * $paginator->params['paging']['ContentCollection']['defaults']['limit'];
        $count = 0;
        $tMin = 1;
        $tMax = count($collection);

        // Make the image list items
        foreach($collection as $entry) {
            $count++;

            // On first count, calc the previous page link
            if ($count == 1){
                $previousPageImage = $neighbors[$entry['Content']['id']]['previous'];
                $previousPage = $neighbors[$previousPageImage]['page'];
            }
            
            //<img src="images/thumb/x54y54/IMG_9167.JPG" />
            if (isset($entry['Content']['Image']['img_file'])) {
                $image = $this->Html->image(
                    $path . $entry['Content']['Image']['img_file'], array(
                        'title' => $entry['Content']['Image']['title'],
                        'alt' => $entry['Content']['Image']['alt'],
                        'popacity' => 1-($count-$tMin+1)/($tMax-$tMin+2),
                        'nopacity' => ($count-$tMin+1)/($tMax-$tMin+2)
                    )
                );
            } else {
                $image = $this->Html->image('transparent.png',array('alt'=>'Missing Image',
                    'width'=>'54','height'=>'54'));
            }

            //<a class="thumb" href="static_nav4.php#1">1<br /><img ... /></a>
            if ($this->params['action']=='gallery') {
                $link = $this->Html->link($number++ . '<br />' . $image,
                         DS.'products'. $pname .DS.
                        $paginator->params['action']. $page .DS.
                        'id:'.$entry['Content']['id'],
                        array('escape'=>false,'class'=>'thumb')
                );
            } elseif ($this->params['action']=='art') {
        //        debug($this->params);
                $link = $this->Html->link($number++ . '<br />' . $image,
                    array(
        //                'controller'=>$this->params['controller'],
                        'action'=>$this->params['action'],
                        'pass'=>$this->params['pass'],
                        'page'=>$paginator->params['paging']['ContentCollection']['page'],
                        'id'=>$entry['Content']['id']),
                        array('escape'=>false,'class'=>'thumb')
                );
            } elseif ($this->params['action']=='newsfeed') {
                $link = $this->Html->link($number++ . '<br />' . $image,
                        'id#'.$entry['Content']['id'],
                        array('escape'=>false,'class'=>'thumb')
                );
            }

            // this sets the 'active' styling 
            // and calcs the next/prev image links
            if ($paginator->params['named']['id'] == $entry['Content']['id']) {
                $li .= $this->Html->tag('li', $link, array('class'=>'active'));
                $nextImage = $neighbors[$entry['Content']['id']]['next'];
                $previousImage = $neighbors[$entry['Content']['id']]['previous'];
                $nextImagePage = $neighbors[$nextImage]['page'];
                $previousImagePage = $neighbors[$previousImage]['page'];
            } else {
                $li .= $this->Html->tag('li', $link);
            }
        }

        //Now that we're out of the loop, 
        //calc the next page link from the last thumbnail
        $nextPageImage = $neighbors[$entry['Content']['id']]['next'];
        $nextPage = $neighbors[$nextPageImage]['page'];


        if($count < 9){
            $opacity = $count;
            while ($count < 9){
                $image = $this->Html->image('transparent.png',array('alt'=>'',
                    'width'=>'54','height'=>'54',
                    'popacity' => 1-($opacity-$tMin+1)/($tMax-$tMin+2),
                    'nopacity' => ($opacity-$tMin+1)/($tMax-$tMin+2)
                ));
                $link = $this->Html->link(' <br />' . $image,
                    '#',
                    array('escape'=>false,'class'=>'thumb_link')
                );
                $li .= $this->Html->tag('li', $link);
                $count++;
            }
        }
        
        // Make the next PAGE link
        $nPageImg = $this->Html->image(
            'nxt_arrow_drk.png', array(
                'title' => 'Next page',
                'alt' => 'Next page arrow'
            )
        );
        $nLink = $this->Html->link( $nPageImg,
            DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                'page:'.$nextPage.DS.
                'id:'.$nextPageImage,
                array('escape'=>false)
            ) . '<br />';

        // Make the next IMAGE link
        $nImage = $this->Html->image(
            'nxt_arrow_drk.png', array(
                'title' => 'Next image',
                'alt' => 'Next image arrow',
                'class' => 'npImageButton'
            )
        );
        if ($this->params['action']=='gallery') {
            $nLink .= $this->Html->link( $nImage,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$nextImagePage.DS.
                    'id:'.$nextImage,
                    array('escape'=>false)
                );
        } elseif ($this->params['action']=='newsfeed') {
            $nLink .= $this->Html->link( $nImage,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$neighbors[$neighbors[$paginator->params['named']['id']]['next']]['page'].DS.
                    'id:'.$neighbors[$paginator->params['named']['id']]['next'],
                    array('escape'=>false)
                );
        }

        // compile the next tags into an LI
        $next = $this->Html->tag('li', $nLink, array('class'=>'thumbButton nextButtons'));

        // Previous page link
        $pPageImg = $this->Html->image(
                    'prev_arrow_drk.png', array(
                        'title' => 'Previous page',
                        'alt' => 'Previous page arrow'
                    )
                );
        $pLink = $this->Html->link( $pPageImg,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$previousPage.DS.
                    'id:'.$previousPageImage,
                    array('escape'=>false)
                ) . '<br />';

        // Previous page link
        $pImage = $this->Html->image(
                    'prev_arrow_drk.png', array(
                        'title' => 'Previous image',
                        'alt' => 'previous image arrow',
                        'class' => 'npImageButton'
                    )
                );
        $pLink .= $this->Html->link( $pImage,
                DS.'products'.DS. $paginator->params['pname'].DS.$paginator->params['action'].DS. 
                    'page:'.$previousImagePage.DS.
                    'id:'.$previousImage,
                    array('escape'=>false)
                );

        // compile the previous tags into an LI
        $previous = $this->Html->tag('li', $pLink, array('class'=>'thumbButton previousButtons'));

        // merge the previous, image and next LIs
        $li = $previous . $li . $next;

        return $this->Html->tag(
                'nav',
                $this->Html->tag('ul', $li, array('class'=>'thumbList')),
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
                $image = $this->Html->image(
                    $path . $entry['img_file'], array(
                        'title' => $entry['title'],
                        'alt' => $entry['alt'],
                        'popacity' => 1-($number-$tMin+1)/($tMax-$tMin+2),
                        'nopacity' => ($number-$tMin+1)/($tMax-$tMin+2)
                    )
                )."\n";
            } else {
                $image = $this->Html->image('transparent.png',array('alt'=>'Missing Image',
                    'width'=>'54','height'=>'54'))."\n";
            }

        // <a class="thumb_link thumb" href="/bindery/products/publishing/newsfeed/page:1/#id408">1<br /><img ... /></a>
                $link = $this->Html->link($entry['neighbors']['count'] . "<br />\n" . $image,
                         $baseURL. $page .DS.
                        '#id'.$entry['id'],
                        array('escape'=>false,'class'=>'thumb_link thumb')
                )."\n";

            // this sets the 'active' styling
            if (isset($this->params['named']['id']) && $this->params['named']['id'] == $entry['content_id']) {
                $li .= $this->Html->tag('li', $link, array('class'=>'active'))."\n";
            } else {
                $li .= $this->Html->tag('li', $link);
            }
        } // end of the loop creating the image clickers

//debug($number);

        if($number < 9){
            $opacity = $number;
            while ($number < 9){
                $image = $this->Html->image('transparent.png',array('alt'=>'Missing Image',
                    'width'=>'54','height'=>'54',
                        'popacity' => 1-($opacity-$tMin+1)/($tMax-$tMin+2),
                        'nopacity' => ($opacity-$tMin+1)/($tMax-$tMin+2)))."\n";
                $link = $this->Html->link(' <br />' . $image,
                    '#',
                    array('escape'=>false,'class'=>'thumb_link thumb')
                )."\n";
                $li .= $this->Html->tag('li', $link);
                $number++;
            }
        }
        
    // Make the next page <img>
    $nPageImg = $this->Html->image(
        'nxt_arrow_drk.png', array(
            'title' => 'Next page',
            'alt' => 'Next page arrow'
        )
    )."\n";
    
    // Make the next page <a>
    $nLink = $this->Html->link( $nPageImg,
            $baseURL .DS. 
                'page:'.$nextPage.DS.
                '#id'. $entry['neighbors']['next'],
                array('escape'=>false,'class'=>'next_page')
            ) . '<br />'."\n";
    
    // Make the next image <img>
    $nImage = $this->Html->image(
        'nxt_arrow_drk.png', array(
            'title' => 'Next image',
            'alt' => 'Next image arrow',
            'class' => 'npImageButton'
        )
    )."\n";
    
    // Make the pervious page <img>
    $pPageImg = $this->Html->image(
        'prev_arrow_drk.png', array(
            'title' => 'Previous page',
            'alt' => 'Previous page arrow'
        )
    )."\n";
    
    // Make the previous page <a>
    $pLink = $this->Html->link( $pPageImg,
        $baseURL.DS. 
            'page:'.$previousPage.DS.
            '#id'.$previousImageID,
            array('escape'=>false,'class'=>'previous_page')
        ) . '<br />'."\n";

    // Make the previous image <img>
    $pImage = $this->Html->image(
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
    $nLink .= $this->Html->link( $nImage,
        $baseURL.DS. 
        'page:'.$entry['neighbors']['next_page'].DS.
        '#id'.$entry['neighbors']['next'],
        array('escape'=>false,'class'=>'thumb_next_image')
    )."\n";

    // Append and assemble the next image <a>
    $pLink .= $this->Html->link( $pImage,
        $baseURL.DS. 
        'page:'.$collectionPage[0]['neighbors']['previous_page'].DS.
        '#id'.$collectionPage[0]['neighbors']['previous'],
        array('escape'=>false,'class'=>'thumb_previous_image')
    )."\n";

    // compile the next page/image tags into an LI
    $next = $this->Html->tag('li', $nLink, array('class'=>'thumbButton nextButtons'));

    // compile the previous page/image tags into an LI
    $previous = $this->Html->tag('li', $pLink, array('class'=>'thumbButton previousButtons'));

    // merge the 'previous' <li>, image thumbnail <li>s and 'next' <li> into one big list
    $li = $previous . $li . $next;

    // bundle the list into a <ul> and that into a <nav>
    return $this->Html->tag(
        'nav',
        $this->Html->tag('ul', $li, array('class'=>'thumbList')),
        array('id'=>'galNav'));

    }
   
    /**
     * Output a newfeed link block for various landing pages
     * 
     * These blocks link to newsfeed pages and also have 
     * a link to the blog article presentation for the record.
     * These blocks are used as exploration-invitation blocks
     * on landing pages
     * 
     * Required structure
     * $new = Array
     *          [Content] => Array
     *                  [heading] => Jackson Nichol's Forcado portfolio
     *                  [id] => 494
     *                  [slug] => jackson-nichol-s-forcado-portfolio
     *                  [content] => I got a bit of a surprise when I ...
     *                  [created] => 2013-01-23 02:02:15
     *          [Image] => Array
     *                  [id] => 838
     *                  [title] => Jackson Nichol's Forcado portfolio
     *                  [alt] => The two shells for Jackson Nichol's portfolio ...
     *                  [img_file] => DSC01663.JPG
     *          [ContentCollection] => Array
     *                  [0] => Array
     *                          [content_id] => 494
     *                          [collection_id] => 60
     *                          [publish] => 1
     *                          [Collection] => Array
     *                                  [id] => 60
     *                                  [category_id] => 1469
     *                                  [heading] => Boxes
     *                                  [slug] => boxes
     * 
     *  <div class="linkDiv"
     *      <a href="/bindery/products/notebooks/newsfeed/id:32">   // $heading_link $link_uri
     *          <img title="Alligator notebook"     // $img
     *              alt="alt text" 
     *              id="im546" 
     *              src="/bindery/img/images/thumb/x160y120/DSC00241.JPG">
     *      </a>
     *      <p class="aside">On the bench: on 30/11/-1</p> 
     *      <a href="/bindery/products/notebooks/newsfeed/id:32">Alligator notebook</a>
     *      <p>content.</p> //$heading_link $clean markdown
     *      <p class="aside">Or view as a 
     *          <a href="/bindery/blog/58/alligator-notebook">Blog Article</a> $blog_link
     *      </p>
     *  </div>
     */
    function foundNewBlock($news, $path = 'images/thumb/x160y120/'){
    //foreach($news as $news){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');

        //remove links and image links from markdown content
        $clean = preg_replace($patterns, $replace,$news['Content']['content']);

        //assemble the image link
        $img = $this->Html->image($path.$news['Image']['img_file'], array(
            'id'=>'im'.$news['Image']['id'],
            'alt'=>$news['Image']['alt'],
            'title'=>$news['Image']['title']));

        // No page is sent with these and the id is encoded
        // as a named parameter so it's easy to pick up.
        // The newsfeed page detects this partial condition and
        // calculates the correct page, writes a URI and redirects
        // so the filmstrip can initialize and highlight properly
        $link_uri = array(
            'controller'=>'contents',
            'pname'=>$news['ContentCollection'][0]['Collection']['slug'],
            'action'=>'newsfeed',
            '/id:'.$news['Content']['id']);

        //make the heading into the <A> tag
        $blog_link = $this->Html->link('Blog Article',
            '/blog/'.$news['ContentCollection'][0]['collection_id']
            .'/'.$news['Content']['slug']);

        //and follow it with truncated markdown content
        $heading_link = $this->Html->link($this->Html->truncateText($news['Content']['heading'],45), 
            $link_uri, array('escape'=>false)) 
            . markdown($this->Html->truncateText($clean,100,array('force'=>true)))
            . $this->Html->para('aside',"Or view as a $blog_link");

        $image_link = $this->Html->link($img, $link_uri,array('escape'=>false));

        //and output everything in a left-floating div
        echo $this->Html->div('linkDiv', 
            $image_link 
            . $this->Html->para('aside',
            'On the bench: '
            . $this->Time->timeAgoInWords($news['Content']['created'])) 
            . $heading_link);
    //}
    }
    
    /**
     * Using the same data array as foundNewsBlock
     * 
     *  <div class="linkDiv">
     *      <p class="aside">Boxes: 4 days, 5 hours ago</p>
     *      <a href="/bindery/blog/60/jackson-nichol-s-forcado-portfolio">
     *          <img title="Jackson Nichol's Forcado portfolio" 
     *              alt="alt text" 
     *              id="im917" 
     *              src="/bindery/img/images/thumb/x75y56/DSC01983.JPG">
     *      </a>
     *      <a href="/bindery/blog/60/forcado-portfolio">Forcado portfolio</a>
     *  </div>
     * 
     * @param type $news
     * @param type $path
     */
    function blogMenuBlock($news, $path = 'images/thumb/x160y120/'){
    //foreach($news as $news){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');

        //remove links and image links from markdown content
        $clean = preg_replace($patterns, $replace,$news['Content']['content']);

        //assemble the image link
        $img = $this->Html->image($path.$news['Image']['img_file'], array(
            'id'=>'im'.$news['Image']['id'],
            'alt'=>$news['Image']['alt'],
            'title'=>$news['Image']['title']));

        //make the heading into the <A> tag
        $blog_uri = array(
            'controller'=>'contents',
            'action'=>'blog',
            $news['ContentCollection'][0]['collection_id'],
            $news['Content']['slug']
        );

        //and follow it with truncated markdown content
        $heading_link = $this->Html->link($this->Html->truncateText($news['Content']['heading'],35), 
            $blog_uri, array('escape'=>false));

        $image_link = $this->Html->link($img, $blog_uri,array('escape'=>false));

        //and output everything in a left-floating div
        echo $this->Html->div('linkDiv', 
            $this->Html->para('aside',
            $this->Html->truncateText($news['ContentCollection'][0]['Collection']['heading'],15,
                    array('exact'=>false,
                        'ending'=>'')).': '
            . $this->Time->timeAgoInWords($news['Content']['created'])) 
            . $image_link 
            . $heading_link);
    //}
    }
    
    /**
     * 
     *  <div class="linkDiv">
     *      <p class="aside">Notebooks: on 30/11/-1</p>
     *      <a href="/bindery/blog/58/alligator-notebook">
     *          <img title="Alligator Notebook" 
     *              alt="The cover of an alligator and goatskin notebook ready for top stitching." 
     *              id="im549" 
     *              src="/bindery/img/images/thumb/x160y120/DSC00189.JPG">
     *      </a>
     *      <a href="/bindery/blog/58/alligator-notebook">Alligator Notebook</a>
     *  </div>
     * 
     * @param type $news
     * @param type $path
     */
    function siteSearchBlogBlock($news, $path = 'images/thumb/x160y120/'){
    //foreach($news as $news){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');

        //remove links and image links from markdown content
        $clean = preg_replace($patterns, $replace,$news['Content']['content']);

        //assemble the image link
        $img = $this->Html->image($path.$news['Image']['img_file'], array(
            'id'=>'im'.$news['Image']['id'],
            'alt'=>$news['Image']['alt'],
            'title'=>$news['Image']['title']));

        //make the heading into the <A> tag
        $blog_uri = array(
            'controller'=>'contents',
            'action'=>'blog',
            $news['ContentCollection'][0]['collection_id'],
            $news['Content']['slug']
        );

        //and follow it with truncated markdown content
        $heading_link = $this->Html->link($this->Html->truncateText($news['Content']['heading'],35), 
            $blog_uri, array('escape'=>false));

        $image_link = $this->Html->link($img, $blog_uri,array('escape'=>false));

        //and output everything in a left-floating div
        echo $this->Html->div('linkDiv', 
            $this->Html->para('aside',
            $this->Html->truncateText($news['ContentCollection'][0]['Collection']['heading'],15,
                    array('exact'=>false,
                        'ending'=>'')).': '
            . $this->Time->timeAgoInWords($news['Content']['created'])) 
            . $image_link 
            . $heading_link);
    //}
    }
    
    /**
     * 
     *  <div class="linkDiv">
     *      <a href="/bindery/products/boxes/gallery/id:574">
     *          <img title="Non-traditional materials for an artist's portfolio" 
     *              alt="alt text" 
     *              src="/bindery/img/images/thumb/x160y120/DSC02030x.jpg">
     *      </a><p class="aside">Boxes</p>
     *      <a href="/bindery/products/boxes/gallery/id:574">Non-traditional mater ...</a>
     *      <p>The interior of a clamshell box with a book well and a foil ...</p>
     *  </div>
     * 
     * @param type $exhibit
     * @param type $path
     */
    function foundGalleryBlock($exhibit, $path = 'images/thumb/x160y120/'){
//        if ($exhibit['ContentCollection']['content_id']!=$last_update){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');
            
            //remove links and image links from markdown content
            $clean = preg_replace($patterns, $replace,$exhibit['Content']['content']);
            $collection = $this->Html->para('aside',$exhibit['Collection']['heading']);
            //make the heading into the <A> tag
            //and follow it with truncated markdown content
            $link_uri = DS.'products'.DS.$exhibit['Collection']['slug'].DS.'gallery'.DS.'id:'.$exhibit['Content']['id'];
            $heading_link = $this->Html->link($this->Html->truncateText($exhibit['Content']['heading'],45),$link_uri) 
                    . markdown($this->Html->truncateText($clean,100,array('force'=>true)));
            //assemble the image link
            $img = $this->Html->image($path.$exhibit['Content']['Image']['img_file'], array(
    //            'id'=>'im'.$exhibit['Content']['Image']['id'],
                'alt'=>$exhibit['Content']['Image']['alt'],
                'title'=>$exhibit['Content']['Image']['title']
            ));
            $image_link = $this->Html->link($img,$link_uri,array('escape'=>false));

        echo $this->Html->div('linkDiv', $image_link . $collection . $heading_link);
    }
    
    /**
     * 
     *  <div class="linkDiv">
     *      <a href="/bindery/products/notebooks/gallery/id:310">
     *          <img title="Calendars" 
     *              alt="" 
     *              src="/bindery/img/images/thumb/x160y120/DSCN5050.jpg">
     *      </a>
     *      <p class="aside">Notebooks</p>
     *      <a href="/bindery/products/notebooks/gallery/id:310">Calendars</a>
     *      <p>Many standard notebook fillers are available in...</p>
     *  </div>
     * 
     * @param type $exhibit
     * @param type $path
     */
    function siteSearchGalleryBlock($exhibit, $path = 'images/thumb/x160y120/'){
//        if ($exhibit['ContentCollection']['content_id']!=$last_update){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');
            
            //remove links and image links from markdown content
            $clean = preg_replace($patterns, $replace,$exhibit['Content']['content']);
            $collection = $this->Html->para('aside',$exhibit['ContentCollection'][0]['Collection']['heading']);
            //make the heading into the <A> tag
            //and follow it with truncated markdown content
            $link_uri = DS.'products'.DS.$exhibit['ContentCollection'][0]['Collection']['slug'].DS.'gallery'.DS.'id:'.$exhibit['Content']['id'];
            $heading_link = $this->Html->link($this->Html->truncateText($exhibit['Content']['heading'],45),$link_uri) 
                    . markdown($this->Html->truncateText($clean,100,array('force'=>true)));
            //assemble the image link
            $img = $this->Html->image($path.$exhibit['Image']['img_file'], array(
    //            'id'=>'im'.$exhibit['Content']['Image']['id'],
                'alt'=>$exhibit['Image']['alt'],
                'title'=>$exhibit['Image']['title']
            ));
            $image_link = $this->Html->link($img,$link_uri,array('escape'=>false));

        echo $this->Html->div('linkDiv', $image_link . $collection . $heading_link);
    }
    
    /**
     * 
     *  <div class="linkDiv">
     *      <a href="/bindery/products/45-minute-box/gallery/id:114">
     *          <img title="45 Minute Box" alt="alt text" 
     *              src="/bindery/img/images/thumb/x160y120/DSC01734.JPG">
     *      </a>
     *      <p class="aside">ID: 384 - 45 Minute Box</p>
     *      <a href="/bindery/products/45-minute-box/gallery/id:114">45 Minute Box</a>
     *      <p>Learn to make a professional looking box to e...</p>
     *  </div>
     * 
     * @param type $exhibit
     * @param type $path
     */
    function foundWorkshopBlock($exhibit, $path = 'images/thumb/x160y120/'){
//        if ($exhibit['ContentCollection']['content_id']!=$last_update){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');
            
            //remove links and image links from markdown content
            $clean = preg_replace($patterns, $replace,$exhibit['ContentCollection']['0']['Content']['content']);
            $collection = $this->Html->para('aside','ID: '.$exhibit['ContentCollection']['0']['Content']['id'].' - '.$exhibit['Workshop']['heading']);
            //make the heading into the <A> tag
            //and follow it with truncated markdown content
            $link_uri = DS.'products'.DS.$exhibit['Workshop']['slug'].DS.'gallery'.DS.'id:'.$exhibit['Workshop']['id'];
            $heading_link = $this->Html->link($this->Html->truncateText($exhibit['Workshop']['heading'],45),$link_uri) 
                    . markdown($this->Html->truncateText($clean,100,array('force'=>true)));
            //assemble the image link
            $img = $this->Html->image($path.$exhibit['ContentCollection']['0']['Content']['Image']['img_file'], array(
    //            'id'=>'im'.$exhibit['Workshop']['Image']['id'],
                'alt'=>$exhibit['ContentCollection']['0']['Content']['Image']['alt'],
                'title'=>$exhibit['ContentCollection']['0']['Content']['Image']['title']
            ));
            $image_link = $this->Html->link($img,$link_uri,array('escape'=>false));

        echo $this->Html->div('linkDiv', $image_link . $collection . $heading_link);
    }
    
    /**
     * 
     *  <div class="linkDiv">
     *      <a href="/bindery/products/just-facts-ma-39-am-notebook/gallery/id:388">
     *          <img title="Special material option" 
     *              alt="" 
     *              src="/bindery/img/images/thumb/x160y120/DSCN4470.jpg">
     *      </a>
     *      <p class="aside">ID: 388 - Just-the-Facts-Ma'am Notebook</p>
     *      <a href="/bindery/products/just-facts/gallery/id:388">Just-the-Facts</a>
     *      <p>You  ...</p>
     *  </div>
     * 
     * @param type $exhibit
     * @param type $path
     */
    function siteSearchWorkshopBlock($exhibit, $path = 'images/thumb/x160y120/'){
//        if ($exhibit['ContentCollection']['content_id']!=$last_update){

        $patterns = array('/[\[|!\[]/','/\]\([\s|\S]+\)/','/\s[\s]+/','/#/');
        $replace = array('','',' ','');
            
            //remove links and image links from markdown content
            $clean = preg_replace($patterns, $replace,$exhibit['Content']['content']);
            $collection = $this->Html->para('aside','ID: '.$exhibit['Content']['id'].' - '.$exhibit['Content']['heading']);
            //make the heading into the <A> tag
            //and follow it with truncated markdown content
            $link_uri = DS.'products'.DS.$exhibit['Content']['slug'].DS.'gallery'.DS.'id:'.$exhibit['Content']['id'];
            $heading_link = $this->Html->link($this->Html->truncateText($exhibit['Content']['heading'],45),$link_uri) 
                    . markdown($this->Html->truncateText($clean,100,array('force'=>true)));
            //assemble the image link
            $img = $this->Html->image($path.$exhibit['Image']['img_file'], array(
    //            'id'=>'im'.$exhibit['Workshop']['Image']['id'],
                'alt'=>$exhibit['Image']['alt'],
                'title'=>$exhibit['Image']['title']
            ));
            $image_link = $this->Html->link($img,$link_uri,array('escape'=>false));

        echo $this->Html->div('linkDiv', $image_link . $collection . $heading_link);
    }
}
?>