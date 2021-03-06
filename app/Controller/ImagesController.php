<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * Images Controller
 * 
 * An Article is created from one or more text/image pairs.
 * Image records are the image portion of a pair. Content records
 * own to Image records and are the text protion of the pair. 
 * To create a multi-unit Article, all Content.headings must be the same
 * and all ContentCollection.collection_ids must be the same.
 * 
 * Image carries a default <alt> and <title> value, and exif data from the image file.
 * The Content record also carries  <alt> and <title> values and can override the
 * Image values. Since Images may belong to multiple Content records (and hence
 * multiple articles), this allows the <alt> and <title> to be appropriate
 * to the article topic.
 * 
 * The basic structual chain for Content is:
 * <pre>
 *                                                      |<--Supplement
 * Category<--Collection<--ContentCollection-->Content--|
 *                                                      |-->Image
 * |         |            |                  |                     |
 * | Content |            |                  |                     |
 * | Filter  |Article Sets| Article Assembly |     Article Parts   |
 * </pre>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 * @todo write populator that reads the current image collection and writes records for images that don't have them
*/
class ImagesController extends AppController {

    var $name = 'Images';

    /**
     * @var array $searchRecords The search results
     */
    var $searchRecords = false;

    /**
     * @var false|array $duplicate Upload files that are duplicates
     */
    var $duplicate = false;

    /**
     * @var false|array $disallowed Upload files that are disallowed types
     */
    var $disallowed = false;

    /**
     * @var false|array $new Upload files that are new
     */
    var $new = false;

    /**
     * @var false|int $lastUpload the sequence number of the last upload set
     */
    var $lastUpload = false;

    /**
     * @var false|array $uploadSets array of upload seq numbers and count of images in each for a drop list selector
     */
    var $uploadSets = false;

    /**
     * @var int $column The default number of columns for Image Grid display
     */
    var $column = 2;

    /**
     * @var string $size The default size for Image Grid display
     */
    var $size = 'x320y240';

    /**
     * @var int $columns The list of possible column counts
     */
    var $columns = array();

    /**
     * @var string $sizes The list of sizes for Image Grid display
     */
    var $sizes = array();

    /**
     * The Image context search params last used to draw the page
     * @var string|array $searchInput String search param or action=>pass array
     */
    var $searchInput = false;

    /**
     * Number of upload forms requested
     * @var integer|false $uploadCount Number of upload forms requested
     */
    var $uploadCount = false;

    /**
     * The orphan Image records
     * @var array $orphans Image records that link to no Content record
     */
    var $orphans = false;

    /**
     * The action active when a user search was requested
     * Stored as a hidden field in the search form. 
     * @var array searchAction Action that is displaying the search field
     */
    var $searchAction = false;

    /**
     * The action/param pairs for pre-configured link-base searches
     * 
     * Some search can be entered with pre-configured searchs via a link
     * for example 'last upload' link will be action=image_grid pass[0]=lastUploadValue
     * or action=multi-add pass[0]=disallowed
     * This array is the place to create regex patterns that will identify 
     * the allowable combinations
     * @var array actionParamPairs Allowed pre-built searchs for actions
     */
    var $actionParamPairs = array(
        '/image_grid:[0-9]+/',
        '/multi_add:disallowed/',
        '/multi_add:[0-9]+/',
        '/image_grid:orphan_images/'
    );

    /**
     *
     * @var array $contains The fields to contain in a typical Image search
     */
    var $contain = array(
        'Content'=>array(
            'ContentCollection'=>array(
                'fields'=> array('id','collection_id','seq','publish'),
                'Collection'=>array(
                    'fields'=>array('Collection.heading','Collection.slug')
                )
            )
        ));

    var $layout = 'noThumbnailPage';
    
    /**
     *
     * @var array $fileError array of messages about upload files of the wrong type
     */
    var $fileError = False;

