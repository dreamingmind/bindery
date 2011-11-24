<?php
/* DispatchGallery Fixture generated on: 2011-11-23 10:58:34 : 1322074714 */
class DispatchGalleryFixture extends CakeTestFixture {
	var $name = 'DispatchGallery';

	var $fields = array(
		'gallery_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'dispatch_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'gallery_id' => 1,
			'dispatch_id' => 1,
			'created' => '1322074714',
			'modified' => '1322074714',
			'id' => 1
		),
	);
}
?>