<?php
/* Supplements Test cases generated on: 2012-12-20 17:58:12 : 1356055092*/
App::import('Controller', 'Supplements');

class TestSupplementsController extends SupplementsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SupplementsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.supplement', 'app.image', 'app.content', 'app.navline', 'app.navigator', 'app.exhibit_supliment', 'app.content_collection', 'app.collection', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

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