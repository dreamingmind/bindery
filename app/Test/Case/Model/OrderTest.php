<?php
App::uses('Order', 'Model');

/**
 * Order Test Case
 *
 */
class OrderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		'app.diagram',
		'app.order_item'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Order = ClassRegistry::init('Order');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Order);

		parent::tearDown();
	}

}
