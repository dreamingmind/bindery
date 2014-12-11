<?php
/* Products Test cases generated on: 2013-01-22 21:19:30 : 1358918370*/
App::import('Controller', 'Products');

class TestProductsController extends ProductsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ProductsControllerTest extends CakeTestCase {
	var $fixtures = array('app.product', 'app.navigator', 'app.navline', 'app.content', 'app.image', 'app.content_collection', 'app.collection', 'app.category', 'app.supplement', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Products =& new TestProductsController();
		$this->Products->constructClasses();
	}

	function endTest() {
		unset($this->Products);
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