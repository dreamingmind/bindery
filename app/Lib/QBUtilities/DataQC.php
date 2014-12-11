<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataQC
 *
 * @author dondrake
 */
class DataQC {
	
	/**
	 * The schema array passed from the Model, one node per field
	 *
	 * @var array 
	 */
	private $schemas;
	
	/**
	 * Use a fieldname as key and get the type for that field
	 *
	 * @var array 
	 */
	private $type;
	
	/**
	 * The cleaned up data to return
	 *
	 * @var array 
	 */
	private $data;
	
	/**
	 * The source data, uncleaned
	 *
	 * @var array 
	 */
	private $source;


	/**
	 * Sculpt data to match destination table fields
	 * 
	 * @param array $data Assoc array of data to clean
	 * @return array The clean and ready to save data
	 */
	public function clean($source){
		
		$this->data = $this->source = $source;
		$this->source = $source;
		
		foreach ($this->schemas as $field => $schema) {
			if (array_key_exists($field, $this->source)) {
				$this->data[$field] = $this->{$this->type[$field]}($schema, $this->source[$field]);
			}			
		}
		return $this->data;
	}
	
	/**
	 * Construct with the Models schema info
	 * 
	 * Also make a quick access 'type' lookup
	 * 
	 * @param array $schema Models field schema information
	 * @return void
	 */
	public function __construct($schemas) {	
		$this->schemas = $schemas;
		foreach ($this->schemas as $field => $schema) {
			$this->type[$field] = $schema['type'];
		}
		return $this;
	}

	/**
	 * Insure proper float values for the db
	 * 
	 * sample schema array
	 * 	'type' => 'float',
	 * 	'null' => true,
	 * 	'default' => null,
	 * 	'length' => null
	 * 
	 * @todo Expand to deal with defaults, NULLS etc.
	 * 
	 * @param array $schema Schema info for this field
	 * @param int $field Index of the element of $this->data[] under consideration
	 * @return float The cleaned up data
	 */
	protected function float($schema, $value) {
		return floatval(str_replace(",","",$value));
	}
	
	/**
	 * Insure proper string values for the db
	 * 
	 * sample schema array
	 * 	'type' => 'string',
	 * 	'null' => true,
	 * 	'default' => null,
	 * 	'length' => (int) 1024,
	 * 	'collate' => 'latin1_swedish_ci',
	 * 	'charset' => 'latin1'
	 * 
	 * @todo Expand to deal with defaults, NULLS etc.
	 * 
	 * @param array $schema Schema info for this field
	 * @param int $field Index of the element of $this->data[] under consideration
	 * @return string The cleaned up data
	 */
	protected function string($schema, $value) {
		return substr($value, 0, $schema['length']);		
	}
	
	/**
	 * insure proper integer values for the db
	 * 
	 * sample schema array
	 * 	'type' => 'integer',
	 * 	'null' => true,
	 * 	'default' => null,
	 * 	'length' => (int) 11
	 * 
	 * @todo Expand to deal with defaults, NULLS etc.
	 * 
	 * @param array $schema Schema info for this field
	 * @param int $field Index of the element of $this->data[] under consideration
	 * @return int The cleaned up data
	 */
	protected function integer($schema, $value) {
		return intval($value);
	}

	/**
	 * insure proper integer values for the db
	 * 
	 * sample schema array
	 * 	'type' => 'text',
	 * 	'null' => true,
	 * 	'default' => null,
	 * 	'length' => null,
	 * 	'collate' => 'latin1_swedish_ci',
	 * 	'charset' => 'latin1'
	 * 
	 * @todo Expand to deal with defaults, NULLS etc.
	 * 
	 * @param array $schema Schema info for this field
	 * @param int $field Index of the element of $this->data[] under consideration
	 * @return int The cleaned up data
	 */
	protected function text($schema, $value) {
		return $value;
	}

}

?>
