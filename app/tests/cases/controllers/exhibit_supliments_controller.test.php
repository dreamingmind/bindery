<?php
/* ExhibitSupliments Test cases generated on: 2011-12-14 22:11:20 : 1323929480*/
App::import('Controller', 'ExhibitSupliments');

class TestExhibitSuplimentsController extends ExhibitSuplimentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExhibitSuplimentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.exhibit_supliment', 'app.image', 'app.dispatch', 'app.dispatch_gallery', 'app.gallery', 'app.exhibit', 'app.exhibit_gallery', 'app.content', 'app.navline', 'app.navigator', 'app.content_collection', 'app.collection', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->ExhibitSupliments =& new TestExhibitSuplimentsController();
		$this->ExhibitSupliments->constructClasses();
	}

	function endTest() {
		unset($this->ExhibitSupliments);
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