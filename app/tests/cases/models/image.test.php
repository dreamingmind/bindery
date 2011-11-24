<?php
/* Image Test cases generated on: 2011-11-22 22:44:32 : 1322030672*/
App::import('Model', 'Image');

class ImageTestCase extends CakeTestCase {
	var $fixtures = array('app.image', 'app.dispatch', 'app.gallery', 'app.dispatch_gallery', 'app.exhibit', 'app.exhibit_gallery');

	function startTest() {
		$this->Image =& ClassRegistry::init('Image');
	}

	function endTest() {
		unset($this->Image);
		ClassRegistry::flush();
	}

}
?>