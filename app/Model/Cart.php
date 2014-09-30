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
		'Supplement' => array(
			'className' => 'Supplement',
			'foreignKey' => 'supplement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function cartExists($sessionId) {
		
	}
	
	public function move($oldSession, $newSession) {
		$items = $this->find('all', array(
			'conditions' => array('phpsession_id' => $oldSession),
			'fields' => array('id', 'phpsession_id'),
			'contain' => FALSE
		));
		
		if (!empty($items)) {
			$move = Hash::insert($items, '{n}.Cart.phpsession_id', $newSession);
			$this->saveMany($move);
		}
	}
	
	public function clear($sessionId) {
		
	}
}
