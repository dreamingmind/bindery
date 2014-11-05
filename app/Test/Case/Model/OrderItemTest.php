<?php
App::uses('OrderItem', 'Model');

/**
 * OrderItem Test Case
 *
 */
class OrderItemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.order_item',
		'app.order',
		'app.user',
		'app.group',
		'app.optin_user',
		'app.optin',
		'app.ship',
		'app.bill',
		'app.transaction',
		'app.collection',
		'app.category',
		'app.edition',
		'app.copy',
		'app.content_collection',
		'app.content',
		'app.image',
		'app.workshop',
		'app.session',
		'app.date',
		'app.request',
		'app.supplement',
		'app.catalog',
		'app.diagram'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrderItem = ClassRegistry::init('OrderItem');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderItem);

		parent::tearDown();
	}

}
