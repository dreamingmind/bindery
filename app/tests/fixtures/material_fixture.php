<?php
/* Material Fixture generated on: 2011-10-08 15:43:53 : 1318113833 */
class MaterialFixture extends CakeTestFixture {
	var $name = 'Material';

	var $fields = array(
		'mat_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 9, 'key' => 'primary'),
		'category' => array('type' => 'string', 'null' => false, 'length' => 30, 'key' => 'index', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'file_name' => array('type' => 'string', 'null' => false, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'title' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'mat_id', 'unique' => 1), 'category' => array('column' => 'category', 'unique' => 0)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'mat_id' => 1,
			'category' => 'Lorem ipsum dolor sit amet',
			'file_name' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'created' => '1318113832',
			'modified' => '1318113832'
		),
	);
}
?>