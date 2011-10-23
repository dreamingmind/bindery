<?php
/* Material Test cases generated on: 2011-10-08 15:43:53 : 1318113833*/
App::import('Model', 'Material');

class MaterialTestCase extends CakeTestCase {
	var $fixtures = array('app.material');

	function startTest() {
		$this->Material =& ClassRegistry::init('Material');
	}

	function endTest() {
		unset($this->Material);
		ClassRegistry::flush();
	}

}
?>