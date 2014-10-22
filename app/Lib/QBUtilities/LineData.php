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
	 * calculated and created earlier when the Header line was detected. 
	 * The model was instantiated and associated properties were prepared then too.
	 */
	public function execute() {
		$data = array_combine($this->Model->headers, $this->data());
		$cleanData = $this->Model->dataQC->clean($data);
		$this->Model->db->create();
		$this->Model->db->save($cleanData);
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
	
}

?>
