<?php
/* ContentCollections Test cases generated on: 2012-01-17 19:42:43 : 1326858163*/
App::import('Controller', 'ContentCollections');

class TestContentCollectionsController extends ContentCollectionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ContentCollectionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.content_collection', 'app.content', 'app.navline', 'app.navigator', 'app.image', 'app.exhibit_supliment', 'app.collection', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

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