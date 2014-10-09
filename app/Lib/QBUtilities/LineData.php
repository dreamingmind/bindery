<?php

App::uses('LineAbstract', 'Lib/QBUtilities');

/**
 * Description of LineData
 *
 * @author jasont
 */
class LineData extends LineAbstract {
	
	public function __construct($line) {
		parent::__construct($line);
	}
	
	public function execute($header) {
		echo '<p>DATA:' . $this->line . '</p>';
		// do some stuff to save the data
		return $header;
	}
	
	protected function model() {
		if(!isset($this->model)){
			$this->parseLine();
		}
		return $this->model;
	}
	
}

?>
