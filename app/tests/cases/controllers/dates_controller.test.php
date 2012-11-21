<?php
/* Dates Test cases generated on: 2012-11-20 10:13:42 : 1353435222*/
App::import('Controller', 'Dates');

class TestDatesController extends DatesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DatesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.date', 'app.session', 'app.workshop', 'app.navigator', 'app.navline', 'app.content', 'app.image', 'app.exhibit_supliment', 'app.content_collection', 'app.collection', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Dates =& new TestDatesController();
		$this->Dates->constructClasses();
	}

	function endTest() {
		unset($this->Dates);
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