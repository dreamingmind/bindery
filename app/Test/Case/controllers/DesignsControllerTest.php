<?php
/* Designs Test cases generated on: 2013-08-09 15:38:26 : 1376087906*/
App::import('Controller', 'Designs');

class TestDesignsController extends DesignsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DesignsControllerTest extends CakeTestCase {
	var $fixtures = array('app.design', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.supplement', 'app.content_collection', 'app.content', 'app.image', 'app.collection', 'app.category', 'app.edition', 'app.copy', 'app.catalog', 'app.diagram', 'app.workshop', 'app.session', 'app.date', 'app.request', 'app.navigator', 'app.navline', 'app.account');

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