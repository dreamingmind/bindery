<?php
App::import('Sanitize');
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
/**
 * ContentsController
 * 
 * Handles splash page content
 * @package       bindery
 * @subpackage    bindery.controller
 * @todo get something that can list the content records that belong to no collection
 * @todo search all occurances of dispatch in code and fix
 * @todo search all occurances of exhibit in code and fix
 * @todo method to pull the ID'd Content record with its Collection memberships, Detail link data, and Image data
 * @todo method to pull a page of thumbnail construction data
 * @todo method to pull a full page of Content records
 * @todo define how an article can be paged. Each section head defines a collection of Content records that equivalent to a page of thumbnails. So the articl TOC is actuall a prev/next page clicker analog.
 * @todo the many $page-Whatever vars are to modify pagination and could be grouped into an array rather than done singly
 * 
 * @property AuthComponent $Auth
 * @property SessionComponent $Session
 * @property AclComponents $Acl
*/
class ContentsController extends AppController {

    var $name = 'Contents';
        
    var $uses = array('Content','Catalog');
    
    /**
     * @var string $layout The default layout for content has the thumbnail strip at the top
     */
    var $layout = 'thumbnailPage';

    /**
     * @var int $pageLimit The number of images to show in a SlideStrip page for Collection navigation
     * @todo figure out how to handle the 'limit' setting for the strip. Right now it just gets set to 9, but it should be editable by the user.
     */
    var $pageLimit = 9;
    
    /**
     * @var array $pageOrder The order parameter for pagination of the SlideStrip
     */
    var $pageOrder = array();

    /**
     * @var array $pageGroup To group results into publish/unpublished for admin operations
     */
    var $pageGroup = array();

    /**
     * @var array $pageFields The fields parameter for pagination of the SlideStrip
     */
    var $pageFields = array();

    /**
     * @var array $pageContains The Contains parameter for pagination of the SlideStrip
     */
    var $pageContains = array();

     /**
     * @var array $pageConditions The conditons parameter for pagination of the SlideStrip
     */
    var $pageConditions = array();

    /**
     * next - the next page page (wraps to start)
     * previous - the previous page (wraps to end)
     * page - the current page displayed.
     * pages - total number of pages.
     * current - current number of records being shown.
     * count - the total number of records in the result set.
     * start - number of the first record being displayed.
     * end - number of the last record being displayed.

     * @var array $pageData pagination information 
     */
    var $pageData = array();
    
    /**
     *
     * @var array $collectionPage the data for this page (chunked from the full set returned from the model)
     */
    var $collectionPage = array();
    
    /** 
     * @var array $category data from the category found for the collection
     */
    var $category = array();
    
    /**
     * @var array $categoryNI list of categories name => id
     */
    var $categoryNI;

    /**
     * @var array $categoryIN list of categories id => name
     */
    var $categoryIN;
    
    /**
     * @var integer $firstYear The first year of archive Content/Image data for Advanced Search
     */
    var $firstYear = 2012;
    /**
     * @var array $month Selection list of months for Advanced Search
     */
    var $month = array(
        '00' => 'Select',
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );
    
    /**
     * @var array $season Selection list of seasons for Advanced Search
     */
    var $season = array(
        '0' => 'Select',
        '12-02' => 'Winter',
        '03-05' => 'Spring',
        '06-08' => 'Summer',
        '09-11' => 'Autumn',
        '01-02' => 'Valentine\'s',
        '10-12' => 'Winter Holiday'
    );
    
    /**
     * @var array $week Selection list of relative weeks for Advanced Search
     */
    var $week = array(
        '0' => 'Select',
        '1' => 'This week',
        '2' => 'Last week',
        '2.5' => 'Since last week',
        '3' => 'Two weeks ago',
        '3.5' => 'The last two weeks',
        '4' => 'Three weeks ago',
        '4.5' => 'The last three weeks',
        '5' => 'Four weeks ago',
        '5.5' => 'The last four weeks'
    );
 
