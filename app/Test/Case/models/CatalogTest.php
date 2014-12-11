<?php
/* Catalog Test cases generated on: 2013-01-22 21:44:58 : 1358919898*/
App::import('Model', 'Catalog');

class CatalogTest extends CakeTestCase {
	var $fixtures = array('app.catalog');

	function startTest() {
		$this->Catalog =& ClassRegistry::init('Catalog');
	}

	function endTest() {
		unset($this->Catalog);
		ClassRegistry::flush();
	}

}
?>