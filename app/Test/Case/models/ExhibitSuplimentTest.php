<?php
/* ExhibitSupliment Test cases generated on: 2011-12-14 22:11:19 : 1323929479*/
App::import('Model', 'ExhibitSupliment');

class ExhibitSuplimentTest extends CakeTestCase {
	var $fixtures = array('app.exhibit_supliment', 'app.image', 'app.dispatch', 'app.dispatch_gallery', 'app.gallery', 'app.exhibit', 'app.exhibit_gallery', 'app.content', 'app.navline', 'app.navigator', 'app.content_collection', 'app.collection');

	function startTest() {
		$this->ExhibitSupliment =& ClassRegistry::init('ExhibitSupliment');
	}

	function endTest() {
		unset($this->ExhibitSupliment);
		ClassRegistry::flush();
	}

}
?>