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
//                'Workshop.role' => 'workshop' // REM this to see the LANDING records too ========================================!!!!!!!!!!!!!!!!!!
				// Or, an alternative is to do the same thing as on the entry page. Throw up a Feature and list the rest
				// I like that plan because making new sections won't require making new content
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
            $this->workshops_all[$workshop['Workshop']['id']] = $workshop;
//             for workshops_potential find those sessions with null first days
            if (empty($workshop['Session'])) {
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
                    $this->workshops_now[$workshop['Workshop']['id']] = $workshop;
//             for workshops_upcoming find those sessions with a first day after today
                } else if ($session['first_day'] > date('Y-m-d', time())) {
                    $this->workshops_upcoming[$workshop['Workshop']['id']] = $workshop;
//                     if there is an upcoming session, no need to look for more
                    continue;
                }
            }
        }
    }

    function workshopsUpcoming() {
        if (empty($this->workshops_upcoming)) {
            $this->workshopsAll();
        }
        return $this->workshops_upcoming;
    }

    function workshopsPotential() {
        if (empty($this->workshops_potential)) {
            $this->workshopsAll();
        }
        return $this->workshops_potential;
    }

    function workshopsNow() {
        if (empty($this->workshops_now)) {
            $this->workshopsAll();
        }
        return $this->workshops_now;
    }
    /**
     * returns the best workshop to feature
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

    function workshopsFeatured($refresh = false) {
        if ($refresh) {
            $this->workshopsAll();
        }
        if ($this->workshops_now) {
            $this->workshops_featured = $this->workshops_now;
            $source='workshops_now';
        //  Else, pick off the first upcoming workshop
        } elseif ($this->workshops_upcoming) {
            $this->workshops_featured = array_slice($this->workshops_upcoming,0,1,true);
            $source='workshops_upcoming';
        //  Else, choose a random potential workshop
        } elseif ($this->workshops_potential) {
            $featurekey = array_rand($this->workshops_potential);
            $this->workshops_featured = $this->workshops_potential[$featurekey];
            $source='workshops_potential';
        } else {
            $this->workshops_featured = false;
        }
        $this->workshops_featured['source']=$source;
        return $this->workshops_featured;
    }

}

?>