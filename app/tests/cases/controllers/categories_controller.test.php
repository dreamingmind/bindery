<?php
/* Categories Test cases generated on: 2012-12-20 20:08:38 : 1356062918*/
App::import('Controller', 'Categories');

class TestCategoriesController extends CategoriesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CategoriesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.category', 'app.collection', 'app.content_collection', 'app.content', 'app.navline', 'app.navigator', 'app.image', 'app.supplement', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Categories =& new TestCategoriesController();
		$this->Categories->constructClasses();
	}

	function endTest() {
		unset($this->Categories);
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