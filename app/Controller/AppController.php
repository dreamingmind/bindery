<?php

/**
 * Short description for file.
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @modifiedby    $LastChangedBy$
 * @lastmodified  $Date$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::uses('Controller', 'Controller');
App::uses('Biscuit', 'Lib');
/**
 * Short description for class.
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {

    var $components = array(
		'Cookie',
		'DebugKit.Toolbar',
        'Acl' => array(
        ),
        'Auth' => array(
            'loginAction' => array(
                'plugin' => null,
                'controller' => 'users',
                'action' => 'login'
            ),
            'logoutRedirect' => array(
                'plugin' => null,
                'controller' => 'pages',
				'action' => 'home'
            ),
            'loginRedirect' => array(
                'plugin' => null,
                'controller' => 'pages',
				'action' => 'home'
            ),
			'authenticate' => array(
				'Form'
			),
            'loginError' => "This message shows up when the wrong credentials are used",
            'authError' => "Please log in to proceed.",
            'authorize' => 'controller',
            //'authorize' => 'actions',
            //'authorize' => 'crud',
            'allowedActions' => array('display')
        ),
		'Markdown.Markdown',
        'Session',
        'Email'
    );
    var $helpers = array('Menu', 'Html', 'Form', 'Js', 'Session', 'GalNav', 'Paginator', 'Fieldset', 'Markdown.Markdown', 'Text', 'Number', 'PaypalIpn.Paypal');
    var $uses = array('Navigator', 'User', 'Account', 'Cart');
    var $record = array();
    var $css = array();

    /**
     * @var array company display strings
     */
    var $company = '';

    /**
     * @var string Username of the logged in user
     */
    var $username = false;

    /**
     * @var string Group the logged in user belongs to
     */
    var $usergroup = false;

    /**
     * @var integer Id of the logged in user
     */
    var $userid = false;

    /**
     * @var string Email address of the logged in user
     */
    var $useremail = false;

    /**
     * @var string Active status of the logged in user
     */
    var $useractive = false;

    /**
     * @var array map account 'group' values to thier group name
     */
    var $groupnames = array('0' => 'Guest', '1' => 'administrator', '2' => 'manager', '3' => 'user');

    /**
     * @var integer $firstYear The first year of archive Content/Image data for Advanced Search
     */
    var $firstYear = 2012;

    /**
     * @var array $month Selection list of months for Advanced Search
     */
    var $month = array(
        '00' => 'Select a Month',
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    );

    /**
     * @var array $season Selection list of seasons for Advanced Search
     */
    var $season = array(
        '0' => 'Select',
        '12-02' => 'Winter',
        '03-05' => 'Spring',
        '06-08' => 'Summer',
        '09-11' => 'Autumn',
        '01-02' => 'Valentine\'s',
        '10-12' => 'Winter Holiday'
    );

    /**
     * @var array $week Selection list of relative weeks for Advanced Search
     */
    var $week = array(
        '0' => 'Select',
        '1' => 'This week',
        '2' => 'Last week',
        '2.5' => 'Since last week',
        '3' => 'Two weeks ago',
        '3.5' => 'Since two weeks ago',
        '4' => 'Three weeks ago',
        '4.5' => 'Since three weeks ago',
        '5' => 'Four weeks ago',
        '5.5' => 'Since four weeks ago'
    );
    
    var $scripts = '';
	
	public $Biscuit;
			
    function beforeFilter() {
		parent::beforeFilter();
		
		// If the user has a cookie and it doesn't match the current Session id, it means 
		// they've been here before and may have old Cart items linked to the previous Session. 
		// We'll move those cart items to the current sesion if they exist.
		
		// If cookies aren't allowed, we'll send a Flash message the first time we discover the fact
		
		// If a Session doesn't exist, one will be created
		
		// Logging in changes the Session id also, and would leave an orphan Cart, 
		// but we take care of that problem in users->login()
		$this->Biscuit = new Biscuit($this);
//		echo 'cookie:'.$this->Biscuit->storedSessionId().' | session:'.$this->Session->id();
		
		if ($this->Biscuit->cookiesAllowed()) {
//			dmDebug::ddd($this->Biscuit->currentSessionId(), 'current session');
//			dmDebug::ddd($this->Session->read('Auth.User.id'), 'user id');
			
			if ($this->Biscuit->storedSessionId() != NULL && !$this->Biscuit->sameSession()) {
				
				$this->Cart->maintain($this->Session, $this->Biscuit->storedSessionId());
				$this->Biscuit->saveSessionId();
			}
			$this->set('cart', $this->Cart->fetch($this->Session));
		}

		$this->layout = 'noThumbnailPage';

		// These things should happen regardless of login or permission
        $this->initCompany(); //set company contact strings in an array
        Configure::load('caveat');
        $this->caveat = Configure::read('caveat');
        $this->set('caveat', $this->caveat);

        $this->initAccount(); //set all properties describing the logged in user (or not)
        $this->mainNavigation(); //get the account appropriate full, potential menu record set
        $this->splashContent = $this->pullSplash();
        $this->Auth->logoutRedirect = $this->referer('bindery', TRUE);
        $this->Email->smtpOptions = array(
            'port' => '465',
            'host' => 'ssl://mail.dreamingmind.com',
            'username' => 'ddrake@dreamingmind.com',
            'password' => 'hU_9d+4F'
        );
        $this->Email->delivery = 'smtp';
//        $this->Auth->loginRedirect = $this->referer('bindery', TRUE);
        //debug();
        // Time to see if this user can see the requested page
        $this->css = array('basic', 'advanced-search', 'search_links');
        if ($this->params['action'] == 'blog') {
            $this->css[] = 'blog';
        } else {
            $this->css[] = 'new4';
        }
		$this->css[] = 'cart';

        $this->scripts = array('jquery-1.10.0', 'jquery.fix.clone', 'app', 'cart');
		
//        $this->set('imagePath', 
//"\r//app_controller beforeFilter\r
//var imagePath = '". str_replace($_SERVER['DOCUMENT_ROOT'], '', IMAGES) ."';\r
//var webroot = '". str_replace(array('app/', $_SERVER['DOCUMENT_ROOT']), '', APP) ."';\r"); 

        //    echo $html->css('basic');
//    echo $html->css('new4.css');
//    echo $html->css('advanced-search');
//    echo $html->css('search_links');
    }

	function beforeRender() {
        parent::beforeRender();
//        debug($this->css);
        $this->set('css', $this->css);

        if ($this->layout === 'thumbnailPage') {
            $this->scripts = array_merge($this->scripts, array('manage_thumbnails', 'jumpbox', 'adjust_markdown', 'app'));
            if ($this->params['action'] === 'gallery') {
                $this->scripts[] = 'edit_exhibit';
            } elseif ($this->params['action'] === 'newsfeed') {
                $this->scripts[] = 'edit_dispatch';
            } elseif ($this->params['action'] === 'art') {
                $this->scripts = array_merge($this->scripts, array('art', 'blog_image_zoom', 'edit_dispatch'));
            }
        } elseif ($this->layout === 'noThumbnailPage') {
            $this->scripts[] = 'supplement_defaults';
            if ($this->params['action'] === 'art') {
                $this->scripts = array_merge($this->scripts, array('art', 'blog_image_zoom', 'adjust_markdown', 'edit_dispatch'));
            } elseif ($this->params['action'] === 'change_collection') {
                $this->scripts[] = 'change_collection';
            } elseif ($this->params['controller'] === 'workshops') {
                $this->scripts[] = 'workshop';
                if ($this->params['action'] === 'detail') {
                    $this->scripts = array_merge($this->scripts, array('blog_image_zoom', 'adjust_markdown', 'edit_dispatch'));
                }
            } elseif ($this->params['controller'] === 'catalogs') {
                $this->scripts[] = 'catalog';
            }
        } elseif ($this->layout === 'blog_layout') {
            $this->scripts = array_merge($this->scripts, array('blog_menu', 'blog_image_zoom', 'adjust_markdown', 'edit_dispatch'));
        }

        $this->set('scripts', $this->scripts);
    }

    function initAccount() {
//        debug($this->Auth->user());
//        debug($this->Auth);
        if ($this->Auth->user() != null) {
//            debug('in');
            $this->useractive = $userdata['useractive'] = $this->Auth->user('active');
            $this->username = $userdata['username'] = $this->Auth->user('username');
            $this->usergroupid = $userdata['usergroupid'] = $this->Auth->user('group_id');
            $this->usergroup = $userdata['usergroup'] = $this->groupnames[$this->Auth->user('group_id')];
            $this->userid = $userdata['userid'] = $this->Auth->user('id');
            $this->useremail = $userdata['useremail'] = $this->Auth->user('email');
            $userdata['userdata'] = $this->Auth->user();
//			debug($userdata['userdata']);
//            $userdata['userdata'] = $userdata['userdata']['User']; // compress out the extra 'User' index level
            $this->set($userdata);
            $this->User->setAuthorizedUser($this->Auth->user()); //move this data into User properties for use in the model
            //}
            //debug($userdata, true);
//            $this->set('authedUser', true);
//            if (!$this->Auth->user('active')) {
//                $this->Session->setFlash('Your account has been deactivated');
//                // ******* TO DO **********
//                // pull a record explaining why I've deactivated the account
//                $this->set('authedUser', false);
//                $this->set('authedLevel', false);
//            }
//            if ($this->viewVars['authedUser']){
            $this->record = $this->User->findById($this->Auth->user('id'));
//                $this->set('authedUser', $this->Auth->user());
//                $this->set('authedLevel', $this->record['Group']['name']);
//            }
//        } else {
//            $this->set('authedUser', false);
//            $this->set('authedLevel', false);
        } else {
            $this->set('userdata', false);
            $this->User->setAuthorizedUser(false);
        }
    }

    /**
     * Return URL-Friendly string slug
     * @param string $string
     * @return string
     */
    function slug($string) {
        //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
        $string = strtolower($string);
        //Strip any unwanted characters
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    /**
     * Initialize Company description strings
     *
     * Read in an array of basic company contact data as
     * a controller property and a viewVar
     *
     * name, bindery
     * phone, dotphone
     * tollree, dottollfree
     * fax, dotfax
     * email, url
     * aim, jabber
     */
    function initCompany() {
        Configure::load('company');
        $this->company = Configure::read('company');
        $this->company['workshopSignature'] =
                <<< SIG

{$this->company['firstName']} {$this->company['lastName']}
{$this->company['businessName']}
{$this->company['slogan']}

{$this->company['phone']}
{$this->company['email']}
{$this->company['siteURL']}
{$this->company['workshopURL']}
SIG;

        $this->company['fullSignature'] =
                <<< SIG

{$this->company['firstName']} {$this->company['lastName']}
{$this->company['businessName']}
{$this->company['slogan']}

{$this->company['phone']}
{$this->company['email']}

{$this->company['siteURL']}
{$this->company['blogURL']}
{$this->company['productURL']}
{$this->company['workshopURL']}
{$this->company['artURL']}
SIG;
        $this->set('company', $this->company);
    }

    /**
     * Pull Splash Page content if appropriate
     *
     * Negative indicators:
     *  page controller
     *  named or passed params
     * @todo this is non-functional and being obsoleted in the 12/11 restructure. Delete when complete
     */
    function pullSplash() {
        // look for splash page content
        if ((count($this->params['named']) + count($this->params['pass'])) > 0
                || $this->params['controller'] === 'pages') {
            return false;
        }
        // if named or passed params are present, we're not in
        // a top level page that might have a splash page
        // explode the url and search for Content. Last one is the splash content.
        // Search from the back!!
//		debug($this->params);
//        $routes = explode(DS, $this->request->url);
        $routes = explode(DS, $this->request->url);
        $this->splashRoute = $routes[count($routes) - 1];
    }

    /**
     * Read the proper menus for this user
     *
     * Read the menu appropriate to an admin, manager, registered user or guest
     */
    function mainNavigation() {
        $conditions = array('Navigator.publish' => 1);
        $access = 0;

        if ($this->username) {
            $conditions['OR'] = array(
                array('Navigator.account' => '0'),
                array('Navigator.account >=' => $this->usergroupid));
            // User account $find_params['conditions'] = array("Navigator.account = '0' OR Navigator.account = '3'");
            $access = $this->usergroupid;
        } else {
            $conditions['Navigator.account'] = '0';
        }
//        debug($conditions);die;
//        debug($conditions);die;
        /**
         * This is the find for the nested navigation menu data set.
         * */
        if (!($group = Cache::read('group' . $access, 'default'))) {
//			debug('write group cache');
            $group = $this->Navigator->generatetreegrouped($conditions, null, '/Navline', '{n}.Navigator.parent_id', 1);
            Cache::write('group' . $access, $group, 'default');
        }
//		debug('if no "write group cache" above, then this was read');


        $this->set('group', $group);
    }

    function isAuthorized() {
        $id = $this->Account->findByUsername($this->username, array('fields' => 'id'));
        //debug ($this->record);
        if ($this->record['Group']['name'] == 'Administrator') {
            //$this->set('authed','Auth logic: Administrator');
            return true;
        } elseif ($this->params['action'] == 'logout' ||
                $this->params['action'] == 'login' ||
                $this->params['action'] == 'register') {
            //$this->set('authed','Auth logic: logout/login/register');
            return true;
        } elseif ($this->Acl->check($this->Auth->user(), $this->params['controller'] . '/' . $this->params['action'])) {
            //if ($this->Acl->check('dreamingmind', $this->params['controller'])) {
            //$this->set('authed','Auth logic: authedLevel/params');
            return true;
        } elseif ($this->Acl->check(
                        $this->usergroup . "/" . $this->username . "::" . $this->userid, "UserRecord/" . $this->username . "::" . $this->userid)) { // this same/same comparison is not good
            //$id = $this->User->id;
//                if () {
            return true; //check for authorized user to user record
//                } else {
//                    //return $this->Session->setFlash("failed user check");
//                }
            // possibly a function to do all user account checks
        } else {
            debug($this->Auth->user());
//                $id = $this->Account->findByUsername($this->viewVars['authedUser']['User']['username'],array('fields'=>'id'));
//                $r = "user/".$this->viewVars['authedUser']['User']['username']."::".$id['Account']['id'];
//                $c = "UserRecord/".$this->viewVars['authedUser']['User']['username']."::".$this->params['pass'][0];
//                debug($r);
//                debug($c);
//                debug($this->params['pass'][0]);
//                debug($id);
            return false;
        }
    }

    /**
     * Check to see if any actual search data was sent in the post
     *
     * The empty form must return only the values ' ', 'search', or '0'
     * And the live form must provide at least one character beyond this set
     *
     * @return boolean True or False
     */
    function verifySearchData($data) {
        unset($data['controller']);
        unset($data['action']);
        $pattern = array('/search/i', '/ /', '/0/');
        $test = preg_replace($pattern, '', implode($this->postConditions($data)));
        if (empty($test)) {
            $this->Session->delete('qualityConditions');
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the first day of the week contain $day
     *
     * This can have a boundary problem if today is Sunday. No biggy for this app though
     * @param unixtime $day A day if provided or today
     * @return unixtime Sunday of the week containing $day
     */
    function firstOfWeek($day = null) {
        if ($day == null) {
            $day = time();
        }
        return strtotime('previous sunday', $day);
    }

    /**
     * Get the last day of the week containing $day
     *
     * This can have a boundary problem if today is Saturday. No biggy for his app though
     * @param unixtime $day A day if provided or today
     * @return unixtime Saturday of the week containing $day
     */
    function lastOfWeek($day = null) {
        if ($day == null) {
            $day = time();
        }
        return strtotime('next saturday', $day);
    }

    /**
     * Get the start/end dates of the specified week in the past
     *
     * Returns both sql and unix timestamps for the range
     * Array
     *  [start] => Array
     *      ['sql'] => 2013-03-14
     *      ['unix'] => 1362124799
     *  [end] => Array
     *      ['sql'] => 2013-03-14
     *      ['unix'] => 1362124799
     *
     * @param integer $ago Number of weeks prior to this one
     * @return array First and last day of week for specified week
     */
    function xWeeksAgo($ago = 0) {
        $base_day = time() - ($ago * 604800); // (7 * 24 * 60 * 60);
        $start = $this->firstOfWeek($base_day);
        $end = $start + 604800;
        $range = array(
            'start' => array(
                'sql' => date('Y-m-d', $start),
                'unix' => $start
            ),
            'end' => array(
                'sql' => date('Y-m-d', $end),
                'unix' => $end
            )
        );
        return $range;
    }

    /**
     * Get the start/end dates of the range, start of week $day to end of this week
     *
     * Returns both sql and unix timestamps for the range
     * Array
     *  [start] => Array
     *      ['sql'] => 2013-03-14
     *      ['unix'] => 1362124799
     *  [end] => Array
     *      ['sql'] => 2013-03-14
     *      ['unix'] => 1362124799
     *
     * @param integer $ago Number of weeks prior to this one
     * @return array First day of past week and last day of this week
     */
    function sinceXWeeksAgo($ago = 0) {
        $base_day = time() - ($ago * 604800); // (7 * 24 * 60 * 60);
        $start = $this->firstOfWeek($base_day);
        $end = $this->lastOfWeek(time());
        $range = array(
            'start' => array(
                'sql' => date('Y-m-d', $start),
                'unix' => $start
            ),
            'end' => array(
                'sql' => date('Y-m-d', $end),
                'unix' => $end
            )
        );
        return $range;
    }

    /**
     * Get the start/end dates of the month containing $day
     *
     * Returns both sql and unix timestamps for the range
     * Array
     *  [start] => Array
     *      ['sql'] => 2013-03-01
     *      ['unix'] => 1362124799
     *  [end] => Array
     *      ['sql'] => 2013-03-31
     *      ['unix'] => 1362124799
     *
     * @param unixtime $day A day in the month to range
     * @return array First and last day of specified month
     */
    function monthSpan($day = null) {
        if ($day == null) {
            $day = time();
        }
        $start = strtotime(date('Y-m-01', $day));
        $end = strtotime(date('Y-m-t', $day));
        $range = array(
            'start' => array(
                'sql' => date('Y-m-d', $start),
                'unix' => $start
            ),
            'end' => array(
                'sql' => date('Y-m-d', $end),
                'unix' => $end
            )
        );
        return $range;
    }

    /**
     * Get the start/end datees of the year containing $day
     *
     * Returns both sql and unix timestamps for the range
     * Array
     *  [start] => Array
     *      ['sql'] => 2013-01-01
     *      ['unix'] => 1362124799
     *  [end] => Array
     *      ['sql'] => 2013-12-31
     *      ['unix'] => 1362124799
     *
     * @param unixtime $day A day in the year to range
     * @return array First and last day of specified year
     */
    function yearSpan($day = null) {
        if ($day == null) {
            $day = time();
        }
        $start = strtotime(date('Y-01-01', $day));
        $end = strtotime(date('Y-12-31', $day));
        $range = array(
            'start' => array(
                'sql' => date('Y-m-d', $start),
                'unix' => $start
            ),
            'end' => array(
                'sql' => date('Y-m-d', $end),
                'unix' => $end
            )
        );
        return $range;
    }

    /**
     * If Standard input is present, make a 'condition' for a search
     *
     * As Standard (simple) search tries:
     *  LIKE Content.heading
     *  OR
     *  LIKE Content.content
     *  OR
     *  LIKE Image.alt
     *
     * condition stored in $this->qualityCondition
     */
    function buildStandardSearchConditions() {
        if ($this->data['Standard']['searchInput'] != ' Search') {
            // Build standard query
            $likeMe = "%{$this->data['Standard']['searchInput']}%";
            $this->qualityConditions = array(
                'OR' => array(
                    'Content.heading LIKE' => $likeMe,
                    'Content.content LIKE' => $likeMe,
                    'Image.alt LIKE' => $likeMe
                )
            );
        }
    }

    /**
     * If Advanced text input is present, make a 'condition' for a search
     *
     * An Advanced search tries LIKE on the field of the same name
     * as the POSTED input. Multiple inputs are OR'd
     *
     * condition stored in $this->qualityCondition
     */
    function buildAdvancedTextSearchConditions() {
        $advancedTextConditions = false;

        // Assemble text conditions if they exist
        $advancedTextInput = array(
            'Content' => $this->data['Content'],
            'Image' => $this->data['Image']
        );
        foreach ($advancedTextInput as $model => $search) {
            foreach ($search as $field => $input) {
                $input = trim($input);
                if (!empty($input)) {
                    $advancedTextConditions["$model.$field LIKE"] = "%$input%";
                }
            }
        }
        return $advancedTextConditions;
    }

    /**
     * If Advanced date input is present, make a 'condition' for a search
     *
     * A date range will OR on:
     *  Content.modified
     *  Image.modified
     *  Image.date (the image files exif date)
     *
     * Possible ranges, one of these:
     *  Records in YEAR yyyy
     *  Records in MONTH-YEAR mm-yyyy
     *  Records in MONTH (mm of every yyyy in the data)
     *  Records in 1 week (this week through 4 weeks ago)
     *  Records in span from x weeks ago to end of this week
     *
     * @return array The array of OR condions, all date range searches
     */
    function buildAdvancedDateSearchConditions() {
        $advancedDateCondtions = false;
        if ($this->data['DateRange']['month'] != 0 || $this->data['DateRange']['year'] != 0) {
            // some form of month/year request
            if ($this->data['DateRange']['year'] == 0) {
                // month only request
                $advancedDateCondtions = array();
                $y = date('Y', time());
                while ($y >= $this->firstYear) {
                    $range = $this->monthSpan(strtotime($y . '-' . $this->data['DateRange']['month']));
                    $onemonth = $this->constructDateRangeCondition($range);
                    $advancedDateCondtions = array_merge($advancedDateCondtions, $onemonth);
                    $y--;
                }
            } elseif ($this->data['DateRange']['month'] == 0) {
                // year only request
                $range = $this->yearSpan(strtotime($this->data['DateRange']['year'] . '-01-01'));
                $advancedDateCondtions = $this->constructDateRangeCondition($range);
            } else {
                // month and year request
                $range = $this->monthSpan(strtotime($this->data['DateRange']['year'] . '-' . $this->data['DateRange']['month']));
                $advancedDateCondtions = $this->constructDateRangeCondition($range);
            }
        } elseif ($this->data['DateRange']['week'] != 0) {
            // a week range request
            $offset = intval($this->data['DateRange']['week']);
            if ($this->data['DateRange']['week'] > $offset) {
                $range = $this->sinceXWeeksAgo($offset - 1);
            } else {
                $range = $this->XWeeksAgo($offset - 1);
            }
            $advancedDateCondtions = $this->constructDateRangeCondition($range);
        }
        return $advancedDateCondtions;
    }

    /**
     * Return one three-part date range condition array
     *
     * Though this array as written would AND search the three field,
     * code that calls this method will add an OR element later.
     * This allows multiple date ranges to be searched simultaneously.
     *
     * @param array $range A standard date range array
     * @return array A Cake condition array for a query
     */
    function constructDateRangeCondition($range) {
        //array('Post.id BETWEEN ? AND ?' => array(1,10))
        $rangeCondition = array(
            array('Content.modified BETWEEN ? AND ?' => array($range['start']['sql'], $range['end']['sql'])),
            array('Image.date BETWEEN ? AND ?' => array($range['start']['unix'], $range['end']['unix'])),
            array('Image.modified BETWEEN ? AND ?' => array($range['start']['sql'], $range['end']['sql']))
        );
        return $rangeCondition;
    }

    /**
     * Pick the article slug off end of url and expand url if necessary
     *
     * Art and Workshop articles are children of some arbitrary number
     * of menu nodes. Both may be reached directly with controller/slug
     * url or with the full path. This code will extract the last entry
     * in the url path and store it as a potential slug and will
     * check the menu path to that node. This code will build the full
     * url path if nessecery and redirect to expand the menu.
     */
    function expandShortUrl() {
        // get the pname
        // and expand the url to full nest-length if necessary
        $url = preg_replace(
                array(
            '/[\/]?page:[0-9]+/',
            '/[\/]?id:[0-9]+/'
                ), '', $this->request->url);
        $target = explode('/', $url);
        // extract the last non-page/non-id bit off the url as pname
        $this->params['pname'] = $target[count($target) - 1];

        if (count($target) == 2) {
            // found possible shortcut URL like
            // /art/so-different
            // if it is, we'll construct the true path and redirect
            // first get the tree path to the current pname
            $nav = $this->Navigator->find('all', array(
                'conditions' => array(
                    'Navline.route' => $this->params['pname']
                )
                    ));
            $nav = $this->Navigator->getpath($nav[0]['Navigator']['id'], null, '1');

            // then if it is longer that the current path,
            // then it was a shortcut. build and redirect
            if (count($target) < count($nav)) {
                $path = '';
                foreach ($nav as $node) {
                    $path .= DS . $node['Navline']['route'];
                }
                $this->redirect($path);
            };
        }
    }
    
}

?>