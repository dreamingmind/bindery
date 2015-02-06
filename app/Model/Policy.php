<?php
App::uses('AppModel', 'Model');

define('ENDPOINT', 1); // show when rendering this record as an endpoint
define('ALWAYS', 2); // show whenever this record is in the heirarchy
define('NEVER', 3); // never display

/**
 * Policy Model
 *
 * @property Policy $ParentPolicy
 * @property Policy $ChildPolicy
 */
class Policy extends AppModel {

	public $display_options;

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentPolicy' => array(
			'className' => 'Policy',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildPolicy' => array(
			'className' => 'Policy',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	/**
	 * Get a select list of display options
	 * 
	 *  Endpoint = show when rendering this record as an endpoint
	 *	Always = show whenever this record is in the heirarchy
	 *	Never = never display
	 * 
	 * @return array
	 */
	public function displayOptions() {
		if (!$this->display_options) {
			$this->display_options = (array(
				ENDPOINT => 'Endpoint',
				ALWAYS => 'Always',
				NEVER => 'Never'			
			));
		}
		return $this->display_options;
	}
	
	public function parents($conditions = array()) {
		return $this->find('list', array($conditions));
	}

}
