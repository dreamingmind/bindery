<?php
/* ContentCollection Fixture generated on: 2011-12-11 21:12:44 : 1323666764 */
class ContentCollectionFixture extends CakeTestFixture {
	var $name = 'ContentCollection';

	var $fields = array(
		'gallery_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'dispatch_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'visible' => array('type' => 'text', 'null' => true, 'default' => 'b\'0\'', 'length' => 1),
		'sub_gallery' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'content_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'exhibit_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'collection_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'seq' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'gallery_id' => 1,
			'dispatch_id' => 1,
			'created' => '1323666764',
			'modified' => '1323666764',
			'id' => 1,
			'visible' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'sub_gallery' => 1,
			'content_id' => 1,
			'exhibit_id' => 1,
			'collection_id' => 1,
			'seq' => 1
		),
	);
}
?>