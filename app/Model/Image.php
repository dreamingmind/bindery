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
 * Image Model
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
 */
App::import('Core', array('File', 'Folder'));
class Image extends AppModel {
    var $name = 'Image';
    var $displayField = 'img_file';

    var $hasMany = array('Content' => array(
                'className' => 'Content',
                'foreignKey' => 'image_id'
            ));

    /*
     * Modified version of Meio Upload Behavior
     * The modification changes the directory structure,
     * adds configuration control for more phpThumb options
     * and possibly adds support for multiple file uploads (unconfirmed)
     * 
     * img_file is the name of the required field to accept the image. The name will be stored here
     * dir must be reset for dispatches and exhibits
     * $this->Image->actsAs['Upload']['img_file']['dir'] = 'img/exhibits'
     * is the way to reset the value from a linked controller
     * $this->actsAs['Upload']['img_file']['dir'] = 'img/exhibits'
     * is assumed to be the method from inside this Class
     */
    var $actsAs = array(
        'Upload' => array(
            'img_file' => array(
                'dir' => 'img/images',
                'create_directory' => false,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
                'allowed_ext' => array('.jpg', '.jpeg', '.png', '.JPG', '.JPEG', '.PNG'),
                'thumbnailQuality' => 100, // Global Thumbnail Quality
                'minHeight' => 54,
                'zoomCrop' => True,
                'thumbsizes' => array(
                    'x54y54'=> array ('width' => 54, 'height' => 54,'opt'=>array('q'=>100, 'zc'=>'C')),
                    'x75y56' => array ('width' => 75, 'height' => 56),
                    'x160y120' => array ('width' => 160, 'height' => 120),
                    'x320y240' => array ('width' => 320, 'height' => 240),
                    'x500y375' => array ('width' => 500, 'height' => 375),
                    'x640y480' => array ('width' => 640, 'height' => 480),
                    'x800y600' => array ('width' => 800, 'height' => 600),
                    'x1000y750' => array ('width' => 1000, 'height' => 750)
                ),
            )
        )
    );
    
    function __construct() {
        parent::__construct();
        $recent_titles = Cache::read('recent_titles');
        $all_titles = Cache::read('all_titles');
        if(!$recent_titles || !$all_titles) {
            $this->recentTitles();
            $this->allTitles();
            Cache::write('recent_titles',$this->recentTitles);
            Cache::write('all_titles',$this->allTitles);
        } else {
            $this->recentTitles = $recent_titles;
            $this->allTitles = $all_titles;
        }
    }
    
        /**
     * sets $recentTitles to an array of the most recently used Image.titles
     * 
     * Default to returning the most recent 10 but passing param can change this.
     * The array is number indexed and contains titles
     * Recentness is determined by the created date of Image records.
     *     */
    function recentTitles($limit=null) {
        $limit = ($limit==null) ? 10 : $limit;
        
        $q = "SELECT DISTINCT title from images AS Image WHERE title IS NOT NULL AND title != '' ORDER BY modified DESC LIMIT $limit";
        $titles = $this->query($q);

        $this->recentTitles[0] = '';
        foreach($titles as $title){
            $this->recentTitles[$title['Image']['title']] = $title['Image']['title'];
        }
    }

        /**
     * Sets $allTitles to an array of the all Image.titles
     * 
     * @return array An array of all Image.titles
     */
    function allTitles($limit=null) {
        $q = "SELECT DISTINCT title from images AS Image WHERE title IS NOT NULL AND title != '' ORDER BY category, title ASC";
        $titles = $this->query($q);

        $this->allTitles[] = '';
        foreach($titles as $title){
            $this->allTitles[] = $title['Image']['title'];
        }
    }

