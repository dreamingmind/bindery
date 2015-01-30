<?php
App::uses('AppModel', 'Model');
/**
 * Payment Model
 *
 * @property Order $Order
 * @property User $User
 */
class Payment extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	 * Save data associated with some checkout payment event
	 * 
	 * @param string $order_id
	 * @param string $user_id
	 * @param string $event word describing what the data was a response to
	 * @param arraty $data
	 * @return boolean
	 */
	public function orderEvent($order_id, $user_id, $event, $data) {
		$record = array(
			'order_id' => $order_id,
			'user_id' => $user_id,
			'type' => $event,
			'data' => json_encode($data)
		);
		
		$this->create($record);
		return $this->save($record);
	}
}