    /**
     * @var string $result_ImagePath picks the size of image in search result blocks
     */
//    var $result_imagePath = 'images/thumb/x160y120/';
   /** 
     * beforeFilter
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(
                'gallery', 
                'newsfeed', 
                'art', 
                'jump',
                'products',
                'blog',
                'resequence',
                'product_landing',
                'advanced_search');
        $this->categoryNI = $this->Content->ContentCollection->Collection->Category->categoryNI;
        $this->categoryIN = $this->Content->ContentCollection->Collection->Category->categoryIN;
        }
        
    function afterFilter() {
        parent::afterFilter();
//        debug($this->viewVars);
//        die;
    }
    
//    function pullCategory($pname, $category){
//        $this->category = $this->Content->ContentCollection->Collection->Category->find(
//        'all',array(
//            'fields'=>array('id','name','supplement_list'),
//            'conditions'=>array('name'=>$category),
//            'contain'=>array(
//                'Collection'=>array(
//                    'fields'=>array('Collection.id','Collection.heading','Collection.slug','Collection.category_id'),
//                    'conditions'=>array('Collection.slug'=>$pname)
//                ))));
//    }
    
    function index() {
            $this->layout = 'noThumbnailPage';
            $this->Content->recursive = 0;
            $this->set('contents', $this->paginate());
    }

    function view($id = null) {
            $this->layout = 'noThumbnailPage';
            if (!$id) {
                    $this->Session->setFlash(__('Invalid content', true));
                    $this->redirect(array('action' => 'index'));
            }
            $this->set('content', $this->Content->read(null, $id));
    }

    function add() {
            $this->layout = 'noThumbnailPage';
            if (!empty($this->data)) {
                    $this->Content->create();
                    if ($this->Content->save($this->data)) {
                            $this->Session->setFlash(__('The content has been saved', true));
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.', true));
                    }
            }
            $navlines = $this->Content->Navline->find('list');
            $images = $this->Content->Image->find('list');
            $this->set(compact('navlines', 'images'));
    }

    function edit($id = null) {
            $this->layout = 'noThumbnailPage';
            if (!$id && empty($this->data)) {
                    $this->Session->setFlash(__('Invalid content', true));
                    $this->redirect(array('action' => 'index'));
            }
            if (!empty($this->data)) {
                    if ($this->Content->save($this->data)) {
                            $this->Session->setFlash(__('The content has been saved', true));
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The content could not be saved. Please, try again.', true));
                    }
            }
            if (empty($this->data)) {
                    $this->data = $this->Content->read(null, $id);
            }
            $images = $this->Content->Image->find('list');
            $this->set(compact('navlines', 'images'));
    }
    
    /**
     * Ajax Advanced Search
     */
    function advanced_search(){
        $this->layout = 'ajax';
        if ($this->data){
            //put save data in session for reuse
            //do search here
        }
        if(empty($this->data)){
            //check session for previous search data
            $y = $this->firstYear;
            $year = array(0=>'Select');
            while ($y <= date('Y', time())) {
                $year[$y] = $y;
                $y++;
            }
            $this->set('year',$year);
            $this->set('month',$this->month);
            $this->set('week',$this->week);
        }
    }
    
    /**
     * Ajax editing form for Gallery Exhibits
     * 
     * @param int $id The id of the record to pull for editing
     */
    function edit_exhibit($id=null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid content', true));
            debug($this->referer());die;
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
//            debug($this->data['ContentCollection'][0]);
            
            $result = 0; // 0 at the end means nothing saved properly
            $result_message = '';
            //save the Content portion
            if ($this->Content->save($this->data)) {
                $result_message = __('The content has been saved', true);
                $result += 1;
            } else {
                $result_message = __('The content could not be saved. Please, try again.', true);
            }
            if (isset($this->data['ContentCollection'][0]['Supplement'])){
                if ($this->Content->ContentCollection->Supplement->saveAll($this->data['ContentCollection'][0]['Supplement'])) {
                    $result_message .= __('<br />The supplements have been saved', true);
                    $result += 1;
                } else {
                    $result_message .= __('<br />The supplements could not be saved. Please, try again.', true);
                }
            }
            if ($this->Content->Image->save($this->data)) {
                $result_message .= __("<br />The image has been saved", true);
                $result += 1;
            } else {
                $result_message .= __("<br />The image could not be saved. Please, try again.", true);
            }
            $this->Session->setFlash($result_message);
            if($result > 0){
            // refresh the screen after everythign is saved
                $this->passedArgs = unserialize($this->data['Content']['passedArgs']);
                $this->params = unserialize($this->data['Content']['params']);
                $this->gallery();
                $this->render('gallery','thumbnailPage');
            } else{
                // SEE ISSUE 82 FOR THE DIRECTION TO GO ON THIS SECTION
            // if nothing saved, redraw the form
                $packet = $this->data;
                unset($this->data);
            }
        }
        if(empty($this->data)){
        $this->layout = 'ajax';
//        $this->layout = 'noThumbnailPage';
            $packet = $this->Content->find('all',array(
                'contain'=>array(
                    'Image',
                    'ContentCollection'=>array(
                        'Collection' =>array(
                            'Category'
                        ),
                        'Supplement'
                    )

                ),
                'conditions'=>array('Content.id'=>$id)
            ));
        $this->set('packet',$packet);
        }
//        $this->Session->setFlash('a test message');
    }
    
    function sample(){
        debug($this->data);die;
    }
    /**
     * Ajax editing form for newsfeed and blog dispatches
     * 
     * @param int $id The id of the record to pull for editing
     */
    function edit_dispatch($id=null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid content', true));
            debug($this->referer());die;
            $this->redirect($this->referer());
        }
        if (!empty($this->data)) {
            $this->params = unserialize($this->data['params']);
            $this->passedArgs = unserialize($this->data['passedArgs']);
//            debug($this->params);//die;
            $message = ($this->Content->saveAll($this->data['Content']))
                ? 'Content records saved'
                : 'Content record save failed';
            $message .= ($this->Content->Image->saveAll($this->data['Image']))
                ? "<br />Image records saved"
                : "<br />Image record save failed";
            $this->Session->setFlash($message);
            $this->redirect('/'.$this->params['url']['url'].'/#');
//            debug($this->data);die;
//            debug($this->data['ContentCollection'][0]);
            
//            $result = 0; // 0 at the end means nothing saved properly
//            $result_message = '';
//            //save the Content portion
//            if ($this->Content->save($this->data)) {
//                $result_message = __('The content has been saved', true);
//                $result += 1;
//            } else {
//                $result_message = __('The content could not be saved. Please, try again.', true);
//            }
//            if (isset($this->data['ContentCollection'][0]['Supplement'])){
//                if ($this->Content->ContentCollection->Supplement->saveAll($this->data['ContentCollection'][0]['Supplement'])) {
//                    $result_message .= __('<br />The supplements have been saved', true);
//                    $result += 1;
//                } else {
//                    $result_message .= __('<br />The supplements could not be saved. Please, try again.', true);
//                }
//            }
//            if ($this->Content->Image->save($this->data)) {
//                $result_message .= __("<br />The image has been saved", true);
//                $result += 1;
//            } else {
//                $result_message .= __("<br />The image could not be saved. Please, try again.", true);
//            }
//            $this->Session->setFlash($result_message);
//            if($result > 0){
//            // refresh the screen after everythign is saved
//                $this->passedArgs = unserialize($this->data['Content']['passedArgs']);
//                $this->params = unserialize($this->data['Content']['params']);
//                $this->gallery();
//                $this->render('gallery','thumbnailPage');
//            } else{
//                // SEE ISSUE 82 FOR THE DIRECTION TO GO ON THIS SECTION
//            // if nothing saved, redraw the form
//                $packet = $this->data;
//                unset($this->data);
//            }
        }
        if(empty($this->data)){
        $this->layout = 'ajax';
//        $this->layout = 'noThumbnailPage';
            $packet = $this->Content->find('all',array(
                'contain'=>array(
                    'Image',
                    'ContentCollection'=>array(
                        'Collection' =>array(
                            'Category'
                        )
                    )
                ),
                'conditions'=>array('Content.id'=>$id)
            ));
            $record[0]['Content'][$packet[0]['Content']['id']] = $packet[0]['Content'];
            $record[0]['Image'][$packet[0]['Content']['id']] = $packet[0]['Image'];
//            debug($_POST['collection'][0]);
//            debug($_POST);
//            debug($id);
//            debug($record);
            $this->set('linkNumber',$packet[0]['Content']['id']);
        $this->set('packet',$record);
//        // now pull unpublished images. Those are potential
//        // inline images.
        $iiLinks = $this->unpubImageLinks($_POST['collection'][0],$_POST['slug']);
        $this->set('iiLinks',$iiLinks);
        }
