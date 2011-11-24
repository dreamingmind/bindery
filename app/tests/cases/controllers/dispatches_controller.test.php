<?php
/* Dispatches Test cases generated on: 2011-11-23 09:52:44 : 1322070764*/
App::import('Controller', 'Dispatches');

class TestDispatchesController extends DispatchesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DispatchesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.dispatch', 'app.image', 'app.exhibit', 'app.gallery', 'app.dispatch_gallery', 'app.exhibit_gallery', 'app.navigator', 'app.navline', 'app.content', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Dispatches =& new TestDispatchesController();
		$this->Dispatches->constructClasses();
	}

	function endTest() {
		unset($this->Dispatches);
		ClassRegistry::flush();
	}

	function testOnTheBench() {

	}

	function testIngestImage() {

	}

	function testAssemNewTable() {

	}

	function testAssemDisTable() {

	}

	function testAssemDupTable() {

	}

	function testShowPicture() {

	}

	function testUploadAlt() {

	}

	function testRemoveImage() {

	}

	function testAlert() {

	}

	function testNewImageRecord() {

	}

	function testJsSafe() {

	}

}
?>