<?php
/* Copy Test cases generated on: 2013-06-20 20:58:14 : 1371787094*/
App::import('Model', 'Copy');

class CopyTestCase extends CakeTestCase {
	var $fixtures = array('app.copy', 'app.edition', 'app.collection', 'app.category', 'app.content_collection', 'app.content', 'app.image', 'app.workshop', 'app.session', 'app.date', 'app.request', 'app.supplement', 'app.catalog');

	function startTest() {
		$this->Copy =& ClassRegistry::init('Copy');
	}

	function endTest() {
		unset($this->Copy);
		ClassRegistry::flush();
	}

}
?>