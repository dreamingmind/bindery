<?php
/* Requests Test cases generated on: 2013-05-03 10:49:54 : 1367603394*/
App::import('Controller', 'Requests');

class TestRequestsController extends RequestsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RequestsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.request', 'app.workshop', 'app.category', 'app.collection', 'app.content_collection', 'app.content', 'app.image', 'app.supplement', 'app.session', 'app.date', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Requests =& new TestRequestsController();
		$this->Requests->constructClasses();
	}

	function endTest() {
		unset($this->Requests);
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