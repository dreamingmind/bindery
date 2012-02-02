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
 * Images Controller
 * 
 * @package       bindery
 * @subpackage    bindery.controller
 * @todo write populator that reads the current image collection and writes records for images that don't have them
 * @property Image $Image
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
     * @var int $column The default number of columns for Image Grid display
     */
    var $column = 8;

    /**
     * @var string $size The default size for Image Grid display
     */
    var $size = 'x75y56';

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
                'fields'=> array('id','collection_id'),
                'Collection'=>array(
                    'fields'=>array('heading')
                )
            )
        ));

    var $layout = 'noThumbnailPage';
    
    /**
     *
     * @var array $fileError array of messages about upload files of the wrong type
     */
    var $fileError = False;

    /**
     * Take care of ImageController housekeeping
     * 
     * If this is a site manager:
     *  Get the lastUpload value
     *  Check the upload folder and make the analyzed contents available
     * 
     * There can be several forms on the page, so once the the page-controll forms are
     * analyzed, $this->data must cleared to prevent false positives for 
     * site data modification checks. unset causes auth error so = null
     * 
     * @todo Make the beforeFilter more Action specific. Some things aren't ALWAYS needed
     * @todo search/1 then hit Admin/Image will f'up $this->searchInput. Other values work. Odd
     */
    function beforeFilter(){
//            debug($this->data);die;
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
           $this->Image->ingest_images(); //this is in Upload behavior which reads the upolad folder

           // these will be false or arrays of file data from the upload folder
           $this->set('disallowed',$this->disallowed = $this->Image->Behaviors->Upload->disallowed);
           $this->set('duplicate',  $this->duplicate = $this->Image->Behaviors->Upload->dup);
           $this->set('new',  $this->new = $this->Image->Behaviors->Upload->new);

           // Save or read page-state values
            if(isset($this->data['Image']['columns'])){
                $this->column = $this->data['Image']['columns'];
                $this->size = $this->data['Image']['sizes'];
                $this->data=null;
//                    debug($this->data);die;

            } elseif ($this->Session->check('Image.columns')) {
                $this->column = $this->Session->read('Image.columns');
                $this->size = $this->Session->read('Image.sizes');
            }

            if(isset($this->data['Image']['searchInput'])){
                // user requested search
                $this->searchInput = $this->data['Image']['searchInput'];
                $this->searchAction= $this->data['Image']['action'];
                $this->data = null;
            } elseif(isset($this->params['pass'][0])){
                //Some actions might have param base search request
                if($this->checkLinkPatterns($this->action . ':' . $this->params['pass'][0])){
                    $this->searchInput = $this->params['pass'][0];
                    $this->searchAction = $this->action;
                }
            } elseif($this->Session->check('Image.searchInput')){
                $this->searchInput = $this->Session->read('Image.searchInput');
            }
//                debug($this->data);die;
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
//            $this->set('hidden', array('action'=>array('value'=>  $this->action)));

    }

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
        $this->setSearchAction('index');
        
        $conditions = array();
        if ($this->searchInput){
            $conditions = array('conditions'=> array(
                'Image.alt LIKE'=>"%$this->searchInput%"
            ));
            $this->Session->setFlash("Search term: $this->searchInput");
        }
        $this->paginate = array('order'=>array('Image.id'=> 'desc')) + $conditions;
        $this->Image->recursive = 0;
        $this->set('images', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid image', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('image', $this->Image->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            //debug($this->data); die;
            //read exif data and set exif fields
            
            $this->get_exif($this->data);
            
            //Target the selected Upload directory
//            $this->Image->setImageDirectory($this->data['Image']['gallery']);
//            debug($this->Image); die;
            
            $this->Image->create();
        if ($this->Image->save($this->data)) {
                $this->Session->setFlash(__('The image has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
            }
        }
    }
    
    /**
     * Handle duplicate images that have been placed in the Upload folder
     */
    function duplicate_uploads(){
//        debug($this->data);
//        debug($this->duplicate);die;
        if(!is_array($this->duplicate)){
            $this->Session->setFlash("Duplicates are all processed. There are no more duplicate images in the Upload folder.");
            $this->redirect(array('action'=>'search'));
        }
        $delete = array();
        if (isset($this->data)){
            foreach($this->data as $index => $image){
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
                unset($this->duplicate[$this->data[$index]['Image']['img_file']]);
                unset($this->data[$index]);
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
        if (isset($this->data)){
            debug($this->data);die;
        }
        $this->layout = 'noThumbnailPage';
    }
    
    /**
     * Handle new images that have been placed the Upload folder
     */
    function new_uploads(){
        if(!is_array($this->new)){
            $this->Session->setFlash("There are no valid new images in the Upload folder. You should only use an onscreen link to come to this page.<br \\>
                \$this->new should have an array of upoload file info. <br \\>It has: <br \\>"
                    . print_r($this->new, TRUE));
            $this->set('new',false);
        }
        if(isset($this->data)){
//            debug($this->data);die;
            // Look for deletion  and hold requests first
            $delete = $hold = array();
           foreach ($this->data as $count => $image){
               if($image['Image']['task']=='delete'){
                   $delete[]=$count;
               } elseif ($image['Image']['task']=='hold'){
                   $hold[]=$count;
               }
           }
           foreach($delete as $index=>$pointer){
                unlink($this->data[$pointer]['Image']['img_file']['tmp_file']);
                unset($this->data[$pointer]);
           }
           foreach($hold as $index=>$pointer){
               unset($this->data[$pointer]);
           }
           $this->Image->saveAll($this->data);
           $this->redirect(array('action'=>'search',  $this->lastUpload+1));
        }
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
        if (!empty($this->data)) {
//            debug($this->data);die;
//            debug($this->Image->actsAs['Upload']['img_file']['allowed_mime']);//die;
            $success = TRUE;
            $message = null;
            
            // set the target directory
            $imageDirectory = 'img/images';
            $this->Image->Behaviors->Upload->setImageDirectory('Image', 'img_file', $imageDirectory);
            foreach ($this->data as $index => $val) {
                
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
                            'date' => $exifData['FileDateTime']
                        );

                        if($this->Image->save($updateExif)){
                            $message .= '<p>Saved ' . $this->Image->id . ' ' . $val['Image']['img_file']['name'] . ' exif data.</p>';
                            $success && TRUE;
                        }
                    } else {
                        $message .= 'Failed ' . $val['Image']['img_file']['name'] . '. ';
                        $success && FALSE;
                    }
                }
            } // End of this->data loop
            
            $this->Session->setFlash(__($message, true)); 
            
        } //end of posted data processing
        
        $this->layout = 'noThumbnailPage';
        $this->setSearchAction('multi_add');
        $this->searchRecords = array();
        
        // if there were bad upload files, we'll keep those for reprocessing
        // in all other cases, including no data, we'll do standard search
        if($this->fileError){
            foreach($this->fileError as $index => $message){
                $this->searchRecords[]=$this->data[$index];
                $error[] = $message;
                $this->fileError = $error;
            }
            $this->set('fileError',$this->fileError);
//            $this->data=null;
            
        } else {
            $this->doSearch();
        }
        
        if($this->searchRecords){
            $this->uploadCount = count($this->searchRecords);
            $this->Session->setFlash("$this->uploadCount Records were found for '$this->searchInput'");
            if($this->searchRecords == array()){
                $this->Session->setFlash('No records found for search '.$this->searchInput);
            }
        }
        
        $this->set('countMax', 
                ($this->disallowed || $this->searchRecords || $this->uploadCount)
                ? $this->uploadCount : 1);
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
            if (!$id && empty($this->data)) {
                    $this->Session->setFlash(__('Invalid image', true));
                    $this->redirect(array('action' => 'index'));
            }
            if (!empty($this->data)) {
                    if ($this->Image->save($this->data)) {
                            $this->Session->setFlash(__('The image has been saved', true));
                            $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('The image could not be saved. Please, try again.', true));
                    }
            }
            if (empty($this->data)) {
                    $this->data = $this->Image->read(null, $id);
            }
    }

    function delete($id = null) {
        if (!$id) {
                $this->Session->setFlash(__('Invalid id for image', true));
                $this->redirect(array('action'=>'index'));
        }
        if ($this->Image->delete($id)) {
                $this->Session->setFlash(__('Image deleted', true));
                $this->redirect(array('action'=>'index'));
        }
        $this->Session->setFlash(__('Image was not deleted', true));
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
//            debug($this->data);
        $contents = $ccs = $delete_cc = $contentLevel = $delete_image = $delete_file = $delete_content = array();

        $images = array_keys($this->data); // image key set

        // locate Image record deletion requests and Content key set
        foreach($images as $key){
            if(isset($this->data[$key]['Content'])){
                $contentLevel = $contentLevel + $this->data[$key]['Content'];
                $contents = $contents + array_keys($this->data[$key]['Content']);
            }
            if($this->data[$key]['delete']==1){
                $delete_image[$key] = $key;
                if(!is_null($this->data[$key]['name']) && $this->data[$key]['delete_file']==1){
                    $delete_file[$this->data[$key]['name']] = $this->data[$key]['name'];
                }
            }
        }

        // locate Content record deletion requests and ContentColletion key set
        foreach($images as $key){
            foreach($contents as $ckey){
                if(isset($this->data[$key]['Content'][$ckey]['ContentCollection'])){
                    $ccs = $ccs + array_keys($this->data[$key]['Content'][$ckey]['ContentCollection']);
                }
                if(isset($this->data[$key]['Content']) && $this->data[$key]['Content'][$ckey]['delete']==1){
                    $delete_content[$ckey] = $ckey;
                }
            }
        }

        // locate ContentCollection record deletion requests
        foreach($images as $key){
            foreach($contents as $ckey){
                foreach($ccs as $cckey){
                    if(isset($this->data[$key]['Content'][$ckey]['ContentCollection'][$cckey]) 
                            && $this->data[$key]['Content'][$ckey]['ContentCollection'][$cckey]['delete']==1){
                        $delete_cc[$cckey] = $cckey;
                    }
                }
            }
        }

        // locate meaningful 'also delete' requests for Content
        foreach($delete_image as $key){
            foreach($contents as $ckey){
                if(isset($this->data[$key]['Content'][$ckey]) 
                        && $this->data[$key]['Content'][$ckey]['also']==1){
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

        if(isset ($this->data)){
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
        $this->layout = 'noThumbnailPage';
        $this->setSearchAction('clean_up');

        if(!$this->searchInput){
            $this->searchInput = 'orphan_images';
        }
        $this->doSearch();
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

    /**
         * $uploadRequest = the number of the upload set or false
         * $uploadCount = the number of image upload forms to draw or false
         */
    function doSearch(){
        // int = upload set
        // orphan_images
        $upload = false;
        $param0 = (isset($this->params['pass'][0])) 
                ? $this->params['pass'][0] : false; //simplify booleans later

        // Handle interger search input
        preg_match('/[0-9]+/',$this->searchInput,$match);
        $uploadRequest = (
                isset($match[0])
                &&$match[0] > 0 
                && ($this->searchAction != 'multi_add' && $this->action != 'multi_add')) 
                    ? $match[0] : false;
        $this->uploadCount = (
                isset($match[0])
                &&$match[0] > 0 
                && ($this->searchAction == 'multi_add' || $this->action == 'multi_add')) 
                    ? $match[0] : false;

        // A bit of processing for upload set requests
        if ($uploadRequest) {
            if ($uploadRequest > 0 && $uploadRequest <= $this->lastUpload) {
                $upload = $uploadRequest;
            } else {
                $this->Session->setFlash("Upload sets exist for values 1 - {$this->lastUpload}. Your request for set $uploadRequest can't be satisfied");
            }
        }
        if ($this->searchInput == 'last_upload' || $param0 == 'last_upload'){
            $upload = $this->lastUpload;
        }

        // processing for multi_add requests
        if ($this->searchAction == 'multi_add' || $this->action == 'multi_add'){
            if($this->uploadCount){
                $this->searchRecords = false;
//                $this->disallowed = false;
                return; // had integer searchInput
            }
            if($this->searchInput != 'disallowed' || $param0 != 'disallowed') {
                
//                 $this->disallowed = false; 
            } else {
                $this->uploadCount = count($this->disallowed);
                return; // had disallowed search or link
            }
            
        }

            
//            $this->out(698);die;
            if ($upload) {
                // search param was integer; that's an upload set number
                $this->searchRecords = $this->Image->find('all', array(
                    'conditions'=>array('Image.upload'=> $upload),
                    'contain'=>$this->contain//$fields
                ));
            } elseif ($this->searchInput == 'orphan_images') {
                // search param was a request to see orphan images
                $this->searchRecords = $this->orphans;
            } else {
                // search param wasn't integer or orphan; that's means a field value search
                $this->searchRecords = $this->Image->find('all', array(
                'conditions'=>array('Image.alt LIKE'=> "%{$this->searchInput}%"),
                'contain'=>$this->contain//$fields
                ));
            }
        }
        
    /**
     * @todo Make this work for more than one action. possibly a case statement?
     * @todo Auto-searches, like 'last upload' aren't pulling the full data set like a manual search does
     */
    function search() {
//            debug($this->searchAction);
        switch($this->searchAction){

            case 'clean_up':
                $this->clean_up();
//                    debug($this->searchInput);die;
                $this->render('clean_up');
                break;

            case 'multi_add':
                $this->multi_add();
                $this->render("multi_add");
                break;

            default :
                $this->image_grid();
                $this->render('image_grid');
                break;
        }

//        $this->render($this->searchAction);
//
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
//        debug($this->Image->recentTitles);
//        debug($this->Image->allTitles);
        $allCollections = $this->Image->Content->ContentCollection->Collection->allCollections();
        $this->set('recentTitles',  $this->Image->recentTitles);
        $this->set('allCollections', $allCollections);
        $recentCollections = $this->Image->Content->ContentCollection->recentCollections();
        $this->set('recentCollections', $recentCollections);
        $this->set('collectionCategories',$collectionCategories = $this->Image->Content->ContentCollection->Collection->getCategories());

        if(isset($this->data)){
            
            // May have chosen Image.title from list rather then typing it
            $this->scanListChoices($this->data);

            // save all updated data
            $message = ($this->Image->save($this->data))
                ? 'Image changes saved'
                : 'Image changes not saved';
            if(isset($this->data['Content'][0])){
                foreach($this->data['Content'] as $recordNumber => $contentRecord){
                    if(is_int($recordNumber)){
                        $data=array('Content'=>$contentRecord);
//                        debug($data);die;
                        $this->Image->Content->create($data);
                        $message .= ($this->Image->Content->save())
                             ? "<br />Content record $recordNumber saved."
                             : "<br />Content record $recordNumber not saved.";
                    }
                }
            }

            $this->Session->setFlash($message);

            // probe the Collection Membership Assignment choices

            // first look for a content record selection
            if($this->data['Content']['linked_content']!=0){
                // New or existing content was selected for membership. Get its ID
                if($this->data['Content']['linked_content']==1){
                    $content['Content']['image_id'] = $this->data['Image']['id'];
                    $content['Content']['heading'] = "New content for record {$this->data['Image']['id']}:: {$this->data['Image']['title']}";
                    $content['Content']['content'] = $this->data['Image']['alt'];
                    $content['Content']['created'] = date('Y-m-d h:i:s',time());
                    $content['Content']['modified'] = date('Y-m-d h:i:s',time());
                    $this->Image->Content->create($content);
                    debug('linked content save');
                    $this->Image->Content->save();
                    $content_id = $this->Image->Content->id;
                } else {
                    $content_id = $this->data['Content']['linked_content'];
                }
            }

            // next look for a request to create a new Collection
            if($this->data['Content']['new_collection']!=null){
                $collection['Collection']['heading'] = $this->data['Content']['new_collection'];
                $collection['Collection']['category'] = $this->data['Content']['new_collection_category'];
                $this->Image->Content->ContentCollection->Collection->create($collection);
                debug('new collection save');
                $this->Image->Content->ContentCollection->Collection->save();
                $collectionIDs[] = $this->Image->Content->ContentCollection->Collection->id;
            }
            // continue by gather other selected collection ids
            if($this->data['Content']['recent_collections']!=0){
                $collectionIDs[] = $this->data['Content']['recent_collections'];
            }
            // and more selected collection ids
            foreach($collectionCategories as $category){
                if(is_array($this->data['Content'][$category])){
                    foreach($this->data['Content'][$category] as $choice){
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
                 debug('content_collection save');
                $this->Image->Content->ContentCollection->save();
               }
//                debug($collectionIDs);
//                debug($content_id);
//                debug($content_collection);die;
            }
//            unset($this->data);
//            $this->searchAction = 'image_grid';
//            $this->redirect(array('action'=>'search'));
        } // end of $this->data processing

        $this->layout = 'noThumbnailPage';
        $this->setSearchAction('image_grid');

        if(!$this->searchInput){
            $this->searchInput = 'last_upload';
        }
        $this->doSearch();
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
        App::import('Helper','Html');
    }

}
?>