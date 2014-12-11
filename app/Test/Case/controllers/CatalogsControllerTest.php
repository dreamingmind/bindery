<?php
/* Catalogs Test cases generated on: 2013-01-22 21:44:58 : 1358919898*/
App::uses('Catalogs', 'Controller');

class TestCatalogsController extends CatalogsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CatalogsControllerTest extends CakeTestCase {
	var $fixtures = array('app.catalog', 'app.navigator', 'app.navline', 'app.content', 'app.image', 'app.content_collection', 'app.collection', 'app.category', 'app.supplement', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Catalogs =& new TestCatalogsController();
		$this->Catalogs->constructClasses();
	}

	function endTest() {
		unset($this->Catalogs);
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