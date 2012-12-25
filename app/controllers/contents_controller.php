<?php
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
     * beforeFilter
     */
    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('gallery', 'newsfeed', 'art', 'jump','products','blog');
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
    
    function blog(){
        if($this->params['pname']==null){
        $most_recent = $this->Content->ContentCollection->find('first',array(
            'fields'=>array('ContentCollection.content_id','ContentCollection.collection_id'),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id','Collection.slug')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading','Content.slug'),
                    'Image'=>array(
                        'fields'=>array('Image.alt','Image.title','Image.img_file')
                    )
                )
            ),
            'order'=>'ContentCollection.created DESC',
            'conditions'=>array(
                'Collection.category_id'=>$this->Content->ContentCollection->Collection->Category->categoryNI['dispatch'])
        ));
        $pname = $this->slug($most_recent['Content']['slug']);
        } else {
            $pname = $this->params['pname'];
        }
//        debug($most_recent);
//        debug($this->params);
//        debug($pname);die;
        $most_recent = $this->Content->ContentCollection->find('all',array(
            'fields'=>array('ContentCollection.content_id','ContentCollection.collection_id'),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id','Collection.slug')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading'),
                    'Image'=>array(
                        'fields'=>array('Image.alt','Image.title','Image.img_file')
                    )
                )
            ),
            'order'=>'ContentCollection.created ASC',
            'conditions'=>array(
                'Content.slug'=>$pname,
                'Collection.category_id'=>$this->Content->ContentCollection->Collection->Category->categoryNI['dispatch'])
        ));
        $this->layout='noThumbnailPage';
        $this->set('most_recent',$most_recent);
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
//        Configure::write('debug',0);
        $this->layout = 'noThumbnailPage';
        $this->set('recentTitles',  $this->Content->Image->recentTitles);
        $most_recent = $this->Content->ContentCollection->find('all',array(
            'fields'=>array('DISTINCT ContentCollection.content_id','ContentCollection.collection_id'),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id', 'Collection.heading')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading'),
                    'Image'=>array(
                        'fields'=>array('Image.alt','Image.title','Image.img_file')
                    )
                )
            ),
            'order'=>'ContentCollection.created DESC',
            'conditions'=>array('Collection.category_id'=>$this->Content->ContentCollection->Collection->Category->categoryNI['exhibit']),
            'limit'=>3
        ));
        $this->set('most_recent',$most_recent);
    }

    function art(){
    //        debug($this->params['pass'][count($this->params['pass'])-1]);
        $this->params['pname'] = $this->params['pass'][count($this->params['pass'])-1];
        $this->gallery();
        $this->render('gallery');
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
     * @todo make the filmStrip query 'pulblish' aware
     * @todo what is the significance of ContentCollection.visible?
     * @todo the process the makes $collection is overkill. We just need one localized prev/next pair
     * @param int $page The SlideStrip page
     * @param int $id The Exhibit to detail
     * @param string $pname The product group (normally comes in on $this->params['pname'])
     */
    function gallery(){
        // This block is for logic testing
        $vars = array (
            'introduction' => '',
            'exhibit' => '',
        );
        $this->set($vars);
        // ------- end logic testing block
        
        // Taylor pagination to Exhibits then call for the navStrip
        $id = (isset ($this->passedArgs['id'])) ? $this->passedArgs['id'] : false;
        $page = (isset ($this->passedArgs['page'])) ? $this->passedArgs['page'] : 1;
        $pname = (isset($this->params['pname'])) ? $this->params['pname'] : null;
        $this->pageOrder = array(
                'ContentCollection.seq' => 'asc'
            );
        $this->pageFields = array (
            'seq','visible'                
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
        

//        $this->pullCategory($pname, 'exhibit');        
        $this->pageConditions = array(
                'Collection.slug' => $pname,
                'Collection.category_id' => $this->Content->ContentCollection->Collection->Category->categoryNI['exhibit']//$this->category[0]['Category']['id']
            );

        $neighbors = $this->filmstripNeighbors();

        $this->set('neighbors', $neighbors);
        $this->set('filmStrip',$this->pullFilmStrip($page));
        
        /**
         * @todo this pattern may not be right for the final version. It just focuses on the first gallery item rather than allowing for a possible introducion page
         */
        if (!$id) {
            $id = $this->galleryIntroduction();
        }
        $this->galleryExhibit($id);
    }

    /**
     * Pull the requested Exhibit detail
     * 
     * When an id is availble on the exhibits page
     * control is passed to this method to pull all the 
     * data for the detail display
     * 
     * @todo Acutally write something including gathering of the detail sub-records if they exist.
     * @todo verify it's an actual exhibit id (if this is protected, possibly not necessary?)
     * @todo Provide some form of db-down protection
     */
    function galleryExhibit($id = false) {
        $this->set('exhibit',"This is exhibit $id.");
//        $this->set('content',  $this->Content->find('all',array('conditions'=>array('Content.id = '=>$id))));
        
        
        if ($id) {
        $record = $this->Content->find('first',array(
            'conditions'=>array('Content.id'=>$id),
            'fields'=>array('image_id','alt','content','publish','heading'),
            'contain'=>array(
                'Image'=>array(
                    'fields'=>array('Image.id','Image.img_file','Image.mimetype','Image.filesize','Image.width','Image.height','Image.title','Image.alt','Image.date','Image.upload'),
                    'Supplement'=>array(
                        'fields'=>array('Supplement.image_id',
                            'Supplement.collection_id',
                            'Supplement.type',
                            'Supplement.data')
                    )
                ),
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
                    )
                )
            ))); 
        
        $this->compressSupplements($record);
        $this->set('record',$record);
//        debug($record);die;
        }
    }
    /**
     * Process for the first call on a gallery when no ID is known
     * 
     * This could be beefed up to show a splash page or whatever.
     * Right now it is set to select a random exhibit from the current
     * gallery page and display that. 
     *
     * Will return  an id or set a flash message and return false
     *
     * @todo returning a random element like this requires calculation of the correct gallery page for viewing
     * @todo this is a temporary fix copied from newsfeed. it discovers the first Content in Collection but may break if filmstripNeighbors() gets changed
     * @return integer/boolean id of random exhibit from gallery or false
     */
    function galleryIntroduction() {
//        debug($this->viewVars['filmStrip']); die;
        $this->set('introduction', "This is a gallery introduction page");
            $this->params['named']['id'] = $this->viewVars['filmStrip'][0]['Content']['id'];
//        foreach ($this->viewVars['filmStrip'] as $id => $info) {
//            $this->params['named']['id'] = $id;
//            //debug($this->params); debug($this->paginator); die;
//            continue;
//        }
        return $this->params['named']['id'];
//        $records = $this->ExhibitGallery->find('all',array(
//             'conditions'=> array('Gallery.label LIKE'=> "%{$this->product}%"),
//             'contain'=>array('Exhibit.id', 'Gallery.label')
//        ));
//        //return ($records[0]['Exhibit']['id']);
//        if ($records && count($records)>0){
//            //$this->Session->setFlash('Getting a random element');
//            return ($records[rand(0, count($records))-1]['Exhibit']['id']);
//        }
//        $this->Session->setFlash('No gallery entries found. Please try again');
//        return false;
//        //debug($records);
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
        // This block is for logic testing
        $vars = array (
            'introduction' => '',
            'dispatch' => '',
        );
        $this->set($vars);

        // Taylor pagination to Exhibits then call for the navStrip
        $id = (isset ($this->passedArgs['id'])) ? $this->passedArgs['id'] : false;
        $page = (isset ($this->passedArgs['page'])) ? $this->passedArgs['page'] : 1;
        $pname = (isset($this->params['pname'])) ? $this->params['pname'] : null;
        
        if(isset($this->usergroupid) && $this->usergroupid < 3) {
            $this->newsfeedAdmin($pname);
        } else {
            $this->newsfeedPublic($pname);
        }
        
        // I think this should be in feforeFilter()?
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
                'Collection.category_id' => $this->Content->ContentCollection->Collection->Category->categoryNI['exhibit']//$this->category[0]['Category']['id']
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
    
    function dispatch_edit() {
 //       debug($this->data); die;
        if ($this->Content->save($this->data)) {
            $this->redirect(array(
                'controller' => 'contents',
                'action'=> 'newsfeed',
                'pname'=> $this->params['pass'][0],
                'page'=> $this->params['named']['page']));
        }
    }
    
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
            'Collection.category_id' => $this->Content->ContentCollection->Collection->Category->categoryNI['dispatch']//$this->category[0]['Category']['id']
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
            'Collection.category_id' => $this->Content->ContentCollection->Collection->Category->categoryNI['dispatch'],//$this->category[0]['Category']['id'],
            'Content.publish' => 1
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

    /**
     * Set a starting Content id for introduction entry point
     * 
     * Page output expects an id but in initial entry none is present
     * in the url. So here it gets discovered and set
     * @todo this may break if filmstripNeighbors() gets re-written
     * @return null
     */
    function newsfeedIntroduction($neighbors) {
        foreach ($neighbors as $id => $info) {
            $this->params['named']['id'] = $id;
            //debug($this->params); debug($this->paginator); die;
            continue;
        }
    }

    /**
     * Dispatch shows all records from the page so just use the filmstrip 
     * @param array $filmStrip The current page of newsfeed data
     * @return null
     */
    function newsfeedDispatches($filmStrip = false) {
    $this->set('content',  $filmStrip);
    }

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
     *      [670] => Array
     *              [89] => Array
     *                     [headstyle] => drksubhead
     *                     [pgraphstyle] => drkparagraph
     *              [44] => Array
     *                     [size] => 35
     * 
     * @todo what about this multiple cont_coll record situation?
     */
    function compressSupplements(&$record){
        
        $supplement = array();
        $collection = $record['ContentCollection'][0]['collection_id'];
        
        if ($record['ContentCollection'][0]['Collection']['Category']['supplement_list'] != 'empty'){
            //there is a list of required supplement data, so build the array
            $list = $record['ContentCollection'][0]['Collection']['Category']['supplement_list'];
            $supplement[$record['ContentCollection'][0]['collection_id']] = array_flip(explode("," , $record['ContentCollection'][0]['Collection']['Category']['supplement_list']));
            // default values could be read from a property here i guess. Or inserted on new/edit screens
        }
        
        if (isset($record['Image']['Supplement'])){
            foreach($record['Image']['Supplement'] as $entry){
                // the image may belong to many collections with different supplements
                // so we'll filter only those for this collection
                if ($entry['collection_id']==$collection){
                    $supplement[$entry['type']] = $entry['data'];
                }
            }
        }
        
        $record['Image']['Supplement'] = $supplement;
    }

}
?>