<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.model
 */
/**
 * Content Model
 * 
 * @package       bindery
 * @subpackage    bindery.model
 * 
*/
class Workshop extends AppModel {
	var $name = 'Workshop';
        var $useTable = 'collections';
        var $belongsTo = 'Category';
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
		),
                'ContentCollection' => array(
                'className' => 'ContentCollection',
                'foreignKey' => 'content_id'
            ),
                'Request'
	);
     

//        /**
//         * @var array $upcoming_sessions sessions records, now and future plus related date data
//         */
//        var $upcoming_sessions = array();
//
//        /**
//         * @var array $previous_sessions sessions records, all workshops not in upcoming_sessions
//         */
//        var $previous_sessions = array();
//        /**
//         * @var array $workshops array of all workshop data (no related data) indexed by workshop_id
//         */
//        var $workshops = array();
        /**
         * @var array $workshops_all array of all workshop data
         * contains all related content and images
         * contains current and future sessions and dates
         */
        var $workshops_all = false;
        /**
         * @var array $workshops_potential array of workshops_all that didn't return sessions
         */
        var $workshops_potential = false;
        /**
         * @var array $workshops_upcoming contains the members of workshops_all array
         * containing only those with sessions with dates in the future
         */
        var $workshops_upcoming = false;
        /**
         * @var array $workshops_now contains the members of workshops_all array
         * containing only those with sessions where the date is today
         */
        var $workshops_now = false;


        
        function __construct() {
            parent::__construct();
//            $this->upcomingSessions();
//            $this->getWorkshops();
//            $this->previousSessions();
            $this->workshopsAll();
//            debug($this->workshops);die;
        }

//        /**
//         * Set the models $upcoming_session property
//         * 
//         * Sessions where last_day>=current date sorted ascending
//         * Includes related date data
//         */
//        function upcomingSessions(){
//            $this->upcoming_sessions = $this->Session->find('all', array(
//                'conditions'=>'Session.last_day > CURDATE()',
//                'order'=>'Session.first_day ASC',
////                'fields'=> array('workshop_id','title','cost','participants','first_day','last_day'),
//                'contain'=>array('Date','Workshop')
//            ));
//        }
//        
//        /**
//         * Set the models $workshops property
//         * 
//         * Pull all workshop data into an id indexed array. No related data
//         */
//        function getWorkshops() {
//            $temp_workshops = $this->find('all',array(
//                'conditions' => array(
//                    'category_id' => $this->Category->categoryNI['workshop']),
//                'recursive'=>0
//                ));
//            $this->workshops = array();
//            foreach($temp_workshops as $val) {
//                $this->workshops[$val['Workshop']['id']] = $val;
//            }
//        }
//        
//        /**
//         * Set the models $previous_session property
//         * 
//         * Set $pervious_sessions to and id indexed array of workshops
//         * that have no future session scheduled (no related data
//         */
//        function previousSessions(){
//            $this->previous_sessions = $this->workshops;
//            foreach($this->upcoming_sessions as $val) {
//                unset($this->previous_sessions[$val['Workshop']['id']]);
//            }
//        }
        /**
         * Set the models $upcoming_session property
         * 
         * Sessions where last_day>=current date sorted ascending
         * Includes related date data
         */
        function workshopsAll(){
            $this->workshops_all=
            $this->find('all', array(
                'conditions'=>array(
                    'Workshop.category_id'=>$this->Category->categoryNI['workshop'],
                    'Workshop.publish'=>1
                ),
                'order'=>'Workshop.heading',
                'fields'=> array('id','heading','text','role','category_id','slug'),
                'contain'=>array(
                    'ContentCollection'=>array(
                        'fields'=>array(
                            'ContentCollection.content_id',
                            'ContentCollection.collection_id'
                            ),
                        'Content'=>array(
                            'fields'=>array(
                                'Content.id',
                                'Content.content',
                                'Content.image_id',
                                'Content.alt',
                                'Content.title',
                                'Content.heading',
                                'Content.slug'//,
//                                'Content.publish'
                             ),
                             'Image'=>array(
                                'fields'=>array(
                                    'Image.img_file',
                                    'Image.id',
                                    'Image.title',
                                    'Image.alt'
                                )
//                            ),
//                            'conditions'=>array(
//                                'Content.publish'=>1
                            )
                        ),
                        'Collection'=>array(
                            'fields'=>array(
                                'Collection.id',
                                'Collection.heading',
                                'Collection.slug'
                            )
                        )
                    ),
                    'Session'=>array(
                        'fields'=>array(
                            'Session.id',
                            'Session.collection_id',
                            'Session.cost',
                            'Session.participants',
                            'Session.first_day',
                            'Session.last_day',
                            'Session.registered'
                        ),
                        'Date'=>array(
                            'fields'=>array(
                                'Date.session_id',
                                'Date.date',
                                'Date.start_time',
                                'Date.end_time'
                            )
                        ),
                        'conditions'=>array(
                            'Session.last_day >= CURDATE()'
                        )
                    )
                )
            )
        );
        $this->workshopsSetter();
//       debug(getallheaders());
//       debug($this->workshops_now);
//       debug($this->workshops_upcoming);
//       debug($this->workshops_potential);
//       debug($this->workshops_all);
//       die;
       }
       function workshopsSetter (){
           foreach ($this->workshops_all as $workshop){
//             for workshops_potential find those sessions with null first days
               if(empty($workshop['Session'])){
                   $this->workshops_potential[$workshop['Workshop']['id']]=$workshop;
//                 if there are no sessions, don't do the session loop
                   continue;
               }
//             for workshops_now find those sessions with a first day of today OR those
//             sessions with a first day before today and a last day after or equal to today
               foreach ($workshop['Session'] as $session){
                   if ($session['first_day'] == date('Y-m-d',time())
                       OR
                       ($session['first_day']< date('Y-m-d',time())
                       AND
                       $session['last_day']>= date('Y-m-d',time()))
                       ){
                   $this->workshops_now[$workshop['Workshop']['id']]=$workshop;
//             for workshops_upcoming find those sessions with a first day after today                   
                   }else if($session['first_day'] > date('Y-m-d',time())){
                       $this->workshops_upcoming[$workshop['Workshop']['id']]=$workshop;
//                     if there is an upcoming session, no need to look for more
                       continue;
                   }
               
               }
           }
       }
       function workshopsUpcoming (){
                   if (empty($this->workshops_upcoming)){
                       $this->workshopsAll();
                   }
                   return $this->workshops_upcoming;
       }
      function workshopsPotential (){
                   if (empty($this->workshops_potential)){
                       $this->workshopsAll();
                   }
                   return $this->workshops_potential;
       }
       function workshopsNow (){
                   if (empty($this->workshops_now)){
                       $this->workshopsAll();
                   }
                   return $this->workshops_now;
       }

}
?>