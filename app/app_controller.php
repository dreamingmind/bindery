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
                'controller' => '/'
                ),
            'loginRedirect' => array(
                'plugin' => null,
                'controller' => '/'
                ),
            'loginError' => "This message shows up when the wrong credentials are used",
            'authError' => "Please log in to proceed.",
            'authorize' => 'controller',
            //'authorize' => 'actions',
            //'authorize' => 'crud',
            'allowedActions' => array('display')
        ),
        'Session'
        );

    var $helpers = array('Menu', 'Html', 'Form', 'Js', 'Session', 'GalNav', 'Paginator', 'Fieldset');
    var $uses = array('Navigator', 'User', 'Account');
    var $record = array();

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
    var $groupnames = array('0' => 'Guest', '1'=>'administrator', '2'=>'manager', '3'=>'user' );

    function beforeFilter() {
        parent::beforeFilter();
        // These things should happen regardless of login or permission
        $this->initCompany(); //set company contact strings in an array
        $this->initAccount(); //set all properties describing the logged in user (or not)
        $this->mainNavigation(); //get the account appropriate full, potential menu record set
        $this->splashContent = $this->pullSplash();
        
        //debug();
        
    // Time to see if this user can see the requested page
    }

    function initAccount() {
        if ($this->Auth->user() != null) {
            $this->useractive = $userdata['useractive'] = $this->Auth->user('active');
            $this->username = $userdata['username'] = $this->Auth->user('username');
            $this->usergroupid = $userdata['usergroupid'] =  $this->Auth->user('group_id');
            $this->usergroup = $userdata['usergroup'] = $this->groupnames[$this->Auth->user('group_id')];
            $this->userid = $userdata['userid'] =  $this->Auth->user('id');
            $this->useremail = $userdata['useremail'] =  $this->Auth->user('email');
            $userdata['userdata'] = $this->Auth->user();
            $userdata['userdata'] = $userdata['userdata']['User']; // compress out the extra 'User' index level
            $this->set($userdata);
            $this->User->setAuthorizedUser($this->Auth->user());//move this data into User properties for use in the model
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
        if ((count($this->params['named'])+count($this->params['pass'])) > 0
                || $this->params['controller'] === 'pages'){
            return false;
        }
            // if named or passed params are present, we're not in
            // a top level page that might have a splash page
            // explode the url and search for Content. Last one is the splash content.
            // Search from the back!!
        $routes = explode(DS, $this->params['url']['url']);
        $this->splashRoute = $routes[count($routes)-1];
    }
    /**
     * Read the proper menus for this user
     *
     * Read the menu appropriate to an admin, manager, registered user or guest
     */
    function mainNavigation() {
            $conditions = 'account=0';

            if ($this->username) {
                    $conditions .= ' OR account>=' . $this->usergroupid;
                    // User account $find_params['conditions'] = array("Navigator.account = '0' OR Navigator.account = '3'");
            }

            /**
             * This is the find for the nested navigation menu data set.
             * It needs to be beefed up to take into account the login status of the user
             **/
            //$this->set('navigators', $this->Navigator->find('all', $find_params));
            $this->set('group', $this->Navigator->generatetreegrouped($conditions, null, '/Navline', '{n}.Navigator.parent_id', 1));

    }
    function isAuthorized() {
       $id = $this->Account->findByUsername($this->username,array('fields'=>'id'));
       //debug ($this->record);
       if ($this->record['Group']['name'] == 'Administrator') {
            //$this->set('authed','Auth logic: Administrator');
            return true;
        } elseif ($this->params['action'] == 'logout' ||
            $this->params['action'] == 'login' ||
            $this->params['action'] == 'register')
        {
            //$this->set('authed','Auth logic: logout/login/register');
            return true;
        } elseif ($this->Acl->check($this->Auth->user(), $this->params['controller'] . '/' . $this->params['action'])) {
        //if ($this->Acl->check('dreamingmind', $this->params['controller'])) {
            //$this->set('authed','Auth logic: authedLevel/params');
            return true;
        } elseif ($this->Acl->check(
                $this->usergroup."/".$this->username."::".$this->userid,
                "UserRecord/".$this->username."::".$this->userid)) { // this same/same comparison is not good
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
}

