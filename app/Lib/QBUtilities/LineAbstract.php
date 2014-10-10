<?php

/**
 *
 * @author jasont
 */
abstract class LineAbstract {
	
	protected $line;
	
	protected $Model;
	
	protected $alias;
	
	protected $data = array();
	
	protected $db;
	
	protected $skip = array('HDR', 'BUD', 'INVITEM', 'EMP', 'ENDGRP', 'TRNS', 'SPL', 'TODO', 'VEHICLE', 'SALESREP');
	
	public function __construct($Model, $line){
		$this->line = trim($line, " \r\n");
		$this->Model = $Model;
	}
	
	abstract public function execute();
	
	public function skip() {
		if(in_array($this->alias(), $this->skip)){
			if($this->alias() == 'INVITEM' && count($this->data()) > 15){
				return FALSE;
			}
			return TRUE;
		}
		return FALSE;
	}
	
	abstract protected function alias();
	
	protected function data() {
		if(!isset($this->data)){
			$this->parseLine();
		}
		return $this->data;
	}

	protected function parseLine() {
		$this->data = explode("\t", $this->line);
		$this->alias = array_shift($this->data);
	}
}

?>
