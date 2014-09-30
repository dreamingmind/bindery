<?php
App::uses('AppModel', 'Model');
/**
 * Cart Model
 *
 * @property User $User
 * @property Session $Session
 * @property Supplement $Supplement
 */
class Cart extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Session' => array(
			'className' => 'Session',
			'foreignKey' => 'session_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Supplement' => array(
			'className' => 'Supplement',
			'foreignKey' => 'supplement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function exists($sessionId) {
		
	}
	
	public function move($oldSession, $newSession) {
		
	}
	
	public function clear($sessionId) {
		
	}
}
