<?php
/* ExhibitSupliment Fixture generated on: 2011-12-14 22:11:19 : 1323929479 */
class ExhibitSuplimentFixture extends CakeTestFixture {
	var $name = 'ExhibitSupliment';

	var $fields = array(
		'img_file' => array('type' => 'string', 'null' => true, 'length' => 35, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'heading' => array('type' => 'string', 'null' => true, 'length' => 120, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'prose' => array('type' => 'binary', 'null' => true, 'default' => NULL),
		'prose_t' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'top_val' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 6),
		'left_val' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 6),
		'height_val' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 6),
		'width_val' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 6),
		'headstyle' => array('type' => 'string', 'null' => true, 'length' => 35, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'pgraphstyle' => array('type' => 'string', 'null' => true, 'length' => 35, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'alt' => array('type' => 'string', 'null' => true, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'image_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20),
		'mimetype' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 40, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'filesize' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'width' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 9),
		'height' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 9),
		'exhibit_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'content_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20),
		'indexes' => array('serial_num' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'img_file' => 'Lorem ipsum dolor sit amet',
			'heading' => 'Lorem ipsum dolor sit amet',
			'prose' => 'Lorem ipsum dolor sit amet',
			'prose_t' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'id' => 1,
			'top_val' => 1,
			'left_val' => 1,
			'height_val' => 1,
			'width_val' => 1,
			'headstyle' => 'Lorem ipsum dolor sit amet',
			'pgraphstyle' => 'Lorem ipsum dolor sit amet',
			'modified' => '1323929479',
			'alt' => 'Lorem ipsum dolor sit amet',
			'created' => '1323929479',
			'image_id' => 1,
			'mimetype' => 'Lorem ipsum dolor sit amet',
			'filesize' => 1,
			'width' => 1,
			'height' => 1,
			'exhibit_id' => 1,
			'content_id' => 1
		),
	);
}
?>