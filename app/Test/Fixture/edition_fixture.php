<?php
/* Edition Fixture generated on: 2013-06-20 20:58:00 : 1371787080 */
class EditionFixture extends CakeTestFixture {
	var $name = 'Edition';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'collection_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'size' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => 'edition size'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2013-06-20 20:58:00',
			'modified' => '2013-06-20 20:58:00',
			'collection_id' => 1,
			'size' => 1
		),
	);
}
?>