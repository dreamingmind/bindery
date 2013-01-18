<?php
/* ContentCollections Test cases generated on: 2013-01-17 20:49:04 : 1358484544*/
App::import('Controller', 'ContentCollections');

class TestContentCollectionsController extends ContentCollectionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ContentCollectionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.content_collection', 'app.collection', 'app.category', 'app.content', 'app.image', 'app.supplement', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->ContentCollections =& new TestContentCollectionsController();
		$this->ContentCollections->constructClasses();
	}

	function endTest() {
		unset($this->ContentCollections);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>