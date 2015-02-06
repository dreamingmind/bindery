<?php
App::uses('Policy', 'Model');

/**
 * Policy Test Case
 *
 */
class PolicyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.policy'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Policy = ClassRegistry::init('Policy');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Policy);

		parent::tearDown();
	}

}
