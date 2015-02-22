<?php
class WorkshopSession extends AppModel {
	var $name = 'WorkshopSession';
	public $useTable = 'sessions';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'cost' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'participants' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first_day' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last_day' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'registered' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	var $belongsTo = array(
		'Workshop' => array(
			'className' => 'Workshop',
			'foreignKey' => 'collection_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Date' => array(
			'className' => 'Date',
			'foreignKey' => 'session_id',
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
	 * Find session data according to $conditions
	 * 
	 * @param array $conditions
	 * @return array
	 */
	protected function findSessions($conditions) {
		$sessions = $this->find('all', array(
			'conditions' => $conditions,
			'fields' => array(
				'WorkshopSession.id',
				'WorkshopSession.title',
				'WorkshopSession.collection_id',
				'WorkshopSession.cost',
				'WorkshopSession.participants',
				'WorkshopSession.first_day',
				'WorkshopSession.last_day',
				'WorkshopSession.registered'
			),
			'contain' => array(
				'Date' => array(
					'fields' => array(
						'Date.session_id',
						'Date.date',
						'Date.start_time',
						'Date.end_time'
					)
				)
			)
		));
		return sessions;
	}
	
	
	public function expiredSessions($workshop_id, $result_type = FALSE) {
		$conditions = array(
				'WorkshopSession.collection_id' => $workshop_id,
				'WorkshopSession.last_day < CURDATE()'
		);
		$expired_sessions = $this->findSessions($conditions);
		if (!$result_type) {
			return $current_sessions;
		} else {
			return $this->storageObject($result_type, $expired_sessions);
		}
	}
	
	public function currentSessions($workshop_id, $result_type = FALSE) {
		$conditions = array(
				'WorkshopSession.collection_id' => $workshop_id,
				'WorkshopSession.last_day >= CURDATE()'
		);
		$current_sessions = $this->findSessions($conditions);
		if (!$result_type) {
			return $current_sessions;
		} else {
			return $this->storageObject($result_type, $current_sessions);
		}
	}
	
	public function allSessions($workshop_id, $result_type = FALSE) {
		$conditions = array(
				'WorkshopSession.collection_id' => $workshop_id
		);
		$all_sessions = $this->findSessions($conditions);
		if (!$result_type) {
			return $current_sessions;
		} else {
			return $this->storageObject($result_type, $all_sessions);
		}
	}

}
?>