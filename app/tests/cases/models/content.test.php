<?php
/* Content Test cases generated on: 2011-04-02 17:04:28 : 1301790808*/
App::import('Model', 'Content');

class ContentTestCase extends CakeTestCase {
	var $fixtures = array('app.content', 'app.navigator', 'app.navline');

	function startTest() {
		$this->Content =& ClassRegistry::init('Content');
	}

	function endTest() {
		unset($this->Content);
		ClassRegistry::flush();
	}

}
?>