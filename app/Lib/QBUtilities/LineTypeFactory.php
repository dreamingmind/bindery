<?php

/**
 * Description of LineTypeFactory
 *
 * @author jasont
 */

App::uses('LineHeader', 'Lib/QBUtilities');
App::uses('LineData', 'Lib/QBUtilities');

class LineTypeFactory {
	static public function create($line) {
		if($line[0] === '!'){
			return new LineHeader($line);
		} else {
			return new LineData($line);
		}
	}
}

?>
