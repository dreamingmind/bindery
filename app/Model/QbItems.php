<?php

App::uses('AppModel', 'Model');
App::uses('Hash', 'Utilities');
App::uses('LineTypeFactory', 'Lib/QBUtilities');

/**
 * Description of QbItems
 *
 * @author dondrake
 */
class QbItems extends AppModel {
	
	/**
	 * The container for the Model object
	 * 
	 * Each section of the iff File is stored in a separate Table. 
	 * The Model for that table will be generated on the fly and stored here. 
	 *
	 * @var object
	 */
	public $db;
	
	/**
	 * This Model just manages the process and doesn't actually use a table
	 *
	 * @var boolean
	 */
	public $useTable = FALSE;

	/**
	 * The fieldnames extracted from a Header line 
	 *
	 * @var array
	 */
	public $headers = array();
	
	/**
	 * The tools to insure the data can be safely stored in the table fields
	 *
	 * @var object
	 */
	public $dataQC;


	/**
	 * Read an iff file and store its data into data tables
	 * 
	 * The tables need to be defined first, but everything else is automatic. 
	 * Each line is read, the factory determines if it is a Header or Data line. 
	 * We make sure it is the kind of data we want to save. 
	 * The concrete Line Classes do the task appropriate to their line.
	 * 
	 * @param resouce $handle The controller gets us a valid file handle to an iff file
	 */
	public function import($handle) {
		while(($line = fgets($handle)) != FALSE){
			$lineType = LineTypeFactory::create($this, $line);
			if($lineType->skip()){
				continue;
			}
			$lineType->execute();
		}
	}
}
?>
