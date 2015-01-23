<?php
App::uses('AppModel', 'Model');

/**
 * CakePHP Customer
 * @author dondrake
 */
class Customer extends AppModel {
	
	public $useTable = 'users';
	
//	public $hasMany = array(
//		'WishList' => array(
//			'className' => 'WishList',
//			'foreignKey' => 'user_id',
//			'dependent' => true,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		),
//	);
		
	public function wishCount($id) {
		$this->id = $id;
		return $this->field('wish_item_count');
	}
}
