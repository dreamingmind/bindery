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
         * The orphan Image records
         * @var array $orphans Image records that link to no Content record
         */
        var $orphans = false;
        
        var $layout = 'noThumbnailPage';

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
//                    unset($this->data['Image']);
                    $this->data=null;
//                    debug($this->data);die;

                } elseif ($this->Session->check('Image.columns')) {
                    $this->column = $this->Session->read('Image.columns');
                    $this->size = $this->Session->read('Image.sizes');
                }
                
                // Remember any Image context searches
                if(isset($this->data['Image']['searchInput']) 
                  ||($this->params['action'] == 'search' && isset($this->params['pass'][0]))){
                    $this->searchInput =  isset($this->data['Image']['searchInput'])
                        ? $this->data['Image']['searchInput']
                        : $this->params['pass'][0];
                    if(isset($this->data['Image']['searchInput'])){
                        $this->searchAction = (isset($this->data['Image']['action']))
                                ? $this->data['Image']['action']
                                : '';
                        $this->data=null;
                    }
                } elseif ($this->Session->check('Image.searchInput')) {
                    $this->searchInput =  $this->Session->read('Image.searchInput');
                } elseif (!$this->searchInput) {
                    $this->searchInput =  $this->lastUpload;
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
            
        }

    function pull_orphans(){
       $this->orphans = $this->Image->query("SELECT * FROM `images` AS `Image` 
        WHERE NOT EXISTS (SELECT Content.image_id FROM contents AS Content 
        WHERE Content.image_id = Image.id); ");
       $this->set('orphans', $this->orphans);
    }
    
	function index() {
            $this->paginate = array('order'=>array('Image.id'=> 'desc'));
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
            // Look for deletion requests first
            $delete = array();
           foreach ($this->data as $count => $image){
               if($image['Image']['task']=='delete'){
                   $delete[]=$count;
               }
           }
           foreach($delete as $index=>$pointer){
                unlink($this->data[$pointer]['Image']['img_file']['tmp_file']);
                unset($this->data[$pointer]);
           }
           $this->Image->saveAll($this->data);
           $this->redirect(array('action'=>'search',  $this->lastUpload+1));
        }
        $this->layout = 'noThumbnailPage';
    }
    
    /**
     * Create a layout to upload several images at once
     * @param type $count 
     */
    function multi_add($count=null) {
        if (!empty($this->data)) {
//            debug($this->data);die;
            //read exif data and set exif fields
            $success = TRUE;
            $message = null;
            foreach ($this->data as $val) {
                if (!$val['Image']['img_file']['name']==null) {
                    // set the target directory
                    //debug($val); die;
                    $this->Image->Behaviors->Upload->setImageDirectory('Image', 'img_file', 'img/'.$val['Image']['gallery']);
                    $this->Image->create();
                    if ($this->Image->save($val)) {
                        $message .= '<p>Saved ' . $this->Image->id . $val['Image']['img_file']['name'] . '.</p>';
                        $success && TRUE;
                    } else {
                        $message .= 'Failed ' . $val['Image']['img_file']['name'] . '. ';
                        $success && FALSE;
                    }
                }
            }
            if ($success) {
                $this->Session->setFlash(__($message, true));                    
                $this->redirect(array('action' => 'index'));                    
            }
                $this->Session->setFlash(__($message, true));                    
        }
        $this->layout = 'noThumbnailPage';
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
         * @todo image_grid properly retains a found set from here, but this layout doesn't use a found set from other contexts
         */
        function clean_up(){
            $this->set('searchRecords',  $this->searchRecords);
            $this->set('hidden',array('action'=>array('value'=>'clean_up')));
            if(isset ($this->data)){
                debug($this->data);die;
                $count=0;
                $id_list = "Image IDs: ";
                $this->image_death = "Image files: ";
                foreach($this->data as $id => $choice){
                    if($choice['action']==1){
                        $this->Image->delete($id);
                        $count++;
                        $id_list .= "$id ";
                        if(!is_null($choice['name'])&&$choice['delete_file']==1) {
                            $this->delete_image_files($choice['name']);
                        }
                    }
                }
            unset($this->data);
            $this->Session->setFlash("$count Image records deleted<br />$id_list<br />$this->image_death",
                'default', array('class'=>'cleanup'));
            $this->redirect(array('action'=>'clean_up'));
           }
        }
        
        function delete_image_files($name){
            $path = IMAGES."images/native/$name";
            if(is_file($path)){
                $this->image_death .= "$name ";
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
         * @todo Make this work for more than one action. possibly a case statement?
         */
        function search() {
//            debug($this->searchInput);
//            debug($this->referer());
//            
//            die;
            $upload = false;
            // A numberic pass[0] is an Upload set number. Please show that set.
            // And no search or pass[0] well default to the last Upload set
            preg_match('/[0-9]+/',$this->searchInput,$match);
            $uploadRequest = (isset($match[0])&&$match[0] > 0) ? $match[0] : false;
                
            if ($uploadRequest) {
                if ($uploadRequest > 0 && $uploadRequest <= $this->lastUpload) {
                    $upload = $uploadRequest;
                } else {
                    $this->Session->setFlash("Upload sets exist for values 1 - {$this->lastUpload}. Your request for set $uploadRequest can't be satisfied");
                }
            }
            
            if ($upload) {
                // search param was integer; that's an upload set number
                $this->searchRecords = $this->Image->find('all', array(
                    'conditions'=>array('Image.upload'=> $upload)
                ));
            } elseif ($this->searchInput == 'orphan_images') {
                // search param was a request to see orphan images
                $this->searchRecords = $this->orphans;
            } else {
                // search param wasn't integer or orphan; that's means a field value search
                $this->searchRecords = $this->Image->find('all', array(
                'conditions'=>array('Image.alt LIKE'=> "%{$this->searchInput}%"),
                'contain'=>array(
                    'Content'=>array(
                        'ContentCollection'=>array(
                            'fields'=> array('collection_id'),
                            'Collection'=>array(
                                'fields'=>array('heading')
                            )
                        )
                    )
                )
                ));
            }
            
            switch($this->searchAction){
                case 'clean_up':
                    $this->clean_up();
                    $this->render('clean_up');
                default :
                    $this->image_grid();
                    $this->render('image_grid');

            }

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
         * @todo the Content fieldsets that output don't have any Collection membership information showing. This might be very helpful though. Can the Content-Element/FieldsetHelper handle this?
         */
        function image_grid(){
            $allCollections = $this->Image->Content->ContentCollection->Collection->allCollections();
            $this->set('allCollections', $allCollections);
            $recentCollections = $this->Image->Content->ContentCollection->recentCollections();
            $this->set('recentCollections', $recentCollections);
            
            if(isset($this->data)){
                $this->Image->saveAll($this->data);
            }
            $this->layout = 'noThumbnailPage';
            if($this->searchRecords){
                foreach($this->searchRecords as $record){
                    $linkedContent[$record['Image']['id']] = $this->Image->Content->linkedContent($record['Image']['id']);
                }
                $this->set('linkedContent',$linkedContent);
                $this->set('chunk', array_chunk($this->searchRecords, $this->column+1));
            } else {
                $this->set('chunk',false);
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