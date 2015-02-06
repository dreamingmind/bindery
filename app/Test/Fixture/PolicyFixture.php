<?php
/**
 * PolicyFixture
 *
 */
class PolicyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'policy' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name_display' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 1),
		'policy_display' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 1),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'sequence' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 2),
		'lft' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
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
			'created' => '2015-02-05 15:37:53',
			'modified' => '2015-02-05 15:37:53',
			'name' => 'Lorem ipsum dolor sit amet',
			'policy' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'name_display' => 1,
			'policy_display' => 1,
			'parent_id' => 1,
			'sequence' => 1,
			'lft' => 1,
			'rght' => 1
		),
	);

}
