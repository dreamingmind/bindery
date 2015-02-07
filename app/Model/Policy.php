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
	
	/**
	 * Return a select list of id=>name for policies that meet $conditions
	 * 
	 * @param array $conditions
	 * @return array
	 */
	public function parents($conditions = array()) {
		return $this->find('list', array($conditions));
	}
	
	/**
	 * Return a single policy statement record
	 * 
	 * @param string $policy
	 * @return string
	 */
	public function policyRecord($policy) {
		$policy_record = $this->find('first', array('conditions' => array('Policy.name' => $policy), 'contain' => FALSE));
		if ($policy_record) {
			return $policy_record['Policy'];
		} else {
			return array();
		}
	}
	
	/**
	 * Return a set of policies in a heirarchy
	 * 
	 * @param string $policy The name of the parent policy record
	 * @return array
	 */
	public function collection($policy) {
		$collection = $this->find('all', array(
			'conditions' => array('Policy.name' => $policy),
			'contain' => 'ChildPolicy'
//			'recursive' => '2'
		));
		return $collection;
	}

}
