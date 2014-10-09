<?php

App::uses('LineAbstract', 'Lib/QBUtilities');

/**
 * Description of LineHeader
 *
 * @author jasont
 */
class LineHeader extends LineAbstract {
	
	public function __construct($line) {
		parent::__construct($line);
	}
	
	public function execute($header) {
		return $this->data();
	}

	protected function model() {
		if(!isset($this->model)){
			$this->parseLine();
		}
		return str_replace('!', '', $this->model);
	}
}

?>