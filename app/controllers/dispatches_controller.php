<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
class DispatchesController extends AppController {
	var $name = 'Dispatches';
	var $scaffold;
	var $uses = array('Dispatch', 'DispatchGallery', 'Gallery');
/*	function beforeFilter () {
		parent::beforeFilter();
		$this->menus[] = array(
		'name' => 'main',
		'selected' => 'users'
		);
	}
*/
        
    /**
     * Action:on_the_bench is the main visitor landing page for news feeds
     * 
     * Use a gallery name + bloggish date urls (yyyy/mm)
     *  (eg: dispatch/all/2011/11; dispatch/journals/2011/03)
     * Make it admin aware so update tools are available right on
     *  the normal page but are surpressable/invocable (javascript/div visibility)
     * Display content in reverse chronological, scrolling; but chunked in 
     *  pages that match the thumbnail nav pages that are also present.
     *  A 'more' button at the end of the scrolling list mirrors the 'next'
     *  page link. There is no 'previous' equivalent in the scrolling list.
     *  *** maybe older/newer for the scolling list
     * Individual entries must have anchors so the thumbnail clicks can 
     *  jump to them.
     * The thumbnail nav bar should have next/prev page, next/prev image
     *  (and that should auto-turn pages) and possibly a slideshow that uses
     *  javascript to scroll to each anchor in turn
     * A search box should only search dispatches (present results in 
     *  Action:dispatch_search) and will return gallery-name, text/alt/title
     *  results in 2 different results
     * 
     * @param string $gallery gallery name to fetch or 'all'
     * @param string $year year of the records to fetch
     * @param string $month month of the records to fetch
     * @param string $page page of records to fetch
     */
    function on_the_bench($gallery='all', $year=null, $month=null, $page=null){
        //$gallery='all', $year=date('Y'), $month=date('m'), $page=null
    }

        /**
         * Build the starter arrays of table data for bulk image processing
         *
         * This build only the display data for the tables
         * The tables will also include links to do things
         * Those will be made by HTMLHelper in the view and ajax-infused
         */
        function ingest_images() {
            $this->Dispatch->ingest_images();
//            debug($this->Dispatch->Behaviors->Upload->new); die;
            App::import('Helper','Html');
            $this->html = new HtmlHelper();

            $dis_table = $this->assem_dis_table($this->Dispatch->Behaviors->Upload->disallowed);
            $dis_table = (!$dis_table) ? "" : $dis_table;
            $this->set("dis_table",$dis_table);
            
            $dup_table = $this->assem_dup_table($this->Dispatch->Behaviors->Upload->dup);
            $dup_table = (!$dup_table) ? "" : $dup_table;
            $this->set('dup_table',$dup_table);

            $new_table = $this->assem_new_table($this->Dispatch->Behaviors->Upload->new);
            $new_table = (!$new_table) ? "" : $new_table;
            $this->set('new_table',$new_table);
        }

        /**
         * Make an array to display as a table of new files
         * 
         * The view does further processing to add links using HTMLHelper
         *
         * @param array $new File objects for the new files
         * @return boolean|array The array to display as table or new items
         */
        function assem_new_table($new = false){
            if (!$new) {
                return false;
            }
            $exifAssignments = ""; // this will hold all the json assignments of exif data
            foreach($new as $file){
                $base = $this->js_safe($file->info['basename']);
                //$exifAssignments .= (($exifAssignments==='')?'var exifData = ':',') . '{"' . $base . '":' . json_encode($file->exif) . '}'."\n";
                $exifAssignments[$base] = $file->exif;
                $new_table[] = array(
                    $file->info['basename'] . "<br />" .
                    $this->html->image(' ', array('width'=>'160', 'height'=>'120', 'id' => $base.'image')),
                    
                    "<span id='{$base}indicator' style='display:none;'>" . $this->html->image('indicator.gif') . ' Loading.</span>' .
                    $this->html->link('New record data', array('#'.$file->info['basename']), array(
                        'class'=>'newRecordButton',
                        'name' => $file->info['basename'],
                        'base' => $base,
                    )) . '<br />' . "<div id = '$base' class='newRecordForm'></div>",

                    $this->html->link('Process '.$file->info['basename'],array('action'=>'process', $file->info['basename'])) . "<br />" .
                    $this->html->link('Remove Source '.$file->info['basename'],array('action'=>'remove_image', 'source'.DS.$file->info['basename']))
                    

                );
            }
            //debug($exifAssignments);
            $this->set('exifAssignments', "\nvar exifData = " . json_encode($exifAssignments) . ";");
            return $new_table;
        }

        /**
         * Make an array to display as a table of disallowed files
         *
         * The view does further processing to add links using HTMLHelper
         *
         * @param array $disallowed File objects for the disallowed files
         * @return boolean|array The array to display as table or disallowed items
         */
        function assem_dis_table($disallowed = false){
            if (!$disallowed) {
                return false;
            }
            foreach($disallowed as $file){
                $base = $this->js_safe($file->info['basename']);
                $this->set('file',$file);
            
                $dis_table[] = array(
                    $file->info['basename'],
                    
                    $file->reason,
                    
                    "<span id='{$base}indicator' style='display:none;'>" . $this->html->image('indicator.gif') . ' Loading.</span>' .
                    $this->html->link('Upload new file', array('#'), array(
                        'class'=>'uploadAltButton',
                        'name' => $file->info['basename'],
                        'base' => $base
                    )) . '<br />' .
                    "<div id='" . $base . "' class='uploadForm'></div>",
                            
                    $this->html->link('Remove Source ' . $file->info['basename'], array('action'=>'remove_image', 'source' . DS . $file->info['basename']))
                );
            }
            return $dis_table;
        }
        
        /**
         * Make an array to display as a table of duplicate files
         *
         * @param array $dup File objects for the duplicates
         * @return boolean|array The array to display as table or duplicate items
         */
        function assem_dup_table($dup = false) {
            if(!$dup){
                return false;
            }
            foreach($dup as $file){
                $dup_table[] = array(
                    $file->info['filename'] . "<br />" . $this->html->link('Rename incoming', array('action'=>'rename')),
                    
                    $file->info['extension'],
                    
                    $this->html->link('Show pictures', array('#'), array(
                        'class'=> 'showPicturesButton',
                        'name' => $file->info['basename'],
                        'base' => $this->js_safe($file->info['filename'])
                    ))
                    . '<br />' .
                    "<div id = '" . $file->info['filename'] . "' class='dupPictureDisplay'></div>",
                            
                    'Incoming:<br />Destination:',
                    
                    'Last access: '.date('r',$file->lastChange()).'<br />'.'Last access: '.date('r',$file->duplicate->lastChange()),
                            
                    'Size: '.$file->size().'<br />'.'Size: '.$file->duplicate->size(),
                            
                    $this->html->link('Remove Incoming '.$file->info['filename'],array('action'=>'remove_image', 'incoming'.DS.$file->info['basename']))
                    . '<br />' .
                    $this->html->link('Remove Destination '.$file->info['filename'],array('action'=>'remove_image', 'destination'.DS.$file->info['basename']))
                );
            }
            return $dup_table;
        }
        
        /**
         * Return <img> html via Ajax for display of incoming and destination pictures
         *
         */
        function show_pictures() {
            $this->layout = '';
            $this->set('image', $this->params['pass'][0]);
            $this->render('show_pictures','ajax');
        }

        /**
         * Allow selection of or upload an alternate image
         *
         * For disallowed images this will provide a small form to
         * allow selection of a valid image or if one has just
         * been selected, upload it for further processing
         */
        function upload_alt() {
            if (isset($this->data)){
                if(!$this->data['Dispatch']['img_file']['error']){
                    $file = new File($this->data['Dispatch']['img_file']['tmp_name']);
                    $file->copy(WWW_ROOT.'img'.DS.'uploads'.DS.'dispatches'.DS.$this->data['Dispatch']['img_file']['name'], true);
                    $file->delete();
                    $this->Session->setFlash("Alternate file uploaded ({$this->data['Dispatch']['img_file']['name']}:{$this->data['Dispatch']['img_file']['tmp_name']})");
                    $this->redirect(array('action'=>'ingest_images/#'));
                } else {
                    $this->Session->setFlash('There was an error uploading the file ' . $this->data['Dispatch']['img_file']['name']);
                    $this->redirect(array('action'=>'ingest_images/#'));
                }
            }
            $this->layout = '';
            $this->render('upload_alt', 'ajax');
        }

