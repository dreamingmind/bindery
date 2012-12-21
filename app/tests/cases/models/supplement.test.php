<?php
/* Supplement Test cases generated on: 2012-12-20 17:58:12 : 1356055092*/
App::import('Model', 'Supplement');

class SupplementTestCase extends CakeTestCase {
	var $fixtures = array('app.supplement', 'app.image', 'app.content', 'app.navline', 'app.navigator', 'app.exhibit_supliment', 'app.content_collection', 'app.collection');

	function startTest() {
		$this->Supplement =& ClassRegistry::init('Supplement');
	}

	function endTest() {
		unset($this->Supplement);
		ClassRegistry::flush();
	}

}
?>