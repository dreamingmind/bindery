<?php
App::uses('Part', 'Model');

/**
 * Part Test Case
 *
 */
class PartTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.part'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Part = ClassRegistry::init('Part');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Part);

		parent::tearDown();
	}

}
