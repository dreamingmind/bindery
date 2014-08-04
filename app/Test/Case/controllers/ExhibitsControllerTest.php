<?php
/* Exhibits Test cases generated on: 2011-03-11 18:03:49 : 1299898609*/
App::import('Controller', 'Exhibits');

class TestExhibitsController extends ExhibitsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExhibitsControllerTest extends CakeTestCase {
	var $fixtures = array('app.exhibit', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.account');

	function startTest() {
		$this->Exhibits =& new TestExhibitsController();
		$this->Exhibits->constructClasses();
	}

	function endTest() {
		unset($this->Exhibits);
		ClassRegistry::flush();
	}

}
?>