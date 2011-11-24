<?php
/* Image Fixture generated on: 2011-11-22 22:44:32 : 1322030672 */
class ImageFixture extends CakeTestFixture {
	var $name = 'Image';

	var $fields = array(
		'img_file' => array('type' => 'string', 'null' => true, 'length' => 35, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'height_val' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 6),
		'width_val' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 6),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'mimetype' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'filesize' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'width' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 9),
		'height' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 9),
		'indexes' => array('serial_num' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'img_file' => 'Lorem ipsum dolor sit amet',
			'id' => 1,
			'height_val' => 1,
			'width_val' => 1,
			'modified' => '1322030672',
			'created' => '1322030672',
			'mimetype' => 'Lorem ipsum dolor sit amet',
			'filesize' => 1,
			'width' => 1,
			'height' => 1
		),
	);
}
?>