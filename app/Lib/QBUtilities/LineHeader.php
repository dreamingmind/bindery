<?php

App::uses('LineAbstract', 'Lib/QBUtilities');

/**
 * Description of LineHeader
 *
 * @author jasont
 */
class LineHeader extends LineAbstract {
		
	public function execute() {
		$this->loadModel($this->alias());
		$this->Model->db->deleteAll(array(1=>1));
		$this->Model->header = $this->data();
	}
	
	protected function alias() {
		if(!isset($this->alias)){
			$this->parseLine();
		}
		return str_replace('!', '', $this->alias);
	}
	
	protected function loadModel($alias) {
		$this->Model->db = ClassRegistry::init($alias);
		$this->Model->db->useTable = $alias;
		$this->Model->db->table = $alias;
		$this->Model->db->tableToModel = array($alias => $alias);
		$this->Model->db->useDbConfig = 'qb';
	}
}

?>