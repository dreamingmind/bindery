<?php
/* Images Test cases generated on: 2011-11-22 22:45:48 : 1322030748*/
App::import('Controller', 'Images');

class TestImagesController extends ImagesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ImagesControllerTest extends CakeTestCase {
	var $fixtures = array('app.image', 'app.dispatch', 'app.gallery', 'app.dispatch_gallery', 'app.exhibit', 'app.exhibit_gallery', 'app.navigator', 'app.navline', 'app.content', 'app.user', 'app.group', 'app.optin_user', 'app.optin', 'app.account');

	function startTest() {
		$this->Images =& new TestImagesController();
		$this->Images->constructClasses();
	}

	function endTest() {
		unset($this->Images);
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