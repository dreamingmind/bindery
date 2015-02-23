<?php
App::uses('JsonStorageObject', 'Model/StorageObjects');
App::uses('ArrayStorageObject', 'Model/StorageObjects');
App::uses('WorkshopSessions', 'Model/StorageObjects');

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
	 * Find past sessions for workshop $workshop_id return it in the form requested
	 * 
	 * If no result_type is specificied, a standard cake array will be returned. 
	 * Available types are the StorageObject types Json, Array
	 * 
	 * @param string $workshop_id
	 * @param string $result_type
	 * @return mixed
	 */
	public function expiredSessions($workshop_id, $result_type = FALSE) {
		$conditions = array(
				'WorkshopSession.collection_id' => $workshop_id,
				'WorkshopSession.last_day < CURDATE()'
		);
		$expired_sessions = $this->findSessions($conditions);
		if (!$result_type) {
			return $expired_sessions;
		} else {
			return $this->makeStorageObject($result_type, $expired_sessions);
		}
	}
	
	/**
	 * Find current sessions for workshop $workshop_id return it in the form requested
	 * 
	 * Will include today's sessions
	 * 
	 * If no result_type is specificied, a standard cake array will be returned. 
	 * Available types are the StorageObject types Json, Array
	 * 
	 * @param string $workshop_id
	 * @param string $result_type
	 * @return mixed
	 */
	public function currentSessions($workshop_id, $result_type = FALSE) {
		$conditions = array(
				'WorkshopSession.collection_id' => $workshop_id,
				'WorkshopSession.last_day >= CURDATE()'
		);
		$current_sessions = $this->findSessions($conditions);
		if (!$result_type) {
			return $current_sessions;
		} else {
			return $this->makeStorageObject($result_type, $current_sessions);
		}
	}
	
	/**
	 * Find all past, present and future session for workshop $workshop_id return it in the form requested
	 * 
	 * If no result_type is specificied, a standard cake array will be returned. 
	 * Available types are the StorageObject types Json, Array
	 * 
	 * @param string $workshop_id
	 * @param string $result_type
	 * @return mixed
	 */
	public function allSessions($workshop_id, $result_type = FALSE) {
		$conditions = array(
				'WorkshopSession.collection_id' => $workshop_id
		);
		$all_sessions = $this->findSessions($conditions);
		if (!$result_type) {
			return $all_sessions;
		} else {
			return $this->makeStorageObject($result_type, $all_sessions);
		}
	}

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
		return $sessions;
	}
	
	/**
	 * Convert a standard cake array into an array or json storage object
	 * 
	 * json structure
	 * [{n}]
	 *	obj	->session_fieldnames->values
	 *		  ...
	 *		->{n}->obj->date_fieldnames->values
	 *		  ...
	 * ...
	 * 
	 * array structure
	 * [{n}]
	 *	obj	->[session_fieldnames]=>values
	 *		  ...
	 *		  [n]=>obj->[date_fieldnames]=>values
	 *					...
	 *		  ...
	 * ...
	 * 
	 * @param type $result_type
	 * @param type $session_data
	 * @return \ArrayStorageObject
	 */
	protected function makeStorageObject($result_type, $session_data) {
		$sessions = array();
		$index = 0;
		switch ($result_type) {
			case 'Json':
			case 'json':
			case 'JSON':
				foreach ($session_data as $session) {
					$json_string = json_encode($session['WorkshopSession']);
					$sessions[$index] = new JsonStorageObject($json_string);
					$date_index = 0;
					foreach ($session['Date'] as $date) {
						$sessions[$index]->write("$date_index", new JsonStorageObject(json_encode($date)));
						$date_index++;
					}
					$index++;
				}
				break;
			case 'Array':
			case 'array':
			case 'ARRAY':
				foreach ($session_data as $session) {
					$sessions[$index] = new ArrayStorageObject($session['WorkshopSession']);
					$date_index = 0;
					foreach ($session['Date'] as $date) {
						$sessions[$index]->write("$date_index", new ArrayStorageObject($date));
						$date_index++;
					}
					$index++;
				}
				break;

			default:
				return $session_data;
				break;
		}
		return new WorkshopSessions($sessions);
//		return $sessions;
	}
	
}
?>