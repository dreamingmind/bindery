<?php
/**
 * StorageObject is the base class for a family of data storage objects differentiated by the kind of data being stored
 * 
 * It's intended that these store pretty shallow data packages. If your data is especially deep or 
 * complex, you should consider decomposing it into smaller StorageObjects and write a class to contain 
 * and manage those. That said, the ArrayStorageObject has good depth support.
 * 
 * The goal is to provide standard read/write of heirarchical data structures regardless of type. 
 * An attempt to determine the type of data being provided will made but proper handling of some types 
 * will the $provided_data_type arguement during construction.
 *
 * @author dondrake
 */
class StorageObject {
	
	public $data;
	
	/**
	 * csv and tab concretes will need an addHeader() method so the things can be keyed.
	 * That method can have a useFirstRowAsHeaderValues option. And this may all happen in the constructor *****
	 * @var type 
	 */
	protected $known_data_types;
	
	protected $know_string_data_types = array(
		'string', 'json'
//		'string', 'xml', 'json', 'csv', 'tab_delimited'
	);
	
	protected $known_non_string_data_types = array('array', 'object');

	/**
	 * Do baseline construction processes, possibly finishing the process
	 * 
	 * Non-string types will be fully constructed. 
	 * String types will depend on their concrete sub-classes to finish validation and construction
	 * 
	 * @param mixed $data The data to store
	 * @param string|null $provided_data_type What the caller thinks this data is
	 * @return boolean|StorageObject
	 */
	public function __construct($data = NULL, $provided_data_type = NULL) {
		$this->known_data_types = array_merge($this->know_string_data_types, $this->known_non_string_data_types);
		
		if (is_null($data)) {
			return $this;
		} else {
			try {
				$data_type = gettype($data);
				$this->validateDataStorageRequest($data_type, $provided_data_type);
				
				// Simple non-string types finsh up and return themselves
				if (in_array($data_type, $this->known_non_string_data_types)) {
					$this->data = $data;
					return $this;
					
				// String types will need additional parsing by the concrete sub-class
				} else {
					return TRUE;
				}

			} catch (UnexpectedValueException $exc) {
				echo "{$exc->getMessage()}<pre>{$exc->getTraceAsString()}</pre>";
			}
		
		}
	}
	
	/**
	 * Do basic checks before allowing storage of data
	 * 
	 * @param string $data_type
	 * @param string|null $expected_data_type
	 * @throws UnexpectedValueException
	 */
	public function validateDataStorageRequest($data_type, $expected_data_type){
		try {
			$this->isAnAllowedDataTypeArguement($expected_data_type);
			$this->validateDataType($data_type, $expected_data_type);
			return TRUE;
			
		} catch (UnexpectedValueException $exc) {
			echo "{$exc->getMessage()}<pre>{$exc->getTraceAsString()}</pre>";
		}
	}
	
	/**
	 * Return some or all of the stored data using Hash::extract() dot notation
	 * 
	 * NULL will return full data
	 * 
	 * @param string $path 'path.to.data.to.read'
	 * @return array|string
	 */
	public function read($path = NULL){
		if (is_null($path)) {
			return $this->data;
		} else {
			$result = Hash::extract($this->data, $path);
			if (count($result) == 1) {
				return $result[0];
			} elseif (empty($result)) {
				return NULL;
			} else {
				return $result;
			}
		}
	}
	
	/**
	 * Overwrite some part of the stored data using Hash::insert() dot notation
	 * 
	 * @param string $path 'path.to.data.to.write'
	 * @param mixed $value
	 * @return boolean
	 */
	public function write($path, $value){
		return $this->data = Hash::insert($this->data, $path, $value);
	}
	
	/**
	 * Assemble a string representation or return the array of know data types
	 * 
	 * This was added to support Exception messaging. 
	 * But it could be brought online for more use later.
	 * The string supports 'list' (comma space separated)
	 * or 'quoted' (single quoted and comma space separated)
	 * 
	 * @param string $return_type 'list', 'quoted'
	 * @return string|array
	 */
	protected function knownDataTypes($return_type = NULL) {
		switch ($return_type) {
			case 'list':
				$glue = ', ';
				break;
			case 'quoted':
				$glue = "', '";
				$list = implode($glue, $this->known_data_types);
				return "'$list'";
			default:
				$glue = FALSE;
		}
		if ($glue) {
			return implode($glue, $this->known_data_types);
		} else {
			return $this->known_data_types;
		}
	}
	
	/**
	 * Is this string-label one of the know data types?
	 * 
	 * @param type $data_type_to_check
	 * @return type
	 */
	protected function isAKnowDataType($data_type_to_check) {
		return in_array($data_type_to_check, $this->known_data_types);
	}
	
	/**
	 * Is this string-label one of the known data types or NULL?
	 * 
	 * @param type $arguement_to_check
	 * @return type
	 */
	protected function isAnAllowedDataTypeArguement($arguement_to_check) {
		if (is_null($arguement_to_check) || $this->isAKnowDataType($arguement_to_check)) {
			return TRUE;
		}
		throw new UnexpectedValueException(sprintf(
			"<pre>\nThe specified data type is not allowed. \nSpecified:['%s'] \nAllowed: ['', %s]</pre>\n", 
			$provided_data_type, $this->knownDataTypes('quoted')));
	}
	
	/**
	 * Do course-grain verification of the provided data type, considering user stated type
	 * 
	 * @param string $data_type The type data provided
	 * @param string $expected_data_type NULL or the expected type
	 * @return boolean Only TRUE returns. Otherwise throws exception
	 * @throws UnexpectedValueException
	 */
	protected function validateDataType($data_type, $expected_data_type) {
		
		// first prevent storing any completely unknow data type
		if (!$this->isAKnowDataType($data_type)) {
			throw new UnexpectedValueException(sprintf(
				"<pre>\nThe type data provided is not allowed. \nProvided:['%s'] \nAllowed: [%s]</pre>\n", 
				$data_type, $this->knownDataTypes('quoted')));
		}
		
		// if there was no specified type, then all is good
		if (is_null($expected_data_type)) {
			return TRUE;
		}
		
		// if there was a specified type, make sure it matches the data
		switch ($data_type) {
			case 'array':
			case 'object':
				if ($data_type == $expected_data_type) {
					return TRUE;
				}
				
			// there are many string types, so this is pretty broad-brush approval
			default:
				if (in_array($expected_data_type, $this->know_string_data_types)) {
					return TRUE;
				}				
		}
		throw new UnexpectedValueException(sprintf(
			"<pre>\nThe data type does not match the expected type. \nProvided:['%s'] \nExpected: [%s]</pre>\n", 
			$data_type, $expected_data_type));
	}
}
