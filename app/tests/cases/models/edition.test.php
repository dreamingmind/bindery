<?php
/* Edition Test cases generated on: 2013-06-20 20:58:01 : 1371787081*/
App::import('Model', 'Edition');

class EditionTestCase extends CakeTestCase {
	var $fixtures = array('app.edition', 'app.collection', 'app.category', 'app.content_collection', 'app.content', 'app.image', 'app.workshop', 'app.session', 'app.date', 'app.request', 'app.supplement', 'app.catalog', 'app.copy');

	function startTest() {
		$this->Edition =& ClassRegistry::init('Edition');
	}

	function endTest() {
		unset($this->Edition);
		ClassRegistry::flush();
	}

}
?>