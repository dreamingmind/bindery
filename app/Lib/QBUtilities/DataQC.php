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
	 * 
	 * @param type $data
	 * @param type $schema
	 * @return array
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
	 * 
	 * @param array $data
	 * @param array $schema
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
	 * Make the current $this->data vals match their destination field types and specs
	 * 
	 * @return array
	 */
//	public function clean_data(){
//		foreach ($this->Model->header as $field => $header) {
//			$schema = $this->Model->_schema[$header];
//			$this->data[$field] = $this->{$schema['type']}($schema, $field);
//		}
//		return $this->data;
//	}
	
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
