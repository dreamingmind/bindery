<?php
/* DispatchGallery Test cases generated on: 2011-11-23 10:58:34 : 1322074714*/
App::import('Model', 'DispatchGallery');

class DispatchGalleryTestCase extends CakeTestCase {
	var $fixtures = array('app.dispatch_gallery', 'app.gallery', 'app.dispatch', 'app.image', 'app.exhibit', 'app.exhibit_gallery');

	function startTest() {
		$this->DispatchGallery =& ClassRegistry::init('DispatchGallery');
	}

	function endTest() {
		unset($this->DispatchGallery);
		ClassRegistry::flush();
	}

}
?>