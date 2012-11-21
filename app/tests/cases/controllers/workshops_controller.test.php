<?php
/* Workshops Test cases generated on: 2012-11-20 10:11:20 : 1353435080*/
App::import('Controller', 'Workshops');

class TestWorkshopsController extends WorkshopsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class WorkshopsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.workshop', 'app.session', 'app.navigator', 'app.navline', 'app.content', 'app.image', 'app.exhibit_supliment', 'app.content_collection', 'app.collection', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Workshops =& new TestWorkshopsController();
		$this->Workshops->constructClasses();
	}

	function endTest() {
		unset($this->Workshops);
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