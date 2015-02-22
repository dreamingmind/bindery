<?php
App::uses('StorageObject', 'Model/StorageObjects');

/**
 * ArrayStorageObject wraps an array in an object to standardize access to it
 * 
 * This is one of the standardized data storage objects.
 * See StorageObject for more information
 *
 * @author dondrake
 */
class ArrayStorageObject extends StorageObject{
	
	public function __construct($data = NULL, $provided_data_type = NULL) {
		return parent::__construct($data, $provided_data_type);
	}
	
}
