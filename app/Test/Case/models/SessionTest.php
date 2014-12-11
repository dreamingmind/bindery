<?php
/* Session Test cases generated on: 2012-11-20 10:13:32 : 1353435212*/
App::import('Model', 'Session');

class SessionTest extends CakeTestCase {
	var $fixtures = array('app.session', 'app.workshop', 'app.date');

	function startTest() {
		$this->Session =& ClassRegistry::init('Session');
	}

	function endTest() {
		unset($this->Session);
		ClassRegistry::flush();
	}

}
?>