//        $this->Session->setFlash('a test message');
    }

    /**
     * Given a collection_id, create markdown links for inline images
     * 
     * Inline images for a collection will be unpublished ContentCollection records
     * Pull them and construct the markdown for inserting the image
     * into content. The reference number for the link is the image id (just in case)
     * 
     * As usual, Image provides alt and title tags
     * but can be over-ridden with alt and title in Content
     * 
     * I've included html for a caption for the inline picture.
     * If no caption is wanted, the Content.content field should be left empty
     * @todo these captions need css. hidden normally, show on rollover expansion.
     * 
     * @param int $collection The collection_id to query
     * @return string A block of text with all the link markdown
     */
    function unpubImageLinks($collection,$slug){
        $inlineImages = $this->Content->ContentCollection->find('all',array(
            'fields'=>array(
                'ContentCollection.collection_id',
                'ContentCollection.content_id',
                'ContentCollection.publish',
                'ContentCollection.seq'
            ),
            'contain'=>array(
                'Content'=>array(
                    'fields'=>array(
                        'Content.id',
                        'Content.image_id',
                        'Content.alt',
                        'Content.title',
                        'Content.content',
                        'Content.slug'
                    ),
                    'Image'=>array(
                        'fields'=>array(
                            'Image.id',
                            'Image.alt',
                            'Image.title',
                            'Image.img_file'
                        )
//                    ),
//                    'conditions'=>array(
//                        'Content.slug'=>$slug
                    )
                )
            ),
            'conditions'=>array(
                'Content.slug'=>$slug,
                'ContentCollection.collection_id'=>$collection,
                'ContentCollection.publish'=>0
            )
        ));
//        debug($inlineImages);
//        ![Final Lucha Libre hot stamp design elements][1]
//        [1]: LLpx005.jpg "Lucha Libre!"
        if(is_array($inlineImages)){
        $iiLinks = 'Unpublished Image links:</br>';
            foreach($inlineImages as $image){
                $index = $image['Content']['Image']['id'];
                $alt = ($image['Content']['alt']=='') ? $image['Content']['Image']['alt'] : $image['Content']['alt'];
                $caption = ($image['Content']['content']=='') ? '' : '&lt;caption&gt;'.$image['Content']['content']."&lt;/caption&gt;\r";
                $title = (empty($image['Content']['title'])) ? $image['Content']['Image']['title'] : $image['Content']['title'];
                
                $iiLinks .= 
                    "<br />![" . $alt
                    . "][$index]<br />" . $caption
                    .'<br />['.$index.']: '.$image['Content']['Image']['img_file'] . ' ' .$title . "<br />";
//                $inlineImages[$index]['image'] = $image['Content']['Image']['img_file'];
            }
        }
        return "<code>$iiLinks</code>";
    }
    
    
    function delete($id = null) {
            $this->layout = 'noThumbnailPage';
            if (!$id) {
                    $this->Session->setFlash(__('Invalid id for content', true));
                    $this->redirect(array('action'=>'index'));
            }
            if ($this->Content->delete($id)) {
                    $this->Session->setFlash(__('Content deleted', true));
                    $this->redirect(array('action'=>'index'));
            }
            $this->Session->setFlash(__('Content was not deleted', true));
            $this->redirect(array('action' => 'index'));
    }

    function search() {
        debug($this->data); die;
    }
    
    function sequence(){
        $this->layout='ajax';
        if(isset($this->data[0])){
            //save the data here
            $this->Content->ContentCollection->saveAll($this->data);
            $this->blogPage();
            $this->render('blog','ajax');
        } else {
        $conditions = array(
            'Collection.category_id'=>$this->categoryNI['dispatch']
//            ,'Content.publish'=>1
            );
        
        if(!isset($this->params['pass'][0])){
            $most_recent = $this->readMostRecentBlog($conditions);
            $conditions['Content.slug'] = $most_recent['Content']['slug'];
            $conditions['ContentCollection.collection_id'] = $most_recent['Collection']['id'];
            
        } elseif (is_numeric($this->params['pass'][0])){
            $conditions['ContentCollection.collection_id'] = $this->params['pass'][0];
            
            if (isset($this->params['pass'][1]) && is_string($this->params['pass'][1])) {
                $conditions['Content.slug'] = $this->params['pass'][1];
            }
        } elseif (is_string($this->params['pass'][0])) {
            $conditions['Content.slug'] = $this->params['pass'][0];
            $most_recent = $this->readMostRecentBlog($conditions);
            $conditions['ContentCollection.collection_id'] = $most_recent['Collection']['id'];

        }
//        debug($most_recent);
//        debug($this->params);
//        debug($pname);die;
        $sequence_set = $this->Content->ContentCollection->find('all',array(
            'fields'=>array(
                'ContentCollection.id','ContentCollection.content_id',
                'ContentCollection.collection_id','ContentCollection.seq',
                'ContentCollection.publish'),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id','Collection.slug')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading'),
//                    'conditions'=>array('Content.publish'=>1),
                    'Image'=>array(
                        'fields'=>array('Image.alt','Image.title','Image.img_file')
                    ),
                    'ContentCollection'=>array('fields'=>array('ContentCollection.seq'))
                )
            ),
            'order'=>'ContentCollection.seq ASC',
            'conditions' => $conditions
        ));
        $this->set('sequence_set',$sequence_set);
        }
    }
        
    /**
     * Landing page for the blog
     * 
     * If no pname is given, get the most recent active
     * 
     * Much more to come
     */
    function blog(){
        $this->readBlogTOC();
        $this->layout='blog_layout';
        $this->blogPage();
    }
    
    function blogPage(){
        $conditions = array(
            'Collection.category_id'=>$this->categoryNI['dispatch'],
            'ContentCollection.publish'=>1);
        
        if(!isset($this->params['pass'][0])){
            $most_recent = $this->readMostRecentBlog($conditions);
            $conditions['Content.slug'] = $most_recent['Content']['slug'];
            $conditions['ContentCollection.collection_id'] = $most_recent['Collection']['id'];
            
        } elseif (is_numeric($this->params['pass'][0])){
            $conditions['ContentCollection.collection_id'] = $this->params['pass'][0];
            
            if (isset($this->params['pass'][1]) && is_string($this->params['pass'][1])) {
                $conditions['Content.slug'] = $this->params['pass'][1];
            }
        } elseif (is_string($this->params['pass'][0])) {
            $conditions['Content.slug'] = $this->params['pass'][0];
            $most_recent = $this->readMostRecentBlog($conditions);
            $conditions['ContentCollection.collection_id'] = $most_recent['Collection']['id'];

        }

        $most_recent = $this->Content->ContentCollection->find('all',array(
            'fields'=>array('ContentCollection.content_id','ContentCollection.collection_id'),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id','Collection.slug','Collection.heading')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading','Content.slug'),
//                    'conditions'=>array('Content.publish'=>1),
                    'Image'=>array(
                        'fields'=>array('Image.alt','Image.title','Image.img_file')
                    )
                )
            ),
            'order'=>array(
                'ContentCollection.seq ASC',
                'ContentCollection.id ASC'
            ),
            'conditions' => $conditions
        ));
        $this->set('most_recent',$most_recent);
        
    }
    /**
     * Read the full blog table of contents from cache or db
     * 
     * Provides an id indexed array and a lookup-by-slug element
     * that can be popped off the front of the array
     * 
     *  Array
     *      [lookup]
     *              [box-structures-their-part-names] => 133
     *              [boxes] => 60
     *              [daily-planners] => 129
     *              [design-cycle] => 128
     *      [133] => Array
     *              [id] => 133
     *              [category_id] => 1469
     *              [slug] => box-structures-their-part-names
     *              [heading] => Box Structures and their Part Names
     *              [Titles] => Array
     *                     [clamshell-box-its-variations] => The Clamshell Box and Its Variations
     *      [60] => Array
     *              [id] => 60
     *              [category_id] => 1469
     *              [slug] => boxes
     *              [heading] => Boxes
     *              [Titles] => Array
     *                      [wedding-memory-boxes] => Wedding Memory Boxes
     *                      [lucha-libre] => Lucha Libre!
     *                      [jackson-nichol-s-forcado-portfolio] => Jackson Nichol's Forcado portfolio
     */
    function readBlogTOC() {
        if(!($toc = Cache::read('toc'))) {

            $tocbase = $this->Content->ContentCollection->Collection->find('all',array(
                'fields'=>array(
                    'Collection.id',
                    'Collection.category_id',
                    'Collection.slug',
                    'Collection.heading'),
                'contain'=>array(
                    'ContentCollection'=>array(
                        'fields'=>array(
                            'ContentCollection.content_id',
                            'ContentCollection.collection_id',
                            'ContentCollection.publish'
                        ),
                        'Content'=>array(
                            'fields'=>array(
                                'Content.id',
                                'Content.heading',
                                'Content.slug'
                            )
                        ),
                        'conditions'=>array('ContentCollection.publish'=>1)
                    )
                ),
                'conditions'=>array(
                    'Collection.category_id'=>$this->categoryNI['dispatch']
                ),
                'group'=>'Collection.slug'
            ));
            foreach($tocbase as $index => $collection){
                $level_id = $collection['Collection']['id'];
                $level_slug = $collection['Collection']['slug'];
                $toc['lookup'][$level_slug] = $level_id;
                $toc[$level_id] = $collection['Collection'];
                $i = 0;
                while($i < count($collection['ContentCollection'])){
                    $toc[$level_id]['Titles'][$collection['ContentCollection'][$i]['Content']['slug']] = $collection['ContentCollection'][$i]['Content']['heading'];
                    $i++;
                }
            }
            Cache::write('toc', $toc);
        }
        $this->set('toc',$toc);
        $recentPosts = $this->Content->recentNews(8);
        $this->set('recentPosts',$recentPosts);
        $this->set('result_imagePath',  $result_imagePath = 'images/thumb/x75y56/');
    }
    
    /**
     * Discover the most recent dispatch entry (blog post)
     * 
     * Given no informaton, return link info for the most recent entry.
     * The returned content may be linked to more than one Collection,
     * but only one (the first/arbitrary) parent will be returned
     * 
     * @return array The most recent blog entry
     */
    
    function readMostRecentBlog($conditions) {
        return $this->Content->ContentCollection->find('first',array(
            'fields'=>array('ContentCollection.content_id','ContentCollection.collection_id'),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id','Collection.slug')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading','Content.slug')
                )
            ),
            'order'=>'ContentCollection.created DESC',
            'conditions' => $conditions
        ));
        
    }

    /**
     * Landing page for top level Products menu item
     * 
     * Pull a list of recently used titles (these will be dispatches and gallery entries)
     * And the 3 most recent gallery entries for the page
     * 
     * Much more to come
     */
    function products(){
        $this->layout = 'noThumbnailPage';
//        $this->set('result_imagePath',  $this->result_imagePath);

        $this->set('recentNews',  $this->Content->recentNews(3));
        $this->set('recentExhibits',$this->Content->recentExhibits(3));
    }

    function art(){
        if(empty($this->params['pass'])){
            //main art landing page
        } elseif (empty($this->params['named'])){
            //no specific exhibit indicated
            //decide what process to use
        } else {
            //a specific exhibit (page & id) is indicated
            //go ahead and do the filmstrip and exhibit queries
        }
//        debug($this->params);
    //        debug($this->params['pass'][count($this->params['pass'])-1]);
        $this->params['pname'] = $this->params['pass'][count($this->params['pass'])-1];
        $this->gallery();
        $this->render('gallery');
    }
    
    /**
     * Landing page for a major Product category
     * 
     * Tentatively this will show a couple of recent news feeds,
     * A couple of recent Gallery links
     * Some general product descriptions
     * and some display of pricing samples or purchase links from Catalog
     */
    function product_landing(){
        $this->layout = 'noThumbnailPage';
//        $this->set('result_imagePath',  $this->result_imagePath);
        
        $this->set('recentNews',  $this->Content->recentNews(2,  $this->params['pname']));
        $this->set('recentExhibit',  $this->Content->recentExhibits(2,  $this->params['pname']));
        $sale_items = $this->Catalog->find('all',array(
            'conditions'=>array('category'=>  $this->params['pname'])
        ));
        $this->set('sale_items',$sale_items);
    }

    /**
     * Content gallery action, default handling of all product beauty-shot galleries
     * 
     * Used to be Product Gallery action
     * If an id is available, the process to pull an exhbit is called
     * otherwise the process to build an introductory page is called
     * I don't know of a case where $pname would be passed as a prameter,
     * the router sends it as a url param, but I added it because it's 
     * important and I wanted it documented with the params
     *
     * @todo don't neglect exhibit detail picture sets (links added to text?)
     * @todo the process the makes $collection is overkill. We just need one localized prev/next pair
     * 
     * @param int $page The SlideStrip page
     * @param int $id The Exhibit to detail
     * @param string $pname The product group (normally comes in on $this->params['pname'])
     */
    function gallery(){
        // Tailor pagination to Exhibits then call for the filmStrip
        $id = (isset ($this->passedArgs['id'])) ? $this->passedArgs['id'] : false;
        $page = (isset ($this->passedArgs['page'])) ? $this->passedArgs['page'] : 1;
        $pname = (isset($this->params['pname'])) ? $this->params['pname'] : null;
        $this->setExhibitFilmstripParams();

        $this->pageConditions = array(
                'ContentCollection.publish' => 1,
                'Collection.slug' => $pname,
                'Collection.category_id' => $this->categoryNI['exhibit']//$this->category[0]['Category']['id']
            );

        $neighbors = $this->filmstripNeighbors();

        $this->set('neighbors', $neighbors);
        $this->set('filmStrip',$this->pullFilmStrip($page));
        
        if (!$id) {
            $id = $this->discoverFirstExhibit();
        }
        $this->pullExhibit($id);
    }

    /**
     * Pull the requested Exhibit detail
     * 
     * When an id is availble on the exhibits page
     * control is passed to this method to pull all the 
     * data for the detail display
     * 
     * @todo gather of the detail sub-records if they exist.
     * @todo verify it's an actual exhibit id (if this is protected, possibly not necessary?)
     * @todo Provide some form of db-down protection
     */
    function pullExhibit($id = false) {
        $this->set('exhibit',"This is exhibit $id.");
//        $this->set('content',  $this->Content->find('all',array('conditions'=>array('Content.id = '=>$id))));
        
        if ($id) {
        $record = $this->Content->find('first',array(
            'conditions'=>array('Content.id'=>$id),
            'fields'=>array('Content.image_id',
                'Content.alt',
                'Content.content',
                'Content.heading'),
            'contain'=>array(
                'Image'=>array(
                    'fields'=>array(
                        'Image.id',
                        'Image.img_file',
                        'Image.mimetype',
                        'Image.filesize',
                        'Image.width',
                        'Image.height',
                        'Image.title',
                        'Image.alt',
                        'Image.date',
                        'Image.upload'
                    )                ),
                'ContentCollection'=>array(
                    'fields'=>array('ContentCollection.collection_id',
                        'ContentCollection.sub_collection',
                        'ContentCollection.publish',
                        'ContentCollection.seq'),
                    'Collection'=>array(
                        'fields'=>array('Collection.id','Collection.category_id','Collection.slug','Collection.heading'),
                        'Category'=>array(
                            'fields'=>array('Category.id','Category.name','Category.supplement_list')
                        )
                    ),
                    'Supplement'=>array(
                        'fields'=>array(
                            'Supplement.content_collection_id',
                            'Supplement.type',
                            'Supplement.data')
                    )

                )
            ))); 
        
        $this->compressSupplements($record);
        $this->set('record',$record);
        }
    }
    /**
     * Process for the first call on a gallery or art/edition when no ID is known
     * 
     * @return integer/boolean id of exhibit from gallery
     */
    function discoverFirstExhibit() {
//        $this->set('introduction', "This is a gallery introduction page");
        $this->params['named']['id'] = $this->viewVars['filmStrip'][0]['Content']['id'];
        return $this->params['named']['id'];
    }
    
    /**
     * Set properties for typical Exhibit query
     * 
     * This serves both Gallery and Art/Edition queries
     * and sets the basic Order and Fields
     * Conditions are set in the calling method
     */
    function setExhibitFilmstripParams(){
        $this->pageOrder = array(
            'ContentCollection.created' => 'DESC',
            'ContentCollection.seq' => 'ASC'
            );
        $this->pageFields = array (
            'ContentCollection.seq','ContentCollection.publish','ContentCollection.created'                
        );                
        $this->pageContains = array(
//            'fields' => array(
//                'ContentCollection.seq' => 'asc'
//            ),
            'Content' => array(
                'fields' => array(
                    'Content.heading',
                    'Content.id',
                    'Content.image_id',
                    'Content.alt',
                    'Content.title',                   
                ),
                'Image' => array(
                    'fields' => array(
                        'Image.img_file',
                        'Image.alt',
                        'Image.title'
                                )
                            )
            ),
            'Collection' => array(
                'fields' => array(
                    'Collection.heading' ,
                    'Collection.slug'
                )
            ));
    }
    
    /**
     * Newsfeed handler
     * 
     * Admin aware. For managers and admins additional data is pulled
     * for on-page editing of dispatches. Also, unpulished dispatches
     * for the collection are pulled and listed at the end set
     * 
     * @todo look at moving Session check filmstrip.limit to beforeFilter
     * 
     * @return null
     */
    function newsfeed(){
//        debug($_ENV);
//        debug($_REQUEST);
//        debug($_GET);
//        debug($this->here);
//        debug($this->base);
//        debug($this->passedArgs);
//        debug($this->params);
//        die;
        $pname = (isset($this->params['pname'])) ? $this->params['pname'] : null;
        if(isset($this->usergroupid) && $this->usergroupid < 3) {
            $this->newsfeedAdmin($pname);
        } else {
            $this->newsfeedPublic($pname);
        }
        $this->pageOrder = array(
                'Content.id' => 'desc'
            );
        
        // To allow proper function of 'sent' links to dispatches, 
        // the :page param should never be part of the uri since 
        // it will change over time. So if a link has an id and no
        // page, its page must be calculated so the filmstip will 
        // function properly
        if (isset ($this->passedArgs['id']) && !isset ($this->passedArgs['page'])){
//            debug($this->filmstripNeighbors());
//            debug($this->params);
//            debug($this->passedArgs);//die;
            $n = $this->filmstripNeighbors();
            $uri = preg_replace('/\/id:[\d]+/', '/page:'.$n[$this->passedArgs['id']]['page'].'/#id'.$this->passedArgs['id'], $this->params['url']['url']);
//            debug($uri);die;
            $this->redirect('/'.$uri);
        }
        // if no page/id info is provided use the first page...
        // do these default choices really make sense now?
        $id = (isset ($this->passedArgs['id'])) ? $this->passedArgs['id'] : false;
        $page = (isset ($this->passedArgs['page'])) ? $this->passedArgs['page'] : 1;
        // I don't think you can get in here without a pname
//        $pname = (isset($this->params['pname'])) ? $this->params['pname'] : null;
        
        // I think this should be in beforeFilter()?
        if($this->Session->check('filmstrip.limit')){
           $this->pageLimit = $this->Session->read('filmstrip.limit');
        }
        
        $this->Content->pullCollection($pname, $this->pageLimit);
        $this->paginateCollection($this->Content->collectionPages, $page);
        $this->set('pageData', $this->pageData);
        $this->set('collectionPage', $this->collectionPage);
        $this->set('collectionData', $this->Content->collectionData);
        foreach($this->collectionPage as $entry){
            $collectionJson["id{$entry['id']}"] = $entry;
        }
        $this->set('collectionJson', $collectionJson);
        $neighbors = $this->filmstripNeighbors();
        $this->set('neighbors', $neighbors);
    }
    
    /**
     * This is the landing point for a jump box request.
     * 
     * Select the proper jump context, call for url construction and redirect
     */
    function jump() {
        switch ($this->data['action']) {
            case 'newsfeed':
                $url = $this->jumpNewsfeed();
                break;
            case 'gallery':
                $url = $this->jumpGallery();
                break;
            default:
                break;
        }
        $this->redirect($url);
    }
    
    /**
     * Create the url for a jump request on a newsfeed page
     * 
     * #id references get dropped from the url and must be added, not replaced
     * @return string The url to targe the requested newsfeed image
     */
    function jumpNewsfeed(){ 
        //this is the newsfeed specific find with all the neighbor data
        $this->Content->pullCollection($this->data['pname'], $this->pageLimit);
        $patterns = '/page:[0-9]+\//';
        $replacements = 
            'page:'.
            $this->Content->collectionPages[$this->data['j']-1]['neighbors']['page'].'/'
            .'#id'.
            $this->Content->collectionPages[$this->data['j']-1]['id'];
        if (preg_match($patterns,  $this->data['url'])){
            return preg_replace($patterns, $replacements, $this->data['url']);
        } else {
            return $this->data['url']. 
            '/page:'.
            $this->Content->collectionPages[$this->data['j']-1]['neighbors']['page'].'/'
            .'#id'.
            $this->Content->collectionPages[$this->data['j']-1]['id'];
        }
    }
    
    function jumpGallery(){
        $this->pageOrder = array(
                'ContentCollection.seq' => 'asc'
            );
        $this->pageConditions = array(
                'Collection.slug' => $this->data['pname'],
                'Collection.category_id' => $this->categoryNI['exhibit']//$this->category[0]['Category']['id']
            );
        $neighbors = $this->filmstripNeighbors();
        $target = array_slice($neighbors, $this->data['j']-1, 1, TRUE);
        $key=array_keys($target);

        $patterns = array();
        $patterns[0] = '/page:[0-9]+\//';
        $patterns[1] = '/id:[0-9]+/';
        $replacements = array();
        $replacements[0] = 'page:'.$target[$key[0]]['page'].'/';
        $replacements[1] = 'id:'.$key[0];
        if (preg_match($patterns[0],  $this->data['url'])){
            return preg_replace($patterns, $replacements, $this->data['url']);
        } else {
            return $this->data['url'].'/page:'.$target[$key[0]]['page'].'/'.'id:'.$key[0];
        }
    }
    
    /**
     * count - the total number of records in the result set.
     * page - the current page displayed.
     * pages - total number of pages.
     * next - the next page page (wraps to start)
     * previous - the previous page (wraps to end)
     * current - current number of records being shown.
     * start - number of the first record being displayed.
     * end - number of the last record being displayed.
     */
    function paginateCollection($collectionPages, $page){
        $this->pageData['count'] = count($collectionPages);
        $this->pageData['page'] = $page;
        
        $pages = array_chunk($collectionPages, $this->pageLimit);
        $this->collectionPage = $pages[$page-1];
        $this->pageData['pages'] = count($pages);
        $this->pageData['current'] = count($this->collectionPage);
        $this->pageData['start'] = $this->collectionPage[0]['neighbors']['count'];
        $this->pageData['end'] = $this->collectionPage[$this->pageData['current']-1]['neighbors']['count'];
       
        $this->pageData['next'] = ($page == $this->pageData['pages']) ? 1 : $page+1;
        $this->pageData['previous'] = ($page == 1) ? $this->pageData['pages'] : $page-1;
    }
    
