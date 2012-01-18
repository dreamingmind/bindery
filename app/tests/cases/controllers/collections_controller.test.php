<?php
/* Collections Test cases generated on: 2012-01-17 19:40:31 : 1326858031*/
App::import('Controller', 'Collections');

class TestCollectionsController extends CollectionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CollectionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.collection', 'app.content_collection', 'app.content', 'app.navline', 'app.navigator', 'app.image', 'app.exhibit_supliment', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Collections =& new TestCollectionsController();
		$this->Collections->constructClasses();
	}

	function endTest() {
		unset($this->Collections);
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