    /**
     * Provided an image filename, return the EXIF data
     * 
     * Assumes the source image file to be stored in
     * "{$this->actsAs['Upload']['img_file']['dir']}/native/"
     * [FILE] => Array
     *      [FileName] => CRW_7744.jpg
     *      [FileDateTime] => 1301555610
     *      [FileSize] => 37772
     *      [FileType] => 2
     *      [MimeType] => image/jpeg
     *      [SectionsFound] => 
     * [COMPUTED] => Array
     *      [html] => width="680" height="510"
     *      [Height] => 510
     *      [Width] => 680
     *      [IsColor] => 1
     * 
     * @param string $pointer image filename
     * @return array/string the EXIF data or a string error message
     */
    function refreshExifData($pointer=null){
//        debug("{$this->actsAs['Upload']['img_file']['dir']}/native/");die;
        if(!is_string($pointer)){
            return 'Please provide an image file name, not '.(is_null($pointer))?'NULL':$pointer;
        }
        $target = WWW_ROOT.$this->actsAs['Upload']['img_file']['dir'].'/native/'.$pointer;
        $exif = exif_read_data($target, 'FILE', true);
        if($exif){
            unset($exif['EXIF']['MakerNote']);
//            $f->exif = $exif;
        } else {
            $exif = "Image file not found at $target";
        }
        return $exif;
    }
    
     /**
      * Examine files in source and sort by status
      *
      * sort them into Disallowed, Duplicate and New (ready to go) arrays
      */
     function s_d_compare(){
         $this->new = false;
         $this->dup = false;
         $this->disallowed = false;

         foreach($this->sourceFolder as $item) {
             $f = new File($item);
             $f->info();
             $name = $f->name;
             
             if (is_file($item)) {
                 if (!isset($this->Behaviors->Upload->ext['.'.$f->info['extension']])) {
                    $this->disallowed[$name] = $f;
                    $f->reason = $f->info['extension']. ' is not allowed.';

                 } elseif (file_exists($this->destPath.'/'.$name) && is_file($this->destPath.'/'.$name)) {
                    $this->read_exif($f);
                    $this->dup[$name] = $f;
                    $d = new File($this->destPath.'/'.$name);
                    $d->info();
                    $this->read_exif($d);
                    $this->dup[$name]->duplicate = $d;

                 } else {
                    $this->new[$name] = $f;
                    $this->read_exif($f);
                 }
             } else {
                 $this->disallowed[$f->name] = $f;
                 $f->reason = "Disallowed because this is not a file";
             }
         }
     }
     
     function read_exif(&$fileObj = null){
         if($fileObj->info['extension'] != 'png'){
            $exif = exif_read_data($fileObj->path, 'FILE', true);
            unset($exif['EXIF']['MakerNote']);
            $fileObj->exif = $exif;
         } else {
             // png files don't have exif data
             $fileObj->exif = array(
                 'FILE'=>array(
                     'MimeType'=>'image/png',
                     'FileSize'=>''
                 ),
                 'EXIF'=>array(
                     'DateTimeOriginal'=>''
                 ),
                 'COMPUTED'=>array(
                     'Width'=>'',
                     'Height'=>''
                 ));
         }
     }

        /**
         * Load an array of source images
         * Load an array of destination images
         *
         * @return <type>
         */
        function ingest_images() {

            $className = $this->name;
            $folderName = 'img/images';
            $this->sourcePath = $folderName.DS."upload";
            $this->destPath = "$folderName/native";

            $saved = array();
            $failed_save = array();
            $missing_pic = array();

            $this->folder = new Folder();
            $this->sourceFolder = $this->folder->tree(WWW_ROOT.$this->sourcePath, true, 'file');
            $this->destFolder = $this->folder->tree(WWW_ROOT.$this->destPath, true, 'file');

            $this->s_d_compare();
        }

        /**
         * Load an array of source images
         * Load an array of destination images
         *
         * @return <type>
         */
        function new_up($records) {

            $className = $this->name;
            $folderName = $this->__fields[$this->name][$this->fieldname]['dir'];
//            $this->sourcePath = $folderName.DS."upload";
            $this->destPath = "$folderName/native";


            $saved = array();
//            $failed_save = array();
//            $missing_pic = array();
//
//            $this->folder = new Folder();
//            $this->destFolder = $this->folder->tree(WWW_ROOT.$this->destPath, true, 'file');
            foreach($this->destFolder as $index => $path){
                $this->destFolder[$index] = str_replace(WWW_ROOT.$this->destPath, '', $path);
                $dest[str_replace(WWW_ROOT.$this->destPath.'/', '', $path)] = $path;
            }
            $temps = $records;
            foreach($temps as $index => $temp){
                if(isset($dest[$temp['Image']['img_file']])){
                    debug($dest[$temp['Image']['img_file']]);
                    unset($dest[$temp['Image']['img_file']]);
                }
            }
            debug($dest);
            die;

            $this->s_d_compare();
        }

}
?>