//    function dispatch_edit() {
// //       debug($this->data); die;
//        if ($this->Content->save($this->data)) {
//            $this->redirect(array(
//                'controller' => 'contents',
//                'action'=> 'newsfeed',
//                'pname'=> $this->params['pass'][0],
//                'page'=> $this->params['named']['page']));
//        }
//    }
//    
    /**
     * Set pagination parameters appropriate to a site manager
     * 
     * @var string $collectionName The search string that id's the collection
     * @return null
     */
    function newsfeedAdmin($collectionName) {
        // any user above 'user' authoriziation gets unpulished records to
        $this->pageConditions = array(
            'Collection.slug' => $collectionName,
            'Collection.category_id' => $this->categoryNI['dispatch']//$this->category[0]['Category']['id']
        );
        // admins need all the data for editing forms
        $this->pageContains = array(
            'Content' => array(
                'Image',
                ),
            'Collection'
            );
    }
    
    /**
     * Set pagination parameters appropriate to a public visitor
     * 
     * @var string $collectionName The search string that id's the collection
     * @return null
     */
    function newsfeedPublic($collectionName) {
        // regular users only get published data
        $this->pageConditions = array(
            'Collection.slug' => $collectionName,
            'Collection.category_id' => $this->categoryNI['dispatch']//$this->category[0]['Category']['id'],
        );
 // the public only needs enough data to build the page
        $this->pageContains = array(
            'Content' => array(
                'fields' => array(
                    'Content.heading',
                    'Content.id',
                    'Content.image_id',
                    'Content.alt',
                    'Content.title',
                    'Content.content'
                ),
                'Image' => array(
                    'fields' => array(
                        'Image.img_file',
                        'Image.alt',
                        'Image.title',
                        'Image.date'
//                                ),
//                    'order' => array(
//                        'Image.date' => 'desc'
                    )
                )//,
//                'Sibling' => array(
//                    'fields' => array(
//                        'Sibling.image_id',
//                        'Sibling.id'
//                    )
//                )
            ),
            'Collection' => array(
                'fields' => array(
                    'Collection.heading',
                    'Collection.slug',
                    'Collection.text'
                )
            )
            );
    }

