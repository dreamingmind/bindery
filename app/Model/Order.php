<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property User $User
 * @property Collection $Collection
 * @property OrderItem $OrderItem
 */
class Order extends AppModel {

public $useTale = 'orders';

public function beforeSave($options = array()) {
	parent::beforeSave($options);
}

public function afterSave($created) {
	parent::afterSave($created);
	if ($created) {
		$this->saveField('number', $this->getOrderNumber($this->id));
	}
}


// <editor-fold defaultstate="collapsed" desc="VALIDATION">
/**
				   * Validation rules
  *
			 * @var array
 */
	public $validate = array(
//		'number' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'shipid' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'billid' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'transactionid' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'state' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'invoice_number' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
	); // </editor-fold>


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
		'Collection' => array(
			'className' => 'Collection',
			'foreignKey' => 'collection_id',
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
		'OrderItem' => array(
			'className' => 'OrderItem',
			'foreignKey' => 'order_id',
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
	 * Return an order number
	 * 
	 * Given two values from the Order record
	 * return a unique order number
	 * YYMM-xxxx
	 * YY = last two year digits
	 * MM = two digit month
	 * xxxx = a base 19 number
	 * Base 19 has custom digit set, all caps
	 * 
	 * @param string $id The id of the created order
	 * @return string order number: YYMM-xxxx
	 */
	public function getOrderNumber($id) {
		//setup variables
		$this->id = $id;
		// based on id, but not simply decoded
		$seed = intval(($id + 53) * 1.1);
		$created = $this->field('created');
		if (!$seed || !$created) {
			return false;
		}
		$codedNumber = $this->getCodedNumber($seed, $created);
		return $codedNumber;
	}
	
    /**
     * Retrun an order number
     * 
     * Given two values from the Order record
     * return a unique order number
     * YYMM-xxxx
     * YY = last two year digits
     * MM = two digit month
     * xxxx = a base 19 number
     * Base 19 has custom digit set, all caps
     * 
     * @param int $seed The seed number from the Order record
     * @param string $created The creation date from the Order record
     * @return string order number: YYMM-xxxx
     */
    public function getCodedNumber($seed, $created) {
	// digits for our Base 19 number system
	$digit = array(
	    '0' => 'A', // 0
	    '1' => 'B', // 1
	    '2' => 'C', // 2
	    '3' => 'D', // 3
	    '4' => 'E', // 4
	    '5' => 'F', // 5
	    '6' => 'G', // 6
	    '7' => 'H', // 7
	    '8' => 'K', // 8
	    '9' => 'M', // 9
	    'a' => 'N', // 10
	    'b' => 'P', // 11
	    'c' => 'R', // 12
	    'd' => 'S', // 13
	    'e' => 'T', // 14
	    'f' => 'W', // 15
	    'g' => 'X', // 16
	    'h' => 'Y', // 17
	    'i' => 'Z'  // 18
	);
	$num = base_convert($seed, 10, 19);

       $jnum = str_split('000' . base_convert($seed, 10, 19));
       $num = '';
       for ($j = count($jnum) - 4; $j < count($jnum); $j++) {
	   $num .= $digit[$jnum[$j]];
       }
       return str_replace('-', '', substr($created, 2, 5)).'-' . $num;
    }
    
}
