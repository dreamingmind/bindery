<?php
/**
 * OrderFixture
 *
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'number' => array('type' => 'string', 'null' => false, 'length' => 9, 'collate' => 'latin1_swedish_ci', 'comment' => 'order number 1403-ACCD like amp', 'charset' => 'latin1'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'user who ordered'),
		'ship_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'address this was shipped to'),
		'bill_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'address this was billed to'),
		'transaction_id' => array('type' => 'string', 'null' => false, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'comment' => 'paypal or others may have a transaction #. assoc data can go to supplements', 'charset' => 'latin1'),
		'tracking_number' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'comment' => 'shipper\'s tracking number', 'charset' => 'latin1'),
		'carrier' => array('type' => 'string', 'null' => true, 'default' => 'USPS', 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => 'shippment carrier', 'charset' => 'latin1'),
		'method' => array('type' => 'string', 'null' => true, 'default' => 'Prioity', 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => 'shippment method', 'charset' => 'latin1'),
		'state' => array('type' => 'string', 'null' => false, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'comment' => 'cart, shipped', 'charset' => 'latin1'),
		'invoice_number' => array('type' => 'string', 'null' => false, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'comment' => 'probably my qb invoice? but possibly a paypal inv? we can link invoice-belongsTo-orders if necessary', 'charset' => 'latin1'),
		'phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'comment' => 'contact number for shipping/order', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'comment' => 'contact email for order', 'charset' => 'latin1'),
		'collection_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Automatically start a content collection?'),
		'item_count' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'counter-cache'),
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
			'created' => '2014-11-04 16:01:51',
			'modified' => '2014-11-04 16:01:51',
			'number' => 'Lorem i',
			'user_id' => 1,
			'ship_id' => 1,
			'bill_id' => 1,
			'transaction_id' => 'Lorem ipsum dolor sit amet',
			'tracking_number' => 'Lorem ipsum dolor sit amet',
			'carrier' => 'Lorem ipsum dolor sit amet',
			'method' => 'Lorem ipsum dolor sit amet',
			'state' => 'Lorem ipsum dolor sit amet',
			'invoice_number' => 'Lorem ipsum dolor ',
			'phone' => 'Lorem ipsum dolor ',
			'email' => 'Lorem ipsum dolor sit amet',
			'collection_id' => 1,
			'item_count' => 1
		),
	);

}
