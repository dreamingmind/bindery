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
	
	/**
	 * Does the logged in or anonomous user have a cart 
	 * 
	 * @param $Session Component or Helper
	 * @return boolean
	 */
	public function cartExists($Session) {
		$userId = $Session->read('Auth.User.id');
			if (is_null($userId)) {
				$cart = $this->find('first', array('conditions' => array('phpsession_id' => $Session->id())));
			} else {
				$cart = $this->find('first', array('conditions' => array('user_id' => $userId)));
			}
			if (empty($cart)) {
				return FALSE;
			} else {
				return TRUE;
			}
	}
	
	/**
	 * Keep the Cart attached to the User
	 * 
	 * As the User navigates the site, the Session id may change 
	 * and their logged in status may change. Carts may be attached to 
	 * the Session or the User. This method will keep the proper 
	 * Cart items associated with the User as the site State changes
	 * https://github.com/dreamingmind/bindery/wiki/Shopping-Cart
	 * 
	 * @param object $Session Component or Helper
	 */
	public function maintain(SessionComponent $Session, $oldSession) {
		
		$userId = $Session->read('Auth.User.id');
		$itemsUser = array();
		
		$itemsAnon = $this->find('all', array(
			'conditions' => array(
				'phpsession_id' => $oldSession,
				'user_id' => ''
			),
			'fields' => array('id', 'phpsession_id', 'user_id'),
			'contain' => FALSE
		));
		dmDebug::logVars($this->getLastQuery(), 'anon find query for $userId='.$userId);

		if (!is_null($userId)) {
			dmDebug::logVars($userId, 'user id for query');
			$itemsUser = $this->find('all', array(
				'conditions' => array (
					'user_id' => $userId,
					'OR' => array('phpsession_id' => '', 'phpsession_id IS NULL')						
				),
				'fields' => array('id', 'phpsession_id', 'user_id'),
				'contain' => FALSE
			));
		dmDebug::logVars($this->getLastQuery(), 'user find query for $userId='.$userId);
		}
		
		dmDebug::logVars($itemsAnon, 'anon items');
		dmDebug::logVars($itemsUser, 'user items');

		$items = array_merge($itemsAnon, $itemsUser);

		if (!empty($items)) {
			dmDebug::logVars($items, 'items to transform');
	//		dmDebug::logVars($this->getLastQuery(), 'Cart->maintain find query for $userId='.$userId);
			if (is_null($userId)) {
				$i = Hash::insert($items, '{n}.Cart.phpsession_id', $Session->id());
				$items = Hash::insert($i, '{n}.Cart.user_id', '');
			} else {
				$i = Hash::insert($items, '{n}.Cart.phpsession_id', '');
				$items = Hash::insert($i, '{n}.Cart.user_id', $userId);
			}
			dmDebug::logVars($items, 'items to save');
			$this->saveMany($items);
		}
	}
	
	function getLastQuery()
    {
        $dbo = $this->getDatasource();
        $logs = $dbo->getLog();
        $lastLog = end($logs['log']);
        return $lastLog['query'];
    }
	/**
	 * 
	 * 
	 * @param object $Session Component or Helper
	 * @param boolean $deep Contain associated data or not
	 * @return type
	 */
	public function fetch($Session, $deep = FALSE) {
		$userId = $Session->read('Auth.User.id');
		
		$contain = FALSE;
		$conditions = array('user_id' => $userId);
		
		if ($deep) {
			$contain = array('User', 'Supplement');
		}
		if (is_null($userId)) {
			array('phpsession_id' => $Session->id());
		}
		
		$cart = $this->find('all', array(
				'conditions' => $conditions,
				'contain' => $contain
			));
		
		return $cart;
	}


	public function clear($sessionId) {
		
	}
	
}
