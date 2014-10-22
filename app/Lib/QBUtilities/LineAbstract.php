<?php
/**
 * LineAbstract: A class to parse and save to data table the contents of a .iff file
 * 
 * This class provides the common methods and interface signatures for Classes that 
 * recieve and parse data from iff Files. The files are read, line by line and 
 * saved out to data tables line by line. 
 * 
 * The iff File has header rows which have the column names, followed by some number of data rows. 
 * There may be multiple Header/Data row groups in a single file. 
 * The files are tab delimited. 
 * The header rows are itentified by the first character "!" 
 * The first column of each line names the table that will recieve the data. 
 *
 * @author jasont
 */
abstract class LineAbstract {
	
	/**
	 * The line read from the iff file
	 *
	 * @var string
	 */
	protected $line;
	
	/**
	 * The Model class that is overseeing the read/parse/save process
	 * 
	 * This Model does not actually have a table behind it. It serves as a 
	 * wrapper to manage the processer and eventually receives a the target  
	 * Model with attached table in its $db property. So it can, through its 
	 * $db property, facilitate the saving of data to multiple tables.
	 * 
	 * @var object
	 */
	protected $Model;
	
	/**
	 * The model/table that this line belongs to
	 * 
	 * The first column of each line names the model/table
	 * This is the model/table that will be in Model->db
	 *
	 * @var string
	 */
	protected $alias;
	
	/**
	 * The data that was in $line
	 * 
	 * After the line is cleaned up, it's explodes on \t. 
	 * This is true for Headers and Data lines
	 *
	 * @var array
	 */
	protected $data = array();
	
	/**
	 * Model/Table lines to ignore
	 * 
	 * We don't save ALL data. These are tables we don't bother with
	 *
	 * @var array
	 */
	protected $skip = array('HDR', 'BUD', 'INVITEM', 'EMP', 'ENDGRP', 'TRNS', 'SPL', 'TODO', 'VEHICLE', 'SALESREP');
	
	
	/**
	 * Memorize the current line (read from the file) and store the parent Model so we can set properties up there
	 * 
	 * Some version of quickbook started quoting fields. 
	 * We get rid of those double quotes before and after the tab delimiters
	 * 
	 * @param object $Model
	 * @param string $line
	 */
	public function __construct(QbItems $Model, $line){
		$this->line = preg_replace('/\t"|"\t/', "\t", trim($line, " \r\n"));
		$this->Model = $Model;
	}
	
	/**
	 * The operation to perform on a line
	 */
	abstract public function execute();
	
	/**
	 * The process to filter out some data sets
	 * 
	 * Mostly we ignore certain tables, but INVITEM has a strange subset 
	 * of data for Group Items. The subset rows have fewer columns 
	 * than the main data (which we want)
	 * 
	 * @return boolean
	 */
	public function skip() {
		if(in_array($this->alias(), $this->skip)){
			if($this->alias() == 'INVITEM' && count($this->data()) > 15){
				return FALSE;
			}
			return TRUE;
		}
		return FALSE;
	}
	
	/**
	 * Return the Model alias appropriate to this line
	 */
	abstract protected function alias();
	
	/**
	 * Return the array of data extracted from this line
	 * 
	 * Might be a header array or data array
	 * 
	 * @return array
	 */
	protected function data() {
		if(!isset($this->data)){
			$this->parseLine();
		}
		return $this->data;
	}

	/**
	 * Utility to turn lines into arrays and extract the Alias form the result
	 */
	protected function parseLine() {
		$this->data = explode("\t", $this->line);
		$this->alias = array_shift($this->data);
	}
}

?>
