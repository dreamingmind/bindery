<?php

/**
 * Description of LineTypeFactory
 *
 * @author jasont
 */

App::uses('LineHeader', 'Lib/QBUtilities');
App::uses('LineData', 'Lib/QBUtilities');

/**
 * Return an object appropriate to the kind of line read from the iff file
 * 
 * The lines will be Header lines that start with a '!' 
 * Or data lines that match the column count of the headers
 * 
 */
class LineTypeFactory {
	static public function create($Model, $line) {
		if($line[0] === '!'){
			return new LineHeader($Model, $line);
		} else {
			return new LineData($Model, $line);
		}
	}
}

?>
