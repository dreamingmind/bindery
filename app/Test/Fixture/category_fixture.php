<?php
/* Category Fixture generated on: 2012-12-20 20:08:38 : 1356062918 */
class CategoryFixture extends CakeTestFixture {
	var $name = 'Category';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => true, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'name of the category', 'charset' => 'latin1'),
		'description' => array('type' => 'string', 'null' => true, 'collate' => 'latin1_swedish_ci', 'comment' => 'description for the administrator', 'charset' => 'latin1'),
		'supplement_list' => array('type' => 'string', 'null' => true, 'default' => 'empty', 'collate' => 'latin1_swedish_ci', 'comment' => 'comma separated list of required supplemental data', 'charset' => 'latin1'),
		'indexes' => array('serial_num' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'modified' => '2012-12-20 20:08:38',
			'created' => '2012-12-20 20:08:38',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'supplement_list' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>