<?php
class Workshop extends AppModel {
	var $name = 'Workshop';
        var $useTable = 'collections';
//	var $validate = array(
//		'title' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'hours' => array(
//			'numeric' => array(
//				'rule' => array('numeric'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Session' => array(
			'className' => 'Session',
			'foreignKey' => 'collection_id',
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
         * @var array $upcoming_sessions sessions records, now and future plus related date data
         */
        var $upcoming_sessions = array();

        /**
         * @var array $previous_sessions sessions records, all workshops not in upcoming_sessions
         */
        var $previous_sessions = array();

        
        /**
         * @var array $workshops array of all workshop data (no related data) indexed by workshop_id
         */
        var $workshops = array();
        
        function __construct() {
            parent::__construct();
            $this->upcomingSessions();
            $this->getWorkshops();
            $this->previousSessions();
//            debug($this->workshops);die;
        }

        /**
         * Set the models $upcoming_session property
         * 
         * Sessions where last_day>=current date sorted ascending
         * Includes related date data
         */
        function upcomingSessions(){
            $this->upcoming_sessions = $this->Session->find('all', array(
                'conditions'=>'Session.last_day > CURDATE()',
                'order'=>'Session.first_day ASC',
//                'fields'=> array('workshop_id','title','cost','participants','first_day','last_day'),
                'contain'=>array('Date','Workshop')
            ));
        }
        
        /**
         * Set the models $workshops property
         * 
         * Pull all workshop data into an id indexed array. No related data
         */
        function getWorkshops() {
            $temp_workshops = $this->find('all',array(
                'conditions' => array(
                    'category' => 'workshops'),
                'recursive'=>0
                ));
            $this->workshops = array();
            foreach($temp_workshops as $val) {
                $this->workshops[$val['Workshop']['id']] = $val;
            }
        }
        
        /**
         * Set the models $previous_session property
         * 
         * Set $pervious_sessions to and id indexed array of workshops
         * that have no future session scheduled (no related data
         */
        function previousSessions(){
            $this->previous_sessions = $this->workshops;
            foreach($this->upcoming_sessions as $val) {
                unset($this->previous_sessions[$val['Workshop']['id']]);
            }
        }

}
?>