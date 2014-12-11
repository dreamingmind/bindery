<?php
/* Category Test cases generated on: 2012-12-20 20:08:38 : 1356062918*/
App::import('Model', 'Category');

class CategoryTest extends CakeTestCase {
	var $fixtures = array('app.category', 'app.collection', 'app.content_collection', 'app.content', 'app.navline', 'app.navigator', 'app.image', 'app.supplement');

	function startTest() {
		$this->Category =& ClassRegistry::init('Category');
	}

	function endTest() {
		unset($this->Category);
		ClassRegistry::flush();
	}

}
?>