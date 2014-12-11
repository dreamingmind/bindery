<?php
/* Supplement Fixture generated on: 2012-12-20 17:58:12 : 1356055092 */
class SupplementFixture extends CakeTestFixture {
	var $name = 'Supplement';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'image_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'collection_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'type' => array('type' => 'string', 'null' => true, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'data' => array('type' => 'string', 'null' => true, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('serial_num' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'modified' => '2012-12-20 17:58:12',
			'created' => '2012-12-20 17:58:12',
			'image_id' => 1,
			'collection_id' => 1,
			'type' => 'Lorem ipsum dolor sit amet',
			'data' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>