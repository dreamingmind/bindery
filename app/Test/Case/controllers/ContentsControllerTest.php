<?php
/* Contents Test cases generated on: 2011-12-11 21:50:26 : 1323669026*/
App::import('Controller', 'Contents');

class TestContentsController extends ContentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ContentsControllerTest extends CakeTestCase {
	var $fixtures = array('app.content', 'app.navline', 'app.navigator', 'app.image', 'app.dispatch', 'app.dispatch_gallery', 'app.gallery', 'app.exhibit', 'app.exhibit_gallery', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Contents =& new TestContentsController();
		$this->Contents->constructClasses();
	}

	function endTest() {
		unset($this->Contents);
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