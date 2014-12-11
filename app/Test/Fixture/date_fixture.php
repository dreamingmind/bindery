<?php
/* Date Fixture generated on: 2012-11-20 10:13:42 : 1353435222 */
class DateFixture extends CakeTestFixture {
	var $name = 'Date';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'primary'),
		'session_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'date' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'start_time' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'end_time' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'session_id' => 1,
			'date' => '2012-11-20',
			'start_time' => '1353435222',
			'end_time' => '1353435222',
			'modified' => '1353435222',
			'created' => '1353435222'
		),
	);
}
?>