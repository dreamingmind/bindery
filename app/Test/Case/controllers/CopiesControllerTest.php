<?php
/* Copies Test cases generated on: 2013-06-20 22:33:45 : 1371792825*/
App::import('Controller', 'Copies');

class TestCopiesController extends CopiesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CopiesControllerTest extends CakeTestCase {
	var $fixtures = array('app.copy', 'app.edition', 'app.collection', 'app.category', 'app.content_collection', 'app.content', 'app.image', 'app.workshop', 'app.session', 'app.date', 'app.request', 'app.supplement', 'app.catalog', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Copies =& new TestCopiesController();
		$this->Copies->constructClasses();
	}

	function endTest() {
		unset($this->Copies);
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