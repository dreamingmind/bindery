<?php

App::uses('LineAbstract', 'Lib/QBUtilities');

/**
 * Description of LineData
 *
 * @author jasont
 */
class LineData extends LineAbstract {
	
	public function execute() {
		$saveData = array_combine($this->Model->header, $this->data());
		$this->Model->db->create();
		$this->Model->db->save($saveData);
	}
	
	protected function alias() {
		if(!isset($this->alias)){
			$this->parseLine();
		}
		return $this->alias;
	}
	
}

?>