//    /**
//     * Set a starting Content id for introduction entry point
//     * 
//     * Page output expects an id but in initial entry none is present
//     * in the url. So here it gets discovered and set
//     * @todo this may break if filmstripNeighbors() gets re-written
//     * @return null
//     */
//    function newsfeedIntroduction($neighbors) {
//        foreach ($neighbors as $id => $info) {
//            $this->params['named']['id'] = $id;
//            //debug($this->params); debug($this->paginator); die;
//            continue;
//        }
//    }
//
//    /**
//     * Dispatch shows all records from the page so just use the filmstrip 
//     * @param array $filmStrip The current page of newsfeed data
//     * @return null
//     */
//    function newsfeedDispatches($filmStrip = false) {
//    $this->set('content',  $filmStrip);
//    }

    /**
     * Pull the records needed to build a Collection's navigation strip
     * 
     * @param int $page The desired page of images
     * @return array The array of page data
     */
    function pullFilmStrip($page) {
        $this->paginate = array(
            'page' => $page,
            'limit' => $this->pageLimit,
            'order' => $this->pageOrder,
//            'fields' => $this->pageFields,
            'contain' => $this->pageContains,
            'conditions' => $this->pageConditions,
        );
        return $this->paginate('ContentCollection');
        //return $this->Content->ContentCollection->find('all',array($this->pageOrder,  $this->pageConditions, $this->pageFields));
    }
    
    /**
     * Discover the proper links for prev/next image for every record in a collection
     * 
     * @todo This full array is overkill for filmstrip clickers. Either re-write or make an option to only find prev/next for a single record
     * @param int $id If provided, will only return neighbors for this record. Otherwise an array for every record in collection
     * @return array $neighbors an array of the neighbors for Content.id or every Content record 
     */
    function filmstripNeighbors($id = null) {
        if ($id == null) {
            // neighbors for entire collection
            $collection = $this->Content->ContentCollection->find('all',
                    array(
                        'fields'=>array('Content.id'),
                        'conditions'=>  $this->pageConditions,
                        'order'=>  $this->pageOrder));

            $max = count($collection)-1;

            // this is overkill
            foreach ($collection as $index => $locus) {
                $neighbors[$locus['Content']['id']]['count'] = $index+1;
                if ($index == 0) {
                    $neighbors[$locus['Content']['id']]['previous'] = $collection[$max]['Content']['id'];
                } else {
                    $neighbors[$locus['Content']['id']]['previous'] = $collection[$index-1]['Content']['id'];
                }
                if ($index == $max) {
                    $neighbors[$locus['Content']['id']]['next'] = $collection[0]['Content']['id'];
                } else {
                    $neighbors[$locus['Content']['id']]['next'] = $collection[$index+1]['Content']['id'];
                }
                $neighbors[$locus['Content']['id']]['page'] = intval(($index/9)+1);
            }
        }else {
            // neighbors for id'd record
        }
        return $neighbors;
    }
    
    /**
     * Compress the supplements array into key=>value pairs
     * 
     * Supplements returns a type field and data field in each record.
     * These need to be accumulated into a single array for each image/collection
     * [Supplement] => Array
     *      [0] => Array
     *              [image_id] => 670
     *              [collection_id] => 89
     *              [type] => headstyle
     *              [data] => drksubhead
     *      [1] => Array
     *              [image_id] => 670
     *              [collection_id] => 89
     *              [type] => pgraphstyle
     *              [data] => drkparagraph
     *      [2] => Array
     *              [image_id] => 670
     *              [collection_id] => 44
     *              [type] => size
     *              [data] => 35
     * Should translate into
     * [Supplement] => Array
     *              [headstyle] => drksubhead
     *              [pgraphstyle] => drkparagraph
     *              [size] => 35
     * 
     * @todo what about this multiple cont_coll record situation?
     */
    function compressSupplements(&$record){

        $supplement = array();
        
        if ($record['ContentCollection'][0]['Collection']['Category']['supplement_list'] != 'empty'){
            //there is default supplement data, so build the array
            $supplement = unserialize($record['ContentCollection'][0]['Collection']['Category']['supplement_list']);
        }
        
        if (isset($record['ContentCollection'][0]['Supplement'])){
            foreach($record['ContentCollection'][0]['Supplement'] as $entry){
                $supplement[$entry['type']] = $entry['data'];
            }
        }
        
        $record['Supplement'] = $supplement;
    }

}
?>