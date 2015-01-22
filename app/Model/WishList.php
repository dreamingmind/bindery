<?php
App::uses('AppModel', 'Model');

/**
 * CakePHP WishList
 * @author dondrake
 */
class WishList extends AppModel {
	
//	public $belongsTo = array(
//		'User' => array(
//			'className' => 'User',
//			'foreignKey' => 'user_id',
////			'counterCache' => 'wish_item_count',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
//	);

	public $useTable = 'cart_items';
	
}
