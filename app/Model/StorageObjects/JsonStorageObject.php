<?php
App::uses('ObjectStorageObject', 'Model/StorageObjects');

/**
 * JsonStorageObject provides dot notation read/write of stored object properties
 * 
 * See ObjectStorageObject for full documentation
 *
 * @author dondrake
 */
class JsonStorageObject extends ObjectStorageObject{
	
	public function __construct($data, $provided_data_type = NULL) {
		parent::__construct($data, 'json');
		try {
			$this->data = json_decode($data);
		} catch (Exception $ex) {
			echo "<pre>Your data could not be parsed as JSON\n\n{$ex->getTraceAsString()}</pre>)";
		}
	}
	
}
