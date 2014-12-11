<?php
/* Materials Test cases generated on: 2011-10-08 17:09:32 : 1318118972*/
App::import('Controller', 'Materials');

class TestMaterialsController extends MaterialsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MaterialsControllerTest extends CakeTestCase {
	var $fixtures = array('app.material', 'app.navigator', 'app.navline', 'app.content', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Materials =& new TestMaterialsController();
		$this->Materials->constructClasses();
	}

	function endTest() {
		unset($this->Materials);
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