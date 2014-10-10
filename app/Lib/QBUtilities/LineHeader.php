<?php

App::uses('LineAbstract', 'Lib/QBUtilities');

/**
 * LineHeader: Concrete Class to do tasks specific to header lines from an iff File
 *
 * @author jasont
 */
class LineHeader extends LineAbstract {
		
	/**
	 * Fire everything up for a new batch of data
	 * 
	 * The header line defines all the fieldnames for a record (->Model->header). 
	 * Since it signals the shift from one type of data to another, this is the 
	 * point where we instantiate the actual Model that will save the data. 
	 * We also clear out all the old data. This is over-write, not synch
	 */
	public function execute() {
		$this->loadModel($this->alias());
		$this->Model->db->deleteAll(array(1=>1));
		$this->Model->header = $this->data();
	}
	
	/**
	 * Return the Model/Table alias recorded in this line
	 * 
	 * @return string
	 */
	protected function alias() {
		if(!isset($this->alias)){
			$this->parseLine();
		}
		return str_replace('!', '', $this->alias);
	}
	
	/**
	 * Instantiate and configure the model for this data set
	 * 
	 * All the quickbooks data tables are kept isolated from the 
	 * main application data. So we tweak up Model config to get to them.
	 * 
	 * @param string $alias Name of the Model/Table
	 */
	protected function loadModel($alias) {
		$this->Model->db = ClassRegistry::init($alias);
		$this->Model->db->useTable = $alias;
		$this->Model->db->table = $alias;
		$this->Model->db->tableToModel = array($alias => $alias);
		$this->Model->db->useDbConfig = 'qb';
	}
}

?>