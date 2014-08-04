<?php
/* Product Fixture generated on: 2013-01-22 21:19:29 : 1358918369 */
class ProductFixture extends CakeTestFixture {
	var $name = 'Product';

	var $fields = array(
		'size' => array('type' => 'string', 'null' => false, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'product_code' => array('type' => 'string', 'null' => false, 'length' => 10, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'product_group' => array('type' => 'string', 'null' => false, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'price' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 9),
		'category' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'product_code', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'size' => 'Lorem ipsum d',
			'product_code' => 'Lorem ip',
			'product_group' => 'Lorem ipsum d',
			'price' => 1,
			'category' => 'Lorem ipsum dolor '
		),
	);
}
?>