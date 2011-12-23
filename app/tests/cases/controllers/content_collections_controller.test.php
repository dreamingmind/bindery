<?php
/* ContentCollections Test cases generated on: 2011-12-11 21:37:18 : 1323668238*/
App::import('Controller', 'ContentCollections');

class TestContentCollectionsController extends ContentCollectionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ContentCollectionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.content_collection', 'app.gallery', 'app.dispatch_gallery', 'app.dispatch', 'app.image', 'app.exhibit', 'app.exhibit_gallery', 'app.content', 'app.navline', 'app.navigator', 'app.collection', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

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