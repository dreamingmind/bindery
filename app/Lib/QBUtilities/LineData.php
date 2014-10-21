<?php

App::uses('LineAbstract', 'Lib/QBUtilities');

/**
 * LineData: Concrete Class to do tasks specific to data lines from an iff File
 *
 * @author jasont
 */
class LineData extends LineAbstract {
	
	/**
	 * Pair the line data with its field names and save the record in its table
	 * 
	 * The correct header (fieldname array) and destination model/table was 
	 * calculated and created earlier when the Header line was detected
	 */
	public function execute() {
//		if ($this->Model->alias != 'QbItems') {
//			foreach ($this->Model->header as $index => $header) {
//				debug($this->Model->_schema[$header]);
//				debug($this->data[$index]);
////				debug("{$this->Model->alias} :: {$header}");
//			}
//				debug($this->Model->data);
//			die;
//		}		
		debug($this->data());
		$saveData = array_combine($this->Model->header, $this->clean_data());
		debug($this->data);
		$this->Model->db->create();
		$this->Model->db->save($saveData);
	}
	
	/**
	 * Return the Model/Table Alias from a data line
	 * 
	 * @return string
	 */
	protected function alias() {
		if(!isset($this->alias)){
			$this->parseLine();
		}
		return $this->alias;
	}
	
	/**
	 * Make the current $this->data vals match their destination field types and specs
	 * 
	 * @return array
	 */
	protected function clean_data(){
		foreach ($this->Model->header as $index => $header) {
			$schema = $this->Model->_schema[$header];
			$this->data[$index] = $this->{$schema['type']}($schema, $index);
		}
		return $this->data;
	}
	
	/**
	 * Insure proper float values for the db
	 * 
	 * @todo Expand to deal with defaults, NULLS etc.
	 * 
	 * @param array $schema Schema info for this field
	 * @param int $index Index of the element of $this->data[] under consideration
	 * @return float The cleaned up data
	 */
	protected function float($schema, $index) {
		return floatval(str_replace(",","",$this->data[$index]));
//	array(
//		'type' => 'float',
//		'null' => true,
//		'default' => null,
//		'length' => null
//	),
	}
	
	/**
	 * Insure proper string values for the db
	 * 
	 * @todo Expand to deal with defaults, NULLS etc.
	 * 
	 * @param array $schema Schema info for this field
	 * @param int $index Index of the element of $this->data[] under consideration
	 * @return string The cleaned up data
	 */
	protected function string($schema, $index) {
		return substr($this->data[$index], 0, $schema['length']);
//	array(
//		'type' => 'string',
//		'null' => true,
//		'default' => null,
//		'length' => (int) 1024,
//		'collate' => 'latin1_swedish_ci',
//		'charset' => 'latin1'
//	)
		
	}
	
	/**
	 * insure proper integer values for the db
	 * 
	 * @todo Expand to deal with defaults, NULLS etc.
	 * 
	 * @param array $schema Schema info for this field
	 * @param int $index Index of the element of $this->data[] under consideration
	 * @return int The cleaned up data
	 */
	protected function integer($schema, $index) {
		return intval($this->data[$index]);
//	array(
//		'type' => 'integer',
//		'null' => true,
//		'default' => null,
//		'length' => (int) 11
//	)
		
	}
}

?>
