<?php
/* Catalog Fixture generated on: 2013-01-22 21:44:57 : 1358919897 */
class CatalogFixture extends CakeTestFixture {
	var $name = 'Catalog';

	var $fields = array(
		'size' => array('type' => 'string', 'null' => false, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'product_group' => array('type' => 'string', 'null' => false, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 9),
		'category' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'product_code' => array('type' => 'string', 'null' => false, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'size' => 'Lorem ipsum d',
			'id' => 1,
			'product_group' => 'Lorem ipsum d',
			'price' => 1,
			'category' => 'Lorem ipsum dolor ',
			'product_code' => 'Lorem ip'
		),
	);
}
?>