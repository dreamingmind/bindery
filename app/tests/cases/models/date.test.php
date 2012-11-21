<?php
/* Date Test cases generated on: 2012-11-20 10:13:42 : 1353435222*/
App::import('Model', 'Date');

class DateTestCase extends CakeTestCase {
	var $fixtures = array('app.date', 'app.session', 'app.workshop');

	function startTest() {
		$this->Date =& ClassRegistry::init('Date');
	}

	function endTest() {
		unset($this->Date);
		ClassRegistry::flush();
	}

}
?>