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
        'ContentCollection',
        'Request'
    );
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

    /**
     * @var array $workshops_featured contains a member of workshops_all array
     * containing only the one determined to be the best workshop to feature
     */
    var $workshops_featured = false;

    /**
     * @var array $workshops_featured contains a member of workshops_all array
     * which are grouping records; they aren't workshops but are containers for related workshops
     */
    var $workshops_landing = false;

    function __construct() {
        parent::__construct();
        $this->workshopsAll();
    }

    /**
     * Set the models $upcoming_session property
     *
     * Sessions where last_day>=current date sorted ascending
     * Includes related date data
     */
    function workshopsAll() {
        $this->workshops_temp =
                $this->find('all', array(
            'conditions' => array(
                'Workshop.category_id' => $this->Category->categoryNI['workshop'],
                'Workshop.publish' => 1,
//				'OR' => array(
//					'Workshop.role' => 'workshop', // actual workshops
//					'Workshop.role' => 'landing' // catagorizing records to group workshops by theme (mirrors the nav menu sturcture)
//				)
            ),
            'order' => 'Workshop.heading',
            'fields' => array('id', 'heading', 'text', 'role', 'category_id', 'slug'),
            'contain' => array(
                'ContentCollection' => array(
                    'fields' => array(
                        'ContentCollection.content_id',
                        'ContentCollection.collection_id'
                    ),
                    'Content' => array(
                        'fields' => array(
                            'Content.id',
                            'Content.content',
                            'Content.image_id',
                            'Content.alt',
                            'Content.title',
                            'Content.heading',
                            'Content.slug'
                            ),
                        'Image' => array(
                            'fields' => array(
                                'Image.img_file',
                                'Image.id',
                                'Image.title',
                                'Image.alt'
                            )
                        )
                    ),
                    'Collection' => array(
                        'fields' => array(
                            'Collection.id',
                            'Collection.heading',
                            'Collection.slug',
                            'Collection.role'
                        )
                    )
                ),
                'Session' => array(
                    'fields' => array(
                        'Session.id',
                        'Session.collection_id',
                        'Session.cost',
                        'Session.participants',
                        'Session.first_day',
                        'Session.last_day',
                        'Session.registered'
                    ),
                    'Date' => array(
                        'fields' => array(
                            'Date.session_id',
                            'Date.date',
                            'Date.start_time',
                            'Date.end_time'
                        )
                    ),
                    'conditions' => array(
                        'Session.last_day >= CURDATE()'
                    )
                )
            )
            )
        );
//		debug($this->workshops_temp);
        $this->workshopsSetter();
    }

    function workshopsSetter() {
        foreach ($this->workshops_temp as $workshop) {
//			echo "<p>{$workshop['Workshop']['heading']}</p>";
            $this->workshops_all[$workshop['Workshop']['id']] = $workshop;
			if ($workshop['Workshop']['role'] == 'landing') {
//				echo "<p>Landing: {$workshop['Workshop']['heading']}</p>";
				$this->workshops_landing[$workshop['Workshop']['id']] = $workshop + $this->includeLandingPageChildPointers($workshop);
				continue;
			}
//             for workshops_potential find those sessions with null first days
            if (empty($workshop['Session'])) {
//				echo "<p>Potential: {$workshop['Workshop']['heading']}</p>";
                $this->workshops_potential[$workshop['Workshop']['id']] = $workshop;
//                 if there are no sessions, don't do the session loop
                continue;
            }
//             for workshops_now find those sessions with a first day of today OR those
//             sessions with a first day before today and a last day after or equal to today
            foreach ($workshop['Session'] as $session) {
                if ($session['first_day'] == date('Y-m-d', time())
                        OR
                        ($session['first_day'] < date('Y-m-d', time())
                        AND
                        $session['last_day'] >= date('Y-m-d', time()))
                ) {
//					echo "<p>Now: {$workshop['Workshop']['heading']}</p>";
                    $this->workshops_now[$workshop['Workshop']['id']] = $workshop;
//             for workshops_upcoming find those sessions with a first day after today
                } else if ($session['first_day'] > date('Y-m-d', time())) {
//					echo "<p>Upcoming: {$workshop['Workshop']['heading']}</p>";
                    $this->workshops_upcoming[$workshop['Workshop']['id']] = $workshop;
//                     if there is an upcoming session, no need to look for more
                    continue;
                }
            }
        }
    }
	
	/**
	 * Gather pointers to the workshops in this landing/theme
	 * 
	 * Landing pages describe themed groupings of workshops. When scanning all_workshops, 
	 * if we find a landing record, we will get pointers to the workshops gathered 
	 * into that theme. These groupings are made in the Navigator/Navline menu 
	 * setup right now. Bad coupling, but I have no solution yet.
	 * 
	 * Navigator (here called ThemedWorkshop) can only return a list of slugs of the articles. 
	 * We'll use those to back into our data set and get the id'd records we need
	 * 
	 * @param array $workshop The all_workshop data node (contains a ton of stuff, see workshopsAll())
	 */
	protected function includeLandingPageChildPointers($workshop) {
		$slugs = array_flip(Hash::extract($this->workshops_temp, '{n}.Workshop.slug'));
		$ids = Hash::extract($this->workshops_temp, '{n}.Workshop.id');
		$themed_group = array_merge($workshop, array('members' => array()));
		$ThemedWorkshop = ClassRegistry::init('ThemedWorkshop');
		$children = $ThemedWorkshop->childrenOfTheme($workshop['Workshop']['slug']);
		$themed_group = array();
		foreach ($children as $child) {
			$themed_group[] = $ids[$slugs[$child]];
			}			
		return array('Memebers' => $themed_group);
	}
	
	protected function workshopsUpcoming() {
        if (empty($this->workshops_upcoming)) {
            $this->workshopsAll();
        }
        return $this->workshops_upcoming;
    }

    protected function workshopsPotential() {
        if (empty($this->workshops_potential)) {
            $this->workshopsAll();
        }
        return $this->workshops_potential;
    }

    protected function workshopsNow() {
        if (empty($this->workshops_now)) {
            $this->workshopsAll();
        }
        return $this->workshops_now;
    }
    /**
     * returns the best workshop to feature and removes it from the master list it came from
     * 
     * We are going to look at the workshops found and determine which
     * is the best choice based upon the following criteria:
     * If there is one running today (now) use that one
     * If there are any upcoming workshops, use soonest one
     * If there are no now or upcoming workshops, use a random workshop from potential
     * Include the source of the feature for later array manipulation in workshops_featured[source]
     * 
     * @return array Complete workshop set, with both Collection (workshop itself) and related content, sesssions & dates and source
     */

    public function workshopsFeatured($refresh = false) {
        if ($refresh) {
            $this->workshopsAll();
        }
        if ($this->workshops_now) {
			// leave 'now' set in this case
            $this->workshops_featured = $this->workshops_now;
            $source='workshops_now';
        //  Else, pick off the first upcoming workshop
        } elseif ($this->workshops_upcoming) {
			// the featured workshop will be removed from 'upcoming' in this case
            $this->workshops_featured = array_slice($this->workshops_upcoming,0,1,true);
            $source='workshops_upcoming';
        //  Else, choose a random potential workshop
        } elseif ($this->workshops_potential) {
			// we'll need to prevent a dup entry in potential
            $featurekey = array_rand($this->workshops_potential);
            $this->workshops_featured = $this->workshops_potential[$featurekey];
			unset($this->workshops_potential[$featurekey]);
            $source='workshops_potential';
        } else {
            $this->workshops_featured = false;
        }
        $this->workshops_featured['source']=$source;
        return $this->workshops_featured;
    }

	/**
	 * Remove the featured item from the list of workshops so we don't duplicate showing it
	 * 
	 * But is this working right?
	 * 
	 */
//    function removeFeaturedDuplicate() {
//        if (isset($this->Workshop->workshops_featured['source'])){
//            $source=$this->Workshop->workshops_featured['source'];
//            unset($this->Workshop->workshops_featured['source']);
////            debug(array_keys($this->Workshop->workshops_featured));
//            $key=array_keys($this->Workshop->workshops_featured);
////            debug($key[0]);debug($source);
//            switch ($source){
//                case "workshops_now":
//                    unset($this->Workshop->workshops_now[$key[0]]);
//                break;
//                case "workshops_potential":                    
//                    unset($this->Workshop->workshops_potential[$key[0]]);
//                break;
//                case "workshops upcoming":
//                    unset($this->Workshop->workshops_upcoming[$key[0]]);
//                break;
//            }
//        }
//        
//    }


}

?>