<?php
/* Sessions Test cases generated on: 2012-11-20 10:13:32 : 1353435212*/
App::import('Controller', 'Sessions');

class TestSessionsController extends SessionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SessionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.session', 'app.workshop', 'app.date', 'app.navigator', 'app.navline', 'app.content', 'app.image', 'app.exhibit_supliment', 'app.content_collection', 'app.collection', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Sessions =& new TestSessionsController();
		$this->Sessions->constructClasses();
	}

	function endTest() {
		unset($this->Sessions);
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