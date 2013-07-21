<?php
/* Diagrams Test cases generated on: 2013-07-21 13:26:53 : 1374438413*/
App::import('Controller', 'Diagrams');

class TestDiagramsController extends DiagramsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DiagramsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.diagram', 'app.catalog', 'app.collection', 'app.category', 'app.edition', 'app.copy', 'app.content_collection', 'app.content', 'app.image', 'app.workshop', 'app.session', 'app.date', 'app.request', 'app.supplement', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Diagrams =& new TestDiagramsController();
		$this->Diagrams->constructClasses();
	}

	function endTest() {
		unset($this->Diagrams);
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