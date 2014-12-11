<?php
/* Workshop Test cases generated on: 2012-11-20 10:11:20 : 1353435080*/
App::import('Model', 'Workshop');

class WorkshopTest extends CakeTestCase {
	var $fixtures = array('app.workshop', 'app.session');

	function startTest() {
		$this->Workshop =& ClassRegistry::init('Workshop');
	}

	function endTest() {
		unset($this->Workshop);
		ClassRegistry::flush();
	}

}
?>