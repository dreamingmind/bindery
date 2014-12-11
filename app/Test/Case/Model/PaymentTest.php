<?php
App::uses('Payment', 'Model');

/**
 * Payment Test Case
 *
 */
class PaymentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.payment',
		'app.order',
		'app.user',
		'app.group',
		'app.optin_user',
		'app.optin',
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
		$this->Payment = ClassRegistry::init('Payment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Payment);

		parent::tearDown();
	}

}
