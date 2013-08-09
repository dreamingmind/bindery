<?php
/* Designs Test cases generated on: 2013-08-08 22:30:08 : 1376026208*/
App::import('Controller', 'Designs');

class TestDesignsController extends DesignsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DesignsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.design', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Designs =& new TestDesignsController();
		$this->Designs->constructClasses();
	}

	function endTest() {
		unset($this->Designs);
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