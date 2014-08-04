<?php
/* Optins Test cases generated on: 2011-03-13 20:03:29 : 1300074509*/
App::import('Controller', 'Optins');

class TestOptinsController extends OptinsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class OptinsControllerTest extends CakeTestCase {
	var $fixtures = array('app.optin', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.account');

	function startTest() {
		$this->Optins =& new TestOptinsController();
		$this->Optins->constructClasses();
	}

	function endTest() {
		unset($this->Optins);
		ClassRegistry::flush();
	}

}
?>