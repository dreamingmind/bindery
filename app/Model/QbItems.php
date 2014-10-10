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
	
	public $db;
	
	public $useTable = FALSE;

	public $headers = array();
	
	public function import($handle) {
		while(($line = fgets($handle)) != FALSE){
			$lineType = LineTypeFactory::create($this, $line);
			if($lineType->skip()){
				continue;
			}
			$this->headers = $lineType->execute($this->headers);
		}
	}
}
?>
