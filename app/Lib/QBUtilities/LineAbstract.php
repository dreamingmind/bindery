<?php

/**
 *
 * @author jasont
 */
abstract class LineAbstract {
	
	protected $line;
	
	protected $model;
	
	protected $data = array();
	
	protected $skip = array('HDR', 'BUD', 'INVITEM', 'EMP', 'ENDGRP', 'TRNS', 'SPL', 'TODO', 'VEHICLE', 'SALESREP');
	
	public function __construct($line){
		$this->line = $line;
	}
	
	abstract public function execute($header);
	
	protected function skip() {
		if(in_array($this->model(), $this->skip)){
			if($this-model() == 'INVITEM' && count($this->data()) > 15){
				return FALSE;
			}
			return TRUE;
		}
		return FALSE;
	}
	
	abstract protected function model();
	
	protected function data() {
		if(!isset($this->data)){
			$this->parseLine();
		}
		return $this->data;
	}

	protected function parseLine() {
		$this->data = explode("\t", $this->line);
		$this->model = array_shift($this->data);
	}
}

?>
