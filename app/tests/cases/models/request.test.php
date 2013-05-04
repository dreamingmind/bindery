<?php
/* Request Test cases generated on: 2013-05-03 10:49:51 : 1367603391*/
App::import('Model', 'Request');

class RequestTestCase extends CakeTestCase {
	var $fixtures = array('app.request', 'app.workshop', 'app.category', 'app.collection', 'app.content_collection', 'app.content', 'app.image', 'app.supplement', 'app.session', 'app.date');

	function startTest() {
		$this->Request =& ClassRegistry::init('Request');
	}

	function endTest() {
		unset($this->Request);
		ClassRegistry::flush();
	}

}
?>