<?php
App::import('Behavior', array('MeioUpload'));
App::import('Core', array('File', 'Folder'));

//debug(array_flip(get_included_files()));
//http://amparchive.dreamingmind.com/help/index.php?title=DMCakeSite:Upload_Extension

 class UploadBehavior extends MeioUploadBehavior {

     var $file = null;
     
     var $sourceFolder = null;
     
     var $destFolder = null;

     public function setup(&$model, $settings = array()) {
         parent::setup(&$model, $settings);
         foreach ($settings as $key=>$val){
            $this->fieldname = $key;
            continue;
         }
         $this->ext = array_flip($settings[$this->fieldname]['allowed_ext']);
         $this->thumbs = array_keys($settings[$this->fieldname]['thumbsizes']);
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
                 if (!isset($this->ext['.'.$f->info['extension']])) {
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
        $exif = exif_read_data($fileObj->path, 'FILE', true);
        unset($exif['EXIF']['MakerNote']);
        $fileObj->exif = $exif;
     }

        /**
         * Load an array of source images
         * Load an array of destination images
         *
         * @return <type>
         */
        function ingest_images(&$model) {

            $className = $model->name;
//            debug($className);
//            debug($this->__fields[$model->name][$this->fieldname]['dir']);
//            debug($this);die;
            $folderName = $this->__fields[$model->name][$this->fieldname]['dir'];
            $this->sourcePath = $folderName.DS."upload";
            $this->destPath = "$folderName/native";
//            debug($this->sourcePath);
//            debug($this->destPath); //die;
            //$folderName = Inflector::tableize($className);
//            $this->sourcePath = "img".DS."uploads".DS.$folderName;
//            $this->destPath = "img/$folderName/native";


            $saved = array();
            $failed_save = array();
            $missing_pic = array();

            $this->folder = new Folder();
            $this->sourceFolder = $this->folder->tree(WWW_ROOT.$this->sourcePath, true, 'file');
            $this->destFolder = $this->folder->tree(WWW_ROOT.$this->destPath, true, 'file');

            $this->s_d_compare();
        }


/**
 * Uploads the files
 *
 * @param object $model
 * @return array
 * @access protected
 */
	function _uploadFile(&$model) {
		$data =& $model->data;
		$return = array();
		foreach ($this->__fields[$model->alias] as $fieldName => $options) {
			if (!empty($data[$model->alias][$fieldName]['remove'])) {
				if (!empty($data[$model->alias][$model->primaryKey])) {
					$this->_setFileToRemove($model, $fieldName);
				}
				$this->_cleanFields($model, $fieldName);
				$return[$fieldName] = array('return' => true);
				continue;
			}
			// If no file was selected we do not need to proceed
			if (empty($data[$model->alias][$fieldName]['name'])) {
				unset($data[$model->alias][$fieldName]);
				$return[$fieldName] = array('return' => true);
				continue;
			}
			list(, $ext) = $this->_splitFilenameAndExt($data[$model->alias][$fieldName]['name']);

			// Check whether or not the behavior is in useTable mode
			if ($options['useTable'] === false) {
				$pos = strrpos($data[$model->alias][$fieldName]['type'], '/');
				$sub = substr($data[$model->alias][$fieldName]['type'], $pos + 1);
				$this->_fixName($model, $fieldName, false);
				$saveAs = $options['dir'] . DS . $sub;
			} else {
				// If no file has been upload, then unset the field to avoid overwriting existant file
				if (!isset($data[$model->alias][$fieldName]) || !is_array($data[$model->alias][$fieldName]) || empty($data[$model->alias][$fieldName]['name'])) {
					if (!empty($data[$model->alias][$model->primaryKey])) {
						unset($data[$model->alias][$fieldName]);
					} else {
						$data[$model->alias][$fieldName] = null;
					}
				}
//                         debug($options); debug($this); die;
                                $saveAs = $options['dir'] . DS . 'native' . DS . $data[$model->alias][$fieldName]['name'];
			}
                  //debug($data);debug($data[$model->alias]['batch']); die;
                      
                        if (!isset($data[$model->alias]['batch'])) {
                            // batch processing isn't uploaded, we're looping on a folder
                            // Attempt to move uploaded file
                            $copyResults = $this->_copyFileFromTemp($data[$model->alias][$fieldName]['tmp_name'], $saveAs);
                            if ($copyResults !== true) {
                                    $return[$fieldName] = array('return' => false, 'reason' => 'validation', 'error' => $copyResults);
                                    continue;
                            }
                        }

			// If the file is an image, try to make the thumbnails
			if (!empty($options['thumbsizes']) && !empty($options['allowedExt']) && in_array($data[$model->alias][$fieldName]['type'], $this->_imageTypes)) {
                            copy($options['dir'].DS.'upload'.DS.$data[$model->alias][$fieldName]['name'], $saveAs);
                            $this->_createThumbnails($model, $fieldName, $saveAs, $ext, $options);
			}

			// Update model data
//			$data[$model->alias][$options['fields']['dir']] = $options['dir'];
//			$data[$model->alias][$options['fields']['mimetype']] = $data[$model->alias][$fieldName]['type'];
//			$data[$model->alias][$options['fields']['filesize']] = $data[$model->alias][$fieldName]['size'];
//			$data[$model->alias][$fieldName] = $data[$model->alias][$fieldName]['name'];

			$return[$fieldName] = array('return' => true);
			continue;
		}
		return $return;
	}

/**
 * Function to create Thumbnail images
 *
 * @param object $model
 * @param string $source Source file name (without path)
 * @param string $target Target file name (without path)
 * @param string $fieldName Path to source and destination (no trailing DS)
 * @param array $params
 * @return void
 * @access protected
 */
	function _createThumbnail(&$model, $source, $target, $fieldName, $params = array()) {
		$params = array_merge(
			array(
				'thumbnailQuality' => $this->__fields[$model->alias][$fieldName]['thumbnailQuality'],
				'zoomCrop' => $this->__fields[$model->alias][$fieldName]['zoomCrop']
			),
			$params);

		// Import phpThumb class
		App::import('Vendor', 'phpthumb', array('file' => 'phpThumb' . DS . 'phpthumb.class.php'));

		// Configuring thumbnail settings
		$phpThumb = new phpthumb;
		$phpThumb->setSourceFilename($source);

		$w = isset($params['width']);
		$h = isset($params['height']);
		if ($w && $h) {
			$phpThumb->w = $params['width'];
			$phpThumb->h = $params['height'];
		} elseif ($w && !$h) {
			$phpThumb->w = $params['width'];
		} elseif ($h && !$w) {
			$phpThumb->h = $params['height'];
		} else {
			trigger_error(__d('meio_upload', 'Width and Height of thumbs not specified.', true), E_USER_WARNING);
			return;
		}

		$phpThumb->setParameter('zc', $params['zoomCrop']);
		$phpThumb->q = $params['thumbnailQuality'];
                // ++++++++++++ my addition to pass in more parameters
                // this allows the additon of other phpthumb settings
                // however, only the set before fltr work in a this environment
                if (isset($params['opt'])) {
                    foreach($params['opt'] as $key => $val) {
                        $phpThumb->$key = $val;
                    }
                }
                // ++++++++++++++++ end of my addition

		list(, $phpThumb->config_output_format) = explode('.', $source, 2);
		$phpThumb->config_prefer_imagemagick = $this->__fields[$model->alias][$fieldName]['useImageMagick'];
		$phpThumb->config_imagemagick_path = $this->__fields[$model->alias][$fieldName]['imageMagickPath'];

		// Setting whether to die upon error
		$phpThumb->config_error_die_on_error = true;
		// Creating thumbnail
		if ($phpThumb->GenerateThumbnail()) {
			if (!$phpThumb->RenderToFile($target)) {
				trigger_error(sprintf(__d('meio_upload', 'Could not render image to: %s', true), $target), E_USER_WARNING);
			}
//                debug($phpThumb->getimagesizeinfo);die;
		}
	}


/**
 * Creates thumbnail folders if they do not already exist
 *
 * @param string $dir Path to uploads
 * @param array $thumbsizes List of names of thumbnail type
 * @return void
 * @access protected
 */
	function _createFolders($dir, $thumbsizes) {
		if ($dir[0] !== '/') {
			$dir = WWW_ROOT . $dir;
		}
		$folder = new Folder();

		if (!$folder->cd($dir)) {
			$folder->create($dir);
		}
                if (!$folder->cd($dir . DS . 'native')) {
                    $folder->create($dir .DS . 'native');
                }
		if (!$folder->cd($dir. DS . 'thumb')) {
			$folder->create($dir . DS . 'thumb');
		}
		foreach ($thumbsizes as $thumbName) {
			if (!$folder->cd($dir . DS .'thumb' . DS . $thumbName)) {
				$folder->create($dir . DS . 'thumb' . DS . $thumbName);
			}
		}
	}

     /**
 * Copies file from temporary directory to final destination
 *
 * @param string $tmpName full path to temporary file
 * @param string $saveAs full path to move the file to
 * @return mixed true is successful, error message if not
 * @access protected
 */
	function _copyFileFromTemp($tmpName, $saveAs) {
		if (!is_uploaded_file($tmpName)) {
			return false;
		}
		if (!move_uploaded_file($tmpName, $saveAs)) {
			return __d('meio_upload', 'Problems in the copy of the file.', true);
		}
		return true;
	}
        
        /**
         * Change the target directory for thumbnails
         * I have both Exhibit->Image and Dispatch->Image,
         * and I want the pictures for each to store in different directories
         * but Image has this behavior and can only have one target
         * The reaches in and changes the protected property
         * 
         * example: setImageDirectory('Image', 'img_file', 'img/dispatches');
         *
         * @param type $model The name of the model that needs this configuration tweak
         * @param type $field The file name field for this model
         * @param type $directory The desired storarg directory
         */
        function setImageDirectory($model, $field, $directory) {
//        debug($this->Behaviors->Upload->__fields[$this->name][$this->Behaviors->Upload->fieldname]['dir']);
        $this->__fields[$model][$field]['dir'] = $directory;
//        debug($this);
    }

}
?>
