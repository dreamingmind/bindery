<?php
/* Supplements Test cases generated on: 2013-01-16 08:14:54 : 1358352894*/
App::import('Controller', 'Supplements');

class TestSupplementsController extends SupplementsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SupplementsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.supplement', 'app.image', 'app.content', 'app.content_collection', 'app.collection', 'app.category', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Supplements =& new TestSupplementsController();
		$this->Supplements->constructClasses();
	}

	function endTest() {
		unset($this->Supplements);
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