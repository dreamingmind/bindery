<?php
/* Session Fixture generated on: 2012-11-20 10:13:32 : 1353435212 */
class SessionFixture extends CakeTestFixture {
	var $name = 'Session';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'primary'),
		'workshop_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cost' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'participants' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'first_day' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'last_day' => array('type' => 'date', 'null' => false, 'default' => NULL),
		'registered' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'modified' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'workshop_id' => 1,
			'title' => 'Lorem ipsum dolor sit amet',
			'cost' => 1,
			'participants' => 1,
			'first_day' => '2012-11-20',
			'last_day' => '2012-11-20',
			'registered' => 1,
			'modified' => '1353435212',
			'created' => '1353435212'
		),
	);
}
?>