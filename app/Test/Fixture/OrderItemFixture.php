<?php
/**
 * OrderItemFixture
 *
 */
class OrderItemFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'order_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'collection_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'content_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'image_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'product_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'comment' => 'the basic description/name (but not unique because we have option_summary for that', 'charset' => 'latin1'),
		'price' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'the price of a single unit'),
		'quantity' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'how many are being ordered'),
		'type' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'type names the helper and product utility to use for this entry', 'charset' => 'latin1'),
		'product_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => 'product code for the unit (ignoring option codes)', 'charset' => 'latin1'),
		'option_summary' => array('type' => 'string', 'null' => true, 'length' => 512, 'collate' => 'latin1_swedish_ci', 'comment' => 'details to differentiate similar or identical design_names', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'order_id' => 1,
			'user_id' => 1,
			'collection_id' => 1,
			'content_id' => 1,
			'image_id' => 'Lorem ipsum dolor sit amet',
			'product_name' => 'Lorem ipsum dolor sit amet',
			'price' => 1,
			'quantity' => 1,
			'type' => 'Lorem ipsum dolor sit amet',
			'product_code' => 'Lorem ipsum dolor sit amet',
			'option_summary' => 'Lorem ipsum dolor sit amet',
			'created' => '2014-11-04 16:02:30',
			'modified' => '2014-11-04 16:02:30'
		),
	);

}
