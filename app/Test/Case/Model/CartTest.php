<?php
App::uses('Cart', 'Model');

/**
 * Cart Test Case
 *
 */
class CartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cart',
		'app.user',
		'app.group',
		'app.optin_user',
		'app.optin',
		'app.session',
		'app.workshop',
		'app.category',
		'app.collection',
		'app.edition',
		'app.copy',
		'app.content_collection',
		'app.content',
		'app.image',
		'app.supplement',
		'app.catalog',
		'app.diagram',
		'app.request',
		'app.date'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cart = ClassRegistry::init('Cart');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cart);

		parent::tearDown();
	}

}