        /**
         * Remove an image then return to the bulk processing page
         *
         * ******* TO DO **********
         * native folder is actually the tip of an iceburg of folders
         * change to an array of folders and take care of
         * ALL the size versions. The folders can be found in
         * $this->Dispatch->Behaviors->Upload->thumbs
         * Also, there is probably a db record to consider
         */
        function remove_image() {
//            debug($this->params);
            if($this->params['pass'][0] == 'destination'){
                $path = WWW_ROOT.'img'.DS.'dispatches'.DS.'native'.DS;
            } else {
                $path = WWW_ROOT.'img'.DS.'uploads'.DS.'dispatches'.DS;
            }
            $file = new File($path.$this->params['pass'][1]);
            if($file->delete()){
                $this->Session->setFlash($path.$this->params['pass'][1] . " has been deleted.");
            } else {
                $this->Session->setFlash("The delete failed. File still exists");
            }
            $this->redirect(array('action'=>'ingest_images/#'));
        }

        function alert($name = null, $message = null) {
            return "function $name() {\nalert('$message');\n}\n";
        }

        /**
         * Return of input form fragment via Ajax to allow data entry for a new image or save the data
         * 
         * If data is empty, return a form for the user to enter data
         * Otherwise:
         * Restructure the data so it can be saved.
         * Multiple record requests come in as
         *   [field_name1]
         *       [record1 data]
         *       [record2 data]
         *   [field_name2]
         *       [record1 data]
         *       [record2 data]
         * The loop turns this into a normal Cake data array
         */
        function new_image_record(){
            if(!isset($this->data)){
                $this->layout = '';
                $this->set('path', WWW_ROOT.'img'.DS.'uploads'.DS.'dispatches'.DS);
                $this->data = $this->Dispatch->find('all', array('conditions'=>array('Dispatch.img_file'=> $this->params['pass'][0])));
                $this->render('new_image_record', 'ajax');
            } else {
                $fields = array_keys($this->data);
                $img_file = array_keys($this->data['img_file']);
                $i =0;
                for($i; $i < count($this->data['news_text']); $i++) {
                    foreach($fields as $field){
                        if ($field === 'img_file'){
                            $file = new File($this->data[$field]['tmp_name'][$i]);
                            if ($file->copy("img/dispatches/native".DS.$file->name, true)) {
                                $this->data[$field]['error'][$i]=0;
                            } else {
                                $this->data[$field]['error'][$i] = 1;
                            }
                            foreach($img_file as $sub_key){
                                $data['Image'][$i]['img_file'][$sub_key] = $this->data[$field][$sub_key][$i];
                            }
                        } else {
                        $data['Dispatch'][$i][$field] = $this->data[$field][$i];
                        }
                    }
                }
                //debug($data);die;
//                foreach($data as $dispatch){
//                    debug($dispatch); die;
//                    $this->Dispatch->create();
                    $this->Dispatch->saveAll($data['Dispatch']); //undefined variable 'data'
                    //$this->Session->setFlash('Save failed');
                    //debug($this->Dispatch->validationErrors);
                //}
//                $what = $this->Dispatch->save($data);
//                if (!$what){
//                    $this->Session->setFlash('Save failed');
//                    debug($this->Dispatch->validationErrors);
//                }
//                debug($data);
                $this->redirect(array('action'=>'ingest_images/#'));
            }
        }

        function js_safe($string){
            //return str_replace(array('.', '#', '*'), '_', $string);
            return Inflector::slug($string);
        }
}
?>