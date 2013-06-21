<?php
/* Editions Test cases generated on: 2013-06-20 21:32:53 : 1371789173*/
App::import('Controller', 'Editions');

class TestEditionsController extends EditionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EditionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.edition', 'app.collection', 'app.category', 'app.content_collection', 'app.content', 'app.image', 'app.workshop', 'app.session', 'app.date', 'app.request', 'app.supplement', 'app.catalog', 'app.copy', 'app.navigator', 'app.navline', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Editions =& new TestEditionsController();
		$this->Editions->constructClasses();
	}

	function endTest() {
		unset($this->Editions);
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