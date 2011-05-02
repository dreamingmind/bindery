<?php
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

                                $saveAs = $options['dir'] . DS . 'native' . DS . $data[$model->alias][$fieldName]['name'];
			}

                        if (!isset($data[$model->alias]['batch'])) {
                            // batch processing isn't uploaded, we're looping on a folder
                            // Attempt to move uploaded file
                            $copyResults = $this->_copyFileFromTemp($data[$model->alias][$fieldName]['tmp_name'], $saveAs);
                            if ($copyResults !== true) {
                                    $return[$fieldName] = array('return' => false, 'reason' => 'validation', 'error' => $copyResults);
                                    continue;
                            }

			// If the file is an image, try to make the thumbnails
			if (!empty($options['thumbsizes']) && !empty($options['allowedExt']) && in_array($data[$model->alias][$fieldName]['type'], $this->_imageTypes)) {
				$this->_createThumbnails($model, $fieldName, $saveAs, $ext, $options);
			}

			// Update model data
			$data[$model->alias][$options['fields']['dir']] = $options['dir'];
			$data[$model->alias][$options['fields']['mimetype']] = $data[$model->alias][$fieldName]['type'];
			$data[$model->alias][$options['fields']['filesize']] = $data[$model->alias][$fieldName]['size'];
			$data[$model->alias][$fieldName] = $data[$model->alias][$fieldName]['name'];

			$return[$fieldName] = array('return' => true);
			continue;
		}
		return $return;
	}
?>