    function beforeRender() {
        parent::beforeRender();
       if($this->usergroupid < 3) { // managers or administrators

           // Set lastUpload property
           $u = $this->Image->find('first',array(
                'order'=>'Image.upload DESC',
                'fields'=>'Image.upload',
                'contains'=>false));
           $this->set('lastUpload', $this->lastUpload = ($u) ? $u['Image']['upload'] : false); 

           $this->pull_orphans();

           // Check the Upload folder and set upload realted properties
           $this->Image->Behaviors->Upload->setImageDirectory('Image', 'img_file', 'img/images');
           $this->Image->ingest_images(); //this is in Upload behavior which reads the upolad folder

           // these will be false or arrays of file data from the upload folder
           $this->set('disallowed',$this->disallowed = $this->Image->disallowed);
           $this->set('duplicate',  $this->duplicate = $this->Image->dup);
           $this->set('new',  $this->new = $this->Image->new);

           }
    }
    /**
     * Take care of ImageController housekeeping
     * 
     * If this is a site manager:
     *  Get the lastUpload value
     *  Check the upload folder and make the analyzed contents available
     * 
     * There can be several forms on the page, so once the the page-controll forms are
     * analyzed, $this->request->data must cleared to prevent false positives for 
     * site data modification checks. unset causes auth error so = null
     * 
     * @todo Make the beforeFilter more Action specific. Some things aren't ALWAYS needed
     * @todo search/1 then hit Admin/Image will f'up $this->searchInput. Other values work. Odd
     */
    function beforeFilter(){
//            debug($_POST);die;
//        if($this->Session->check('qualityConditions')){
//            debug($this->Session->read('qualityConditions'));
//        }
       parent::beforeFilter();
       if($this->usergroupid < 3) { // managers or administrators

           // Set lastUpload property
           $u = $this->Image->find('first',array(
                'order'=>'Image.upload DESC',
                'fields'=>'Image.upload',
                'contains'=>false));
           $this->set('lastUpload', $this->lastUpload = ($u) ? $u['Image']['upload'] : false); 

           $this->pull_orphans();

           // Check the Upload folder and set upload realted properties
           $this->Image->Behaviors->Upload->setImageDirectory('Image', 'img_file', 'img/images');
           $records = $this->Image->find('all',array(
               'fields'=>'Image.img_file',
                   'contain'=>false));
           $this->Image->ingest_images($records); //this is in Upload behavior which reads the upolad folder

           // these will be false or arrays of file data from the upload folder
           $this->set('disallowed',$this->disallowed = $this->Image->disallowed);
           $this->set('duplicate',  $this->duplicate = $this->Image->dup);
           $this->set('new',  $this->new = $this->Image->new);

           // Save or read page-state values
            if(isset($this->request->data['Image']['columns'])){
                $this->column = $this->request->data['Image']['columns'];
                $this->size = $this->request->data['Image']['sizes'];
                $this->request->data=null;
//                    debug($this->request->data);die;

            } elseif ($this->Session->check('Image.columns')) {
                $this->column = $this->Session->read('Image.columns');
                $this->size = $this->Session->read('Image.sizes');
            }
            // set $this->uploadSets
            $groups = $this->Image->find('list',array(
                'fields'=>array(
                    'id',
                    'id',
                    'upload'
                ),
                'order'=>'upload DESC',
            ));
//            debug($groups);die;
            $this->uploadSets[0] = 'select';
            foreach($groups as $upload=>$members){
                $this->uploadSets[$upload] = "#$upload - ".  count($members);
            }
//            array_unshift($this->uploadSets, '');
            $this->set('uploadsets',  $this->uploadSets);
//            debug($this->uploadSets);die;
//debug($this->request->data);
            if(isset($this->request->data['Image']['searchInput'])){
//debug($this->request->data);die;
                // user requested search
                $this->searchInput = $this->request->data['Image']['searchInput'];
                $this->searchAction= $this->request->data['Image']['action'];
                $this->request->data = null;
            } elseif(isset($this->request->params['pass'][0])){
                //Some actions might have param base search request
                if($this->checkLinkPatterns($this->request->action . ':' . $this->request->params['pass'][0])){
                    $this->searchInput = $this->request->params['pass'][0];
                    $this->searchAction = $this->request->action;
                }
            } elseif($this->Session->check('Image.searchInput')){
                $this->searchInput = $this->Session->read('Image.searchInput');
            }
//                debug($this->request->data);die;
        }

        // default, last state or new state... we have values for the view now
        $this->set('size', $this->size);
        $this->set('column', $this->column);
        $this->Session->write('Image.columns',$this->column);
        $this->Session->write('Image.sizes',$this->size);
        $this->Session->write('Image.searchInput',$this->searchInput);

        // values for form selects
        $this->set('columns', $this->columns = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10));
        foreach($this->Image->actsAs['Upload']['img_file']['thumbsizes'] as $key=>$val) {
            $this->sizes[$key] = $key;
        }
        $this->set('sizes',  $this->sizes);
        $this->set('searchController', 'Image');

    }

    /**
     * DELETE
     * @param type $action
     */
    function setSearchAction($action){
        $this->set('hidden', array('action'=>array('value'=>  $action)));
    }
        
    function checkLinkPatterns($action_param){
        foreach($this->actionParamPairs as $pattern){
            if(preg_match($pattern, $action_param)){
                return true;
            }
        }
        return false;
    }

    function pull_orphans(){
       $this->orphans = $this->Image->query("SELECT * FROM `images` AS `Image` 
        WHERE NOT EXISTS (SELECT Content.image_id FROM contents AS Content 
        WHERE Content.image_id = Image.id); ");
       $this->set('orphans', $this->orphans);
    }
    
    function index() {
        $this->set('searchController','images');
        $this->setSearchAction('index');
        
        $conditions = array();
        if ($this->Session->check('qualityConditions')){
            $conditions = array('conditions'=> unserialize($this->Session->read('qualityConditons')));
            $this->Session->setFlash('Search term: ' . print_r($conditions['conditions']));
        }
        $this->paginate = array('order'=>array('Image.id'=> 'desc')) + $conditions;
            $this->Image->recursive = 0;
            $this->set('images', $this->paginate());
        }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid image'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('image', $this->Image->read(null, $id));
    }

    function add() {
        if (!empty($this->request->data)) {
            //debug($this->request->data); die;
            //read exif data and set exif fields
            
            $this->get_exif($this->request->data);
            
            //Target the selected Upload directory
//            $this->Image->setImageDirectory($this->request->data['Image']['gallery']);
//            debug($this->Image); die;
            
            $this->Image->create();
        if ($this->Image->save($this->request->data)) {
                $this->Session->setFlash(__('The image has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The image could not be saved. Please, try again.'));
            }
        }
    }
    
    /**
     * Handle duplicate images that have been placed in the Upload folder
     */
    function duplicate_uploads(){
//        debug($this->request->data);
//        debug($this->duplicate);die;
        if(!is_array($this->duplicate)){
            $this->Session->setFlash("Duplicates are all processed. There are no more duplicate images in the Upload folder.");
            $this->redirect(array('action'=>'search'));
        }
        $delete = array();
        if (isset($this->request->data)){
            foreach($this->request->data as $index => $image){
                // images marked for deletion
                if($image['Image']['task']=='delete'
                        && $image['Image']['img_file']==$image['Image']['oldName']){
                    unlink($this->duplicate[$image['Image']['img_file']]->path);
                    $delete[] = $index;
                }
                // images to rename
                if($image['Image']['img_file']!=$image['Image']['oldName']
                        && $image['Image']['task']!='delete'){
                    rename($this->duplicate[$image['Image']['oldName']]->path,
                        $this->duplicate[$image['Image']['oldName']]->Folder->path.'/'.$image['Image']['img_file']);
                    $delete[] = $index;
                }
                // images with ambiguous requests
                if($image['Image']['task']=='delete'
                        && $image['Image']['img_file']!=$image['Image']['oldName']){
                    $this->Session->setFlash('The name was changed and deletion was requested. Please clarify your request<br \\>',
                            'default', null, $image['Image']['oldName']);
                }
            }
            foreach($delete as $index){
                unset($this->duplicate[$this->request->data[$index]['Image']['img_file']]);
                unset($this->request->data[$index]);
            }
            $this->redirect(array('action'=>'duplicate_uploads'));
        }
        $this->layout = 'noThumbnailPage';
    }
    
    /**
     * Handle disallowed images that have been placed in the Upload folder
     */
    function disallowed_uploads(){
        if(!is_array($this->disallowed)){
            $this->Session->setFlash('The disallowed files have all been processed. There are no more disallowed files in the Upload folder.');
            $this->redirect(array('action'=>'search'));
        }
        if (isset($this->request->data)){
            debug($this->request->data);die;
        }
        $this->layout = 'noThumbnailPage';
    }
    
    /**
     * Handle new images that have been placed the Upload folder
     */
    function new_uploads(){
        $sourcePath = WWW_ROOT.'img'.DS.'images'.DS.'upload'.DS;
        $destinationPath = WWW_ROOT.'img'.DS.'images'.DS;
        $thumbs = $this->Image->Behaviors->Upload->thumbs;
        if(!is_array($this->new)){
            $this->Session->setFlash("There are no valid new images in the Upload folder. You should only use an onscreen link to come to this page.<br \\>
                \$this->new should have an array of upoload file info. <br \\>It has: <br \\>"
                    . print_r($this->new, TRUE));
            $this->set('new',false);
        } else {
        }
        if(isset($this->request->data)){
//            debug($this->request->data);die;
            // Look for deletion  and hold requests first
            $delete = $hold = array();
           foreach ($this->request->data as $count => $image){
               if($image['Image']['task']=='delete'){
                   $delete[]=$count;
               } elseif ($image['Image']['task']=='hold'){
                   $hold[]=$count;
               }
           }
           foreach($delete as $index=>$pointer){
                unlink($sourcePath.$this->request->data[$pointer]['Image']['file']);
                foreach($thumbs as $thumb_folder){
                    unlink($sourcePath.$thumb_folder.DS.$this->request->data[$pointer]['Image']['file']);
                }
                unset($this->request->data[$pointer]);
           }
           foreach($hold as $index=>$pointer){
               unset($this->request->data[$pointer]);
           }
           if(!empty($this->request->data)){
               $this->Image->Behaviors->disable('Upload');
               $imageSet = array();
               foreach($this->request->data as $index => $record){
                   $this->request->data[$index]['Image']['img_file'] = $record['Image']['file'];
                   $imageSet[] = $record['Image']['file'];
               }
               if($this->Image->saveAll($this->request->data)){
                   foreach($imageSet as $imageFile){
                       rename($sourcePath.$imageFile, $destinationPath.'native'.DS.$imageFile);
                        foreach($thumbs as $thumb_folder){
                            rename($sourcePath.$thumb_folder.DS.$imageFile, $destinationPath.'thumb'.DS.$thumb_folder.DS.$imageFile);
                        }
                   }
               }
               
    //           $this->redirect(array('action'=>'search',  $this->lastUpload+1));
           }
        }
        $this->set('recentTitles',  $this->Image->recentTitles);
        $this->layout = 'noThumbnailPage';
    }
    
    /**
     * 
     */
    function scanListChoices(&$data){
        // May have chosen Image.title from list rather then typing it
        if ($data['Image']['recent_titles']){
            $data['Image']['title'] = $data['Image']['recent_titles'];
        }
    }
    /**
     * Create a layout to upload several images at once or to upload replacements files
     * 
     * Replacement image files can displace existing image
     * or disallowed files from the upload folder.
     * If data is presented, the layout will be drawn to present one
     * form per found or disallowed file (called from the 'disallowed' clicker).
     * An integer in the search box will give empty forms
     * 
     * 
     * @param int $count The number of forms to present
     */
    function multi_add($count=null) {
        // [1] Set universal controls
        // [2] Save data if present
        // [3] If save failures prepare them for redisplay
        // [4] If no failures (including no save attempt) choose view display
        // [5] Prepare context sensitive control vars
        
        // [1] Se universal controls
        $this->layout = 'noThumbnailPage';
        $this->setSearchAction('multi_add');
        $this->set('searchController','images');
        
        // [2] Save data if present
        if (!empty($this->request->data)) {
			
			// *********************************
			// HACK HACK HACK HACK HACK
			//
			// The form was getting mangled. This is a sad hack to reassemble the first records 
			// image back onto the first records other data. All following records were fine.
			// 
			// This whole work flow is up for review. So i didn't spend time finding a proper fix 
			// *********************************
			if (isset($this->request->data['Image']['img_file']) && !isset($this->request->data[0]['Image']['img_file'])) {
				$this->request->data[0]['Image']['img_file'] = $this->request->data['Image']['img_file'];
				unset($this->request->data['Image']);
			}
            debug($this->request->data);
//            debug($this->Image->actsAs['Upload']['img_file']['allowed_mime']);//die;
            $success = TRUE;
            $message = null;
            
            // set the target directory
            $imageDirectory = 'img/images';
            $this->Image->Behaviors->Upload->setImageDirectory('Image', 'img_file', $imageDirectory);
            foreach ($this->request->data as $index => $val) {
                
                // May have chosen Image.title from list rather then typing it
                $this->scanListChoices($val);

                // Handle deletion request of old image
                if(isset($val['Image']['task'])&&$val['Image']['task']=='delete'){
                    unlink($imageDirectory . '/upload/' . $val['Image']['disallowed_file']);
                }
                
                // Handle incoming image
                if (!$val['Image']['img_file']['name']==null) {
                    
                    // verify upload file type
                    if((array_search($val['Image']['img_file']['type'], $this->Image->actsAs['Upload']['img_file']['allowed_mime']))===FALSE){
                        $this->fileError[$index]="Wrong file type {$val['Image']['img_file']['type']}";
                        continue;
                    } elseif(isset($val['Image']['current_image'])){
//                        debug($val['Image']['current_image']);die;
                        // if we have a good upload file and it's replacing a current image
                        $this->delete_image_files($val['Image']['current_image']);
                    }
                    
                    $val['Image']['upload'] = ($val['Image']['upload'] == null) ? $this->lastUpload+1 : $val['Image']['upload'];
                    $this->Image->create($val);
                    if ($this->Image->save()) {
                        $message .= '<p>Saved ' . $this->Image->id . ' ' . $val['Image']['img_file']['name'] . ' but not the exif data.</p>';
                        $success && TRUE;
                        
                        //read exif data and set exif fields
                        $filePath = $imageDirectory . '/native/' . $val['Image']['img_file']['name'];
                        $exifData = exif_read_data($filePath);
                        $updateExif['Image'] = array(
                            'id' => $this->Image->id,
                            'height' => $exifData['COMPUTED']['Height'],
                            'width' => $exifData['COMPUTED']['Width'],
                            'date' => strtotime($exifData['DateTimeOriginal'])
                        );

                        if($this->Image->save($updateExif)){
                            $message .= '<p>Saved ' . $this->Image->id . ' ' . $val['Image']['img_file']['name'] . ' exif data.</p>';
                            $success && TRUE;
                        }
                    } else {
						debug($this->Image->validationErrors);
                        $message .= 'Failed ' . $val['Image']['img_file']['name'] . '. ';
                        $success && FALSE;
                    }
                }
            } // End of this->data loop
            
            $this->Session->setFlash(__($message)); 
            
        } //end of posted data processing
        
//        $this->searchRecords = array();
        
        // if there were bad upload files, we'll keep those for reprocessing
        // in all other cases, including no data, we'll do standard search
        // [3] If save failures, redisplay them for correcion
        if($this->fileError){
            $this->searchRecords = array();
            foreach($this->fileError as $index => $message){
                $this->searchRecords[]=$this->request->data[$index];
                $error[] = $message;
                $this->fileError = $error;
            }
            $this->set('fileError',$this->fileError);
//            $this->request->data=null;
            
        } else {
        // [4] No failures (including no save attempt). What should be displayed?
        
            // multi_add/disallowed set $this->uploadCount to # of disallowed
            // multi_add/[0-9]+ set $this->uploadCount to [0-9]+
            // Session 'qualityConditions' set $this->searchRecords
            
            // First handle possible uri encoded requests
            if(isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'disallowed') { 
                $this->uploadCount = count($this->disallowed);
                $this->Session->setFlash("$this->uploadCount Records were found for '{$this->request->params['pass'][0]}'");

                
            } elseif (isset($this->request->params['pass'][0]) && (intval($this->request->params['pass'][0]) == $this->request->params['pass'][0])) {
                $this->uploadCount = $this->searchInput;
                
            // no uri encoded, check for stored user search
            } elseif($this->Session->check('qualityConditions')) {
//                debug(unserialize($this->Session->read('qualityConditions')));
                $this->searchInput = false;
                $qualityConditions = unserialize($this->Session->read('qualityConditions'));
                $this->searchRecords = $this->Image->Content->siteSearchRaw($qualityConditions);
                $this->searchRecords = $this->reconfigureRawSearch($this->searchRecords);
                $this->Session->setFlash(count($this->searchRecords).' Records were found for <pre>'. print_r($qualityConditions, TRUE) . '</pre>');
                
            } else {
                $this->uploadCount = 1;
            }
        }
        
        // [5] Prep context sensitive controls for View
        if($this->searchRecords){
            $this->uploadCount = count($this->searchRecords);
//            $this->Session->setFlash("$this->uploadCount Records were found for '$this->searchInput'");
//            if($this->searchRecords == array()){
//                $this->Session->setFlash('No records found for search '.$this->searchInput);
//            }
        }
        $this->set('countMax', 
                ($this->disallowed || $this->searchRecords || $this->uploadCount)
                ? $this->uploadCount : 0);
        $this->set('searchRecords',  $this->searchRecords);
        $this->set('disallowed',  $this->disallowed);
        $this->set('searchInput', $this->searchInput);
        $this->set('recentTitles',  $this->Image->recentTitles);
   }

    function out($line){
        debug($line);
        debug(($this->uploadCount) ? 'uploadCount ' . $this->uploadCount : 'uploadCount false');
        debug(($this->searchInput) ? 'searchInput ' . $this->searchInput : 'searchInput false');
        debug(($this->searchAction) ? 'searchAction ' . $this->searchAction : 'searchAction false');
        if ($this->searchRecords){
            debug($this->searchRecords);
        }else{
            'searchRecords false';
        }
//        debug(($this->searchRecords) ? 'searchRecords ' . $this->searchRecords : 'searchRecords false');
        debug(($this->disallowed) ? 'disallowed ' . $this->disallowed : 'disallowed false');
    }
    
    function edit($id = null) {
            if (!$id && empty($this->request->data)) {
                    $this->Session->setFlash(__('Invalid image'));
                    $this->redirect(array('action' => 'index'));
            }
            if (!empty($this->request->data)) {
                    if ($this->Image->save($this->request->data)) {
                            $this->Session->setFlash(__('The image has been saved'));
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The image could not be saved. Please, try again.'));
                    }
            }
            if (empty($this->request->data)) {
                    $this->request->data = $this->Image->read(null, $id);
            }
    }

    function delete($id = null) {
        if (!$id) {
                $this->Session->setFlash(__('Invalid id for image'));
                $this->redirect(array('action'=>'index'));
        }
        if ($this->Image->delete($id)) {
                $this->Session->setFlash(__('Image deleted'));
                $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Image was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Analyzes the array of deletion requests from clean_up
     * 
     * Examines both direct deletion requests and dependent records
     * and compiles an array of all the record ids that need deleting
     * The array contains Image, Content, and ContentCollection ids in separate levels
     * 
     * @todo I'm concerened about Detail records linked to ContentCollections. 
     * 
     * @return array $delete Array of record ids to delete
     */
    function processDeletions(){
//            debug($this->request->data);
        $contents = $ccs = $delete_cc = $contentLevel = $delete_image = $delete_file = $delete_content = array();

        $images = array_keys($this->request->data); // image key set

        // locate Image record deletion requests and Content key set
        foreach($images as $key){
            if(isset($this->request->data[$key]['Content'])){
                $contentLevel = $contentLevel + $this->request->data[$key]['Content'];
                $contents = $contents + array_keys($this->request->data[$key]['Content']);
            }
            if($this->request->data[$key]['delete']==1){
                $delete_image[$key] = $key;
                if(!is_null($this->request->data[$key]['name']) && $this->request->data[$key]['delete_file']==1){
                    $delete_file[$this->request->data[$key]['name']] = $this->request->data[$key]['name'];
                }
            }
        }

        // locate Content record deletion requests and ContentColletion key set
        foreach($images as $key){
            foreach($contents as $ckey){
                if(isset($this->request->data[$key]['Content'][$ckey]['ContentCollection'])){
                    $ccs = $ccs + array_keys($this->request->data[$key]['Content'][$ckey]['ContentCollection']);
                }
                if(isset($this->request->data[$key]['Content']) && $this->request->data[$key]['Content'][$ckey]['delete']==1){
                    $delete_content[$ckey] = $ckey;
                }
            }
        }

        // locate ContentCollection record deletion requests
        foreach($images as $key){
            foreach($contents as $ckey){
                foreach($ccs as $cckey){
                    if(isset($this->request->data[$key]['Content'][$ckey]['ContentCollection'][$cckey]) 
                            && $this->request->data[$key]['Content'][$ckey]['ContentCollection'][$cckey]['delete']==1){
                        $delete_cc[$cckey] = $cckey;
                    }
                }
            }
        }

        // locate meaningful 'also delete' requests for Content
        foreach($delete_image as $key){
            foreach($contents as $ckey){
                if(isset($this->request->data[$key]['Content'][$ckey]) 
                        && $this->request->data[$key]['Content'][$ckey]['also']==1){
                    $delete_content[$ckey] = $ckey;
                }
            }
        }

        // locate meaningful 'also delete' ContentColletion requests 
        // using the specially constructed Content-level array.
        // We may delete a Content without deleting Image and in
        // this case, the dependent ContentCollection records
        // should go also
//            if(isset($delete_content)){
            foreach($delete_content as $key){
                foreach($ccs as $cckey){
                    if(isset($contentLevel[$key]['ContentCollection'][$cckey]) &&
                            $contentLevel[$key]['ContentCollection'][$cckey]['also']==1){
                        $delete_cc[$cckey] = $cckey;
                    }
                }
            }
//            }

        return array('File'=>$delete_file,
                'Image'=>$delete_image,
            'Content'=>$delete_content,
            'ContentCollection'=>$delete_cc
            );
//            debug($delete_image);
//            debug($delete_content);
//            debug($delete_cc);
//            die;
    }

    /**
     * Image record deletion management layout
     * 
     * Presents user's list (based on search) of image records and their linked
     * records for potential deletion. If no search is requested, orphans is the 
     * default list presented
     * 
     * Deletion of image will take down all dependents but ideally, 
     * the linked records should be deletable bit-by-bit.
     * 
     * Image files will be deleted also
     * 
     * @todo this fails to account for Details linked to ContentCollection
     * @todo image_grid properly retains a found set from here, but this layout doesn't use a found set from other contexts
     */
    function clean_up(){
        $this->layout = 'noThumbnailPage';
        $this->set('searchController','images');
        $this->setSearchAction('clean_up');
        
        if(isset ($this->request->data)){
            $delete = $this->processDeletions();
//                debug($delete);die;

            foreach($delete as $group => $set){
                switch ($group) {
                    case 'File' :
                        foreach($set as $name){
                            $this->delete_image_files($name);
                        }
                        break;
                    case 'Image':
                        foreach($set as $id){
                            $this->Image->delete($id);
                        }
                        break;
                    case 'Content' :
                        foreach($set as $id){
                            $this->Image->Content->delete($id);
                        }
                        break;
                    case 'ContentCollection' :
                        foreach($set as $id){
                            $this->Image->Content->ContentCollection->delete($id);
                        }
                        break;

                    default:
                        break;
                }

            }

////            $this->searchAction = 'clean_up';
//            $this->redirect(array('action'=>'search'));
       }

       // handle uri encoded request
        if(isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'orphan_images'){
            $this->searchRecords = $this->orphans; //move in the standing set of orphans
            
        // if no uri request, is there a saved user search?    
        } elseif($this->Session->check('qualityConditions')) {
//                debug(unserialize($this->Session->read('qualityConditions')));
            $this->searchInput = false;
            $qualityConditions = unserialize($this->Session->read('qualityConditions'));
            $this->findOnQualityConditions($qualityConditions);

        // no uri request or saved search, default to orphans
        } else {
            $this->searchRecords = $this->orphans; //move in the standing set of orphans
        }
            
//            $this->doSearch();
        if($this->searchRecords == array()){
            $this->Session->setFlash('No records found for search '.$this->searchInput);
        }
        $this->set('searchRecords',  $this->searchRecords);
    }

    /**
     * Work through the standard Image file directories deleting versions of a file
     * 
     * @param string $name Name of the image file to delete
     */
    function delete_image_files($name){
        $path = IMAGES."images/native/$name";
        if(is_file($path)){
            unlink($path);
            }
        foreach($this->sizes as $size => $size_again){
            $path = IMAGES."images/thumb/$size/$name";
            if(is_file($path)){
                unlink($path);
            }
        }
    }
//
//    /**
//         * $uploadRequest = the number of the upload set or false
//         * $uploadCount = the number of image upload forms to draw or false
//         */
////    function doSearch(){
////        debug($this->Session->read('qualityConditions'));
//        if($this->Session->check('qualityConditions')){
//            $this->redirect(array('controller'=>'images','action'=>'search'));
//        }
////        debug($this->searchInput);die;
//        // int = upload set
//        // orphan_images
//        $upload = false;
//        $param0 = (isset($this->request->params['pass'][0])) 
//                ? $this->request->params['pass'][0] : false; //simplify booleans later
//
//        preg_match('/id=[0-9]+|id between [0-9]+ and [0-9]+|id in \([0-9]+(,[0-9]+)*\)/i', $this->searchInput,$match);
//        if(isset($match[0])){
//            $this->searchRecords = $this->Image->find('all', array(
//                'conditions'=>$match[0],
//                'contain'=>$this->contain//$fields
//            ));
//            return;
//        }
//        // Handle interger search input
//        preg_match('/[0-9]+/',$this->searchInput,$match);
//        $uploadRequest = (
//                isset($match[0])
//                &&$match[0] > 0 
//                && ($this->searchAction != 'multi_add' && $this->request->action != 'multi_add')) 
//                    ? $match[0] : false;
//        $this->uploadCount = (
//                isset($match[0])
//                &&$match[0] > 0 
//                && ($this->searchAction == 'multi_add' || $this->request->action == 'multi_add')) 
//                    ? $match[0] : false;
//
//        // A bit of processing for upload set requests
//        if ($uploadRequest) {
//            if ($uploadRequest > 0 && $uploadRequest <= $this->lastUpload) {
//                $upload = $uploadRequest;
//            } else {
//                $this->Session->setFlash("Upload sets exist for values 1 - {$this->lastUpload}. Your request for set $uploadRequest can't be satisfied");
//            }
//        }
//        if ($this->searchInput == 'last_upload' || $param0 == 'last_upload'){
//            $upload = $this->lastUpload;
//        }
//
//        // processing for multi_add requests
//        if ($this->searchAction == 'multi_add' || $this->request->action == 'multi_add'){
//            if($this->uploadCount){
//                $this->searchRecords = false;
////                $this->disallowed = false;
//                return; // had integer searchInput
//            }
//            if($this->searchInput != 'disallowed' || $param0 != 'disallowed') {
//                
////                 $this->disallowed = false; 
//            } else {
//                $this->uploadCount = count($this->disallowed);
//                return; // had disallowed search or link
//            }
//            
//        }
//
//            
////            $this->out(698);die;
//            if ($upload) {
//                // search param was integer; that's an upload set number
//                $this->searchRecords = $this->Image->find('all', array(
//                    'conditions'=>array('Image.upload'=> $upload),
//                    'contain'=>$this->contain//$fields
//                ));
//            } elseif ($this->searchInput == 'orphan_images') {
//                // search param was a request to see orphan images
//                $this->searchRecords = $this->orphans;
//            } else {
//                // search param wasn't integer or orphan; that's means a field value search
//                $this->searchRecords = $this->Image->find('all', array(
//                'conditions'=>array('Image.alt LIKE'=> "%{$this->searchInput}%"),
//                'contain'=>$this->contain//$fields
//                ));
//                
//                foreach($this->searchRecords as $record){
//                    $idList[$record['Image']['id']] = true;
//                }
//                
//                $title = $this->Image->find('all', array(
//                'conditions'=>array('Image.title LIKE'=> "%{$this->searchInput}%"),
//                'contain'=>$this->contain//$fields
//                ));
//
//                foreach($title as $index => $record){
//                    if(isset($idList[$record['Image']['id']])){
//                        $killList[] = $index;
//                    }
//                }
//                if(isset($killList)){
//                    foreach($killList as $index){
//                        unset($title[$index]);
//                    }
//                }
//                $this->searchRecords = array_merge($this->searchRecords, $title);
//                
////                debug($title);
////                die;
//            }
//        }
        
    function implode_r($glue,$arr){
        $ret_str = "";
        foreach($arr as $a){
                $ret_str .= (is_array($a)) ? $this->implode_r($glue,$a) : $glue . $a;
        }
        return $ret_str;
        }
        
    /**
     * @todo Make this work for more than one action. possibly a case statement?
     * @todo Auto-searches, like 'last upload' aren't pulling the full data set like a manual search does
     */
    function search() {
//        debug($this->searchAction);
        $this->qualityConditions = false;
        if(isset($this->request->data) && $this->verifySearchData($this->request->data)){
                $this->qualityConditions = array();
                // Standard or Avanced search
                if($this->request->data['Standard']['searchInput']!=' Search'){
                    // Build standard query properties
                    //  $this->qualityConditions
                    //  $this->categoricalConditions
                    $this->buildStandardSearchConditions();
                } else {
                    // Build advanced query text search properties
                    //  $this->qualityConditions
                    //  $this->categoricalConditions
                    $advancedTextConditions = $this->buildAdvancedTextSearchConditions();
                    $advancedDateConditions = $this->buildAdvancedDateSearchConditions();
                    if ($advancedTextConditions){
                        $this->qualityConditions = array(
                            'OR' => $advancedTextConditions
                        );
                        if($advancedDateConditions){
                            $this->qualityConditions['AND'] = array(
                                'OR' => $advancedDateConditions
                            );
                        }
                    } elseif($advancedDateConditions){
                        $this->qualityConditions = array(
                            'OR' => $advancedDateConditions
                        );
                    }
                }
                $this->Session->write('qualityConditions', serialize($this->qualityConditions));
        }
//        debug($this->request->data);
//        debug($this->Session->read('qualityConditions'));//die;
        if($this->Session->check('qualityConditions')){
            $this->qualityConditions = unserialize($this->Session->read('qualityConditions'));
        }
        if($this->qualityConditions){
            $this->searchInput = $this->qualityConditions;
            $this->searchAction = $this->request->data['action'];
            $this->searchRecords = $this->Image->Content->siteSearchRaw($this->qualityConditions);
            $this->searchRecords = $this->reconfigureRawSearch($this->searchRecords);
//            unset($this->request->data);
            $this->request->data = array();
//            debug($this->searchRecords);
//            debug($this->qualityConditions);
//            die;
//            debug($this->qualityConditions);die;
//        debug($this->searchRecords);die;
            $this->layout = 'noThumbnailPage';
            $this->request->params['action'] = $this->searchAction;
            $this->request->request->url = $this->request->params['controller'].'/'.  $this->searchAction;
//            debug($this->request->params);
//            debug($this->searchAction);
            switch($this->searchAction){

                case 'clean_up':
                    $this->clean_up();
                    $this->render('clean_up');
                    break;

                case 'multi_add':
                    $this->multi_add();
                    $this->render("multi_add");
                    break;
                case 'index':
                    $this->index();
                    $this->render('index');
                    break;
                default :
                    $this->image_grid();
                    $this->render('image_grid');
                    break;
            }  
        }

//        $this->render($this->searchAction);
//
    
    }
    
    /**
     * 
     * Take an array in this form
     *  [0] => Array
     *      [Content] => Array
     *              [fields] => field data
     *      [Image] => Array
     *              [fields] => field data
     *      [ContentCollection] => Array
     *              [0] => Array
     *                      [fields] => field data
     *                      [Collection] => Array
     *                          [fields] => field data
     *
     * and convert it to an array in this form
     * [5] => Array
     *      [Image] => Array
     *          [fields] => field data
     *      [Content] => Array
     *          [0] => Array
     *              [fields] => field data
     *                  [ContentCollection] => Array
     *                      [0] => Array
     *                          ([fields] => field data
     *                              [Collection] => Array
     *                                  [fields] => field data
     *          [1] => Array
     *              [fields] => field data
     *                  [ContentCollection] => Array
     *                      [0] => Array
     *                          [fields] => field data
     *                              [Collection] => Array
     *                                  [fields] => field data
     *
     * @param type $data
     */
    function reconfigureRawSearch($data){
        $search_result = false;
        if($data){
            foreach($data as $record){
                $image_id = $record['Image']['id'];
                if(!isset($search_result[$image_id])){
                    $search_result[$record['Image']['id']]['Image'] = $record['Image'];
                }
                if(is_array($record['Content'])){
                    $record['Content']['ContentCollection'] = $record['ContentCollection'];
                    $search_result[$image_id]['Content'][] = $record['Content'];
                }
            }
        }
//        debug($search_result);die;
        return $search_result;
    }

    
    function change_collection($slug = 'lucha-libre', $collection_id = 60){
        $links = array();
        if(isset($this->request->data)){
            $master = array_shift($this->request->data);
            
            foreach($this->request->data as $index => $record){
                if($record['changed'] != 0){
                    if($record['Content']['id']==''){
                        $this->Image->Content->create();
                        $this->Image->Content->save($record);
                        $record['ContentCollection']['content_id'] = $this->Image->Content->id;
                        $record['ContentCollection']['id'] = '';
                        $this->Image->Content->ContentCollection->create();
                        $this->Image->Content->ContentCollection->save($record);
                    } else {
                        $this->Image->Content->create();
                        $this->Image->Content->save($record);
                        $this->Image->Content->ContentCollection->create();
                        $this->Image->Content->ContentCollection->save($record);
                    }
                    // Build data for links to saved/moved articles
                    $content = $this->Image->Content->read('slug',$this->Image->Content->id);
                    $links[$content['Content']['slug'].$record['ContentCollection']['collection_id']]=array($content['Content']['slug'],$record['ContentCollection']['collection_id']);
                }
            }
        }
        $this->set('links',$links);
        $this->set('allTitles',  $this->Image->Content->ContentCollection->pullArticleList());
        $this->searchRecords = $this->Image->Content->ContentCollection->pullForChangeCollection($slug, $collection_id);
//        debug($this->searchRecords);die;
        // this is how the set of collection selectors are made in the element
        // $groups is a valid part of a field list for the fieldset helper
        $allCollections = $this->Image->Content->ContentCollection->Collection->allCollections();
        //This will allow setting the default collection in the proper list (processed $allCollection)
        $this->set('default',array($this->searchRecords[0]['Collection']['Category']['name'], $collection_id));
        $this->set('allCollections', $allCollections);

        $this->set('slug',$slug);
        $this->set('collection_id',$collection_id);
        $this->set('searchRecords',  $this->searchRecords);
//        $this->image_grid();
        $this->setSearchAction('change_collection');
        }
    /**
     * Image grid interface for admins
     * 
     * This is the main image management and review layout.
     * It allows image display in different sizes and grid counts
     * and in concert with $this->search, allows selection of 
     * Image sub-sets for editing and Collection creation
     * 
     * This layout also watches the Image Upload folder for 
     * new pictures and provides tools to process those pictuers
     * 
     * @todo after editing a displayed record, the 
     * @todo the Content fieldsets that output don't have any Collection membership information showing. This might be very helpful though. Can the Content-Element/FieldsetHelper handle this?
     */
    function image_grid(){
//        debug($this->request->data);die;
//        debug($this->Image->allTitles);
        $this->layout = 'noThumbnailPage';
        $this->set('searchController','images');
        $this->setSearchAction('image_grid');
        $allCollections = $this->Image->Content->ContentCollection->Collection->allCollections();
        $this->set('recentTitles',  $this->Image->recentTitles);
        $this->set('allTitles',  $this->Image->Content->ContentCollection->pullArticleList());
        $this->set('allCollections', $allCollections);
        $recentCollections = $this->Image->Content->ContentCollection->recentCollections();
        $this->set('recentCollections', $recentCollections);
        $this->set('collectionCategories',$collectionCategories = $this->Image->Content->ContentCollection->Collection->Category->categoryIN);

        //this is a process specific to Element:imageForm_exifFields.
        //It should be moved out to a common location latter
        if(isset($this->request->data)){
//            debug($this->request->data);
            foreach($this->request->data as $block){
                if ($block['changed'] != 0){
//                    debug($block);die;
                    $this->image_grid_save($block);
                }
            }
//            die;

        } // end of $this->request->data processing
//        debug($this->request->data);die;
//        debug($this);
        $qualityConditions = false;
       // handle uri encoded request
        if(isset($this->request->params['pass'][0])){
            if($this->request->params['pass'][0] == 'last_upload'){
                $qualityConditions = array('Image.upload' => $this->lastUpload);
            } elseif(intval($this->request->params['pass'][0]) == $this->request->params['pass'][0] && ($this->request->params['pass'][0]>0 && $this->request->params['pass'][0] <= $this->lastUpload)){
                $qualityConditions = array('Image.upload' => $this->request->params['pass'][0]); //move in the standing set of orphans
            }

        // if no uri request, is there a saved user search?    
        } elseif($this->Session->check('qualityConditions')) {
//                debug(unserialize($this->Session->read('qualityConditions')));
            $this->searchInput = false;
            $qualityConditions = unserialize($this->Session->read('qualityConditions'));

        // no uri request or saved search, default to orphans
        } else {
            $qualityConditions = array('Image.upload' => $this->lastUpload);
        }
//                debug($qualityConditions);die;
        $this->findOnQualityConditions($qualityConditions);
            
//            $this->doSearch();
//        if($this->searchRecords == array()){
//            $this->Session->setFlash('No records found for search '.$this->searchInput);
//        }
//        debug($this->searchRecords);
        $this->set('searchRecords',  $this->searchRecords);
//        if(!$this->searchRecords){
////            $this->searchInput = 'last_upload';
//            $this->searchAction = 'image_grid';
//            $this->doSearch();
//        }
//        
        if($this->searchRecords){
            foreach($this->searchRecords as $record){
                    $linkedContent[$record['Image']['id']] = $this->Image->Content->linkedContent($record['Image']['id']);
                }
            $this->set('linkedContent',$linkedContent);
            $this->set('chunk', array_chunk($this->searchRecords, $this->column+1));
        } else {
            $this->set('chunk',false);
            $this->Session->setFlash('No records found for search '.$this->searchInput);
        }

    }
    
            /**
     * Query using the user's conditions and return the results
     * 
     * @param array $conditions Cake conditions array for the query
     * @return false|array False or the found records
     */
    function findOnQualityConditions($qualityConditions){
//        debug($qualityConditions);//die;
        // newly uploaded images wont be found by siteSearchRaw()
        // and an Image context search can't handle the Content conditions
        // that may be present. So filter those out of the various condition arrays
        if(isset($qualityConditions['OR'])){
            foreach($qualityConditions['OR'] as $field => $condition){
                if(is_array($condition)){
                    $key = array_keys($condition);
//                    debug($key);die;
                    if(stristr($key[0], 'Image')){
                        $imageConditions['OR'][$field] = $condition;
                    }
                } elseif(stristr($field, 'Image')){
                    $imageConditions['OR'][$field] = $condition;
                }
            }
        } else {
            $imageConditions = $qualityConditions;
        }

        $this->searchRecords = $this->Image->Content->siteSearchRaw($qualityConditions);
        $this->searchRecords = $this->reconfigureRawSearch($this->searchRecords);
//        debug($imageConditions);
//                debug($qualityConditions);
        // now pick up the images that don't have Content records
        $new = $this->Image->find('all',array('conditions'=>$imageConditions));
//        debug($new);
        // now merge the arrays into one set
        foreach($new as $imageRecord){
//            debug($imageRecord);//die;
            if($imageRecord['Content'] == array()){
                unset($imageRecord['Content']);
                $this->searchRecords[$imageRecord['Image']['id']] = $imageRecord;
            }
        }
//        debug($this->searchRecords);die;
        $this->Session->setFlash(count($this->searchRecords).' Records were found for <pre>'. print_r($qualityConditions, TRUE) . '</pre>');
    }
    
    function image_grid_save($data){
                        
            // May have chosen Image.title from list rather then typing it
            $this->scanListChoices($data);
            
            if($data['Image']['reread_exif']){
                
                $exif = $this->Image->refreshExifData($data['Image']['img_file']);
                if(is_string($exif)){
                    $this->flash($exif);
                } elseif (is_array($exif)) {
                    $data['Image']['height'] = $exif['COMPUTED']['Height'];
                    $data['Image']['width'] = $exif['COMPUTED']['Width'];
                    $data['Image']['date'] = strtotime($exif['EXIF']['DateTimeOriginal']);
                    $data['Image']['mymetype'] = $exif['FILE']['MimeType'];
                    $data['Image']['size'] = $exif['FILE']['FileSize'];
                }
            }
            // img_file is a file input and having update data triggers
            // an attempt to process an incoming image. That causes an error.
            unset($data['Image']['img_file']); 
            // save all updated data
            $message = ($this->Image->save($data))
                ? 'Image changes saved'
                : 'Image changes not saved';
            if(isset($data['Content'][0])){
                foreach($data['Content'] as $recordNumber => $contentRecord){
                    if(is_int($recordNumber)){
                        $contentdata=array('Content'=>$contentRecord);
//                        debug($data);die;
                        $this->Image->Content->create($contentdata);
                        $message .= ($this->Image->Content->save())
                             ? "<br />Content record $recordNumber saved."
                             : "<br />Content record $recordNumber not saved.";
                        $this->Image->Content->ContentCollection->saveAll($contentdata['Content']['ContentCollection']);
                    }
                }
            }

            $this->Session->setFlash($message);

            // probe the Collection Membership Assignment choices

            // first look for a content record selection
            if($data['Content']['linked_content']!=0){
                // New or existing content was selected for membership. Get its ID
                if($data['Content']['linked_content']==1){
                    $content['Content']['image_id'] = $data['Image']['id'];
                    $content['Content']['heading'] = $data['Image']['title'];
                    $content['Content']['content'] = $data['Image']['alt'];
                    $content['Content']['created'] = date('Y-m-d h:i:s',time());
                    $content['Content']['modified'] = date('Y-m-d h:i:s',time());
                    $this->Image->Content->create($content);
//                    debug('linked content save');
                    $this->Image->Content->save();
                    $content_id = $this->Image->Content->id;
                    
                    // resave to get the slug to calculate properly
                    $content['Content']['id'] = $content_id;
                    $this->Image->Content->create($content);
                    $this->Image->Content->save();
                } else {
                    $content_id = $data['Content']['linked_content'];
                }
            }

            // next look for a request to create a new Collection
            if($data['Content']['new_collection']!=null){
                $collection['Collection']['heading'] = $data['Content']['new_collection'];
                $collection['Collection']['category_id'] = $data['Content']['new_collection_category'];
                $this->Image->Content->ContentCollection->Collection->create($collection);
//                debug('new collection save');
                $this->Image->Content->ContentCollection->Collection->save();
                $collectionIDs[] = $this->Image->Content->ContentCollection->Collection->id;
            }
            // continue by gather other selected collection ids
            if($data['Content']['recent_collections']!=0){
                $collectionIDs[] = $data['Content']['recent_collections'];
            }
            // and more selected collection ids
            foreach($this->Image->Content->ContentCollection->Collection->Category->categoryIN as $category){
                if(is_array($data['Content'][$category])){
                    foreach($data['Content'][$category] as $choice){
                        if($choice!=0){
                            $collectionIDs[] = $choice;
                        }
                    }
                }
            }

            // now assemble the data array for ContentCollection record creation
            if(isset($content_id) && isset($collectionIDs)){
                //have to have both links of course!
                $cc_record_count = 0;
                foreach($collectionIDs as $collection_id){
                    $content_collection['ContentCollection']['content_id'] = $content_id;
                    $content_collection['ContentCollection']['collection_id'] = $collection_id;
                 $this->Image->Content->ContentCollection->create($content_collection);
//                 debug('content_collection save');
                $this->Image->Content->ContentCollection->save();
               }
//                debug($collectionIDs);
//                debug($content_id);
//                debug($content_collection);die;$this->Image->Content->ContentCollection->Collection->Category->categoryIN
            }
//            unset($data);
//            $this->searchAction = 'image_grid';
//            $this->redirect(array('action'=>'search'));

    }

    /**
     * Populate an Image records exif fields
     * If the record is a has a type=file format with uploaded
     * image data in the Image.img_file array, the uploading
     * file will be operated on. Providing a path will override
     * that or get data for a non-upload-style record
     * 
     * @todo Get some error trapping in here!
     * @param array &$record A standard one record data array
     * @param string $path Path to the image including the file name
     */
    function get_exif(&$record, $path=null) {

        if ($path == null) {
            $path = $record['Image']['img_file']['tmp_name'];
        }

        $file = new File($path);            
        $exif_data = exif_read_data($file->path);
//            debug($exif_data);die;
        $record['Image']['height'] = $exif_data['COMPUTED']['Height'];
        $record['Image']['width'] = $exif_data['COMPUTED']['Width'];
        $record['Image']['date'] = strtotime($exif_data['DateTime']);
        $record['Image']['mymetype'] = $exif_data['MimeType'];
        $record['Image']['size'] = $exif_data['FileSize'];
        debug($exif_data);die;
    }

    /**
     * Ingest images rountines copied in 
     */
    /**
     * Build the starter arrays of table data for bulk image processing
     *
     * This build only the display data for the tables
     * The tables will also include links to do things
     * Those will be made by HTMLHelper in the view and ajax-infused
     */
    function ingest_images() {
        $this->Image->Behaviors->Upload->setImageDirectory('Image', 'img_file', 'img/images');
        $this->Image->ingest_images(); //this is in Upload behavior
//            debug($this->Image->Behaviors->Upload); die;
        debug($this->Image->Behaviors->Upload->disallowed);
        debug($this->Image->Behaviors->Upload->dup);
        debug($this->Image->Behaviors->Upload->new);
        die;
        App::uses('Html', 'Helper');
    }

}
?>