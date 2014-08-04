<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.User
 */
/**
 * User Model
 * 
 * Table of register users, customers and site administrators
 * and all the contact data they provided on registration to the site
 * <pre>
 *   |<--- Request
 *   V
 * User <-- OptinUser --> Optin
 *   |
 *   |---> Group
 * </pre>
 * 
 * @package       bindery
 * @subpackage    bindery.User
 * @todo figure out why this is separate from Account
 */
class User extends AppModel {

	var $name = 'User';
        var $uses = array('User', 'Aco');
	var $validate = array(

            'group_id' => array(
                'rule' => 'numeric',
                'last' => true
            ),
            'username' => array(
                'content' => array (
                    'rule' => 'notEmpty',
                    'message' => 'You must enter a Username',
                    'last' => true
                ),
                'unique' => array (
                    'rule' => 'isUnique',
                    'message' => 'Your chosen Username is already in use.',
                    'last' => true
                ),
                'alphnum' => array(
                    'rule' => 'alphaNumeric',
                    'message' => 'Usernames must only contain letters and numbers.',
                    'last' => true
                )
            ),
            'email' => array(
                'content' => array(
                    'rule' => 'notEmpty',
                    'message' => 'You must enter an email address',
                    'last' => true
                ),
                'unique' => array (
                    'rule' => 'isUnique',
                    'message' => 'You already have an account.',
                    'last' => true
                )
            ),
            'eMatch' => array(
                'rule' => array('equalTo', 'true'),
                'message' => 'Your email addresses didn\'t match.',
                'last' => true
            ),
            'repeat_password' => array(
                'rule' => array('minLength', 8),
                'message' => 'Your password must be at least 8',
                'last' => true
            ),
            'password' => array(
                'rule' => array('minLength', 8),
                'message' => 'Your password must be at least 8',
                'last' => true
            ),
            'pMatch' => array(
                'rule' => array('equalTo', 'true'),
                'message' => 'Your passwords didn\'t match',
                'last' => true
            )
	);
	var $actsAs = array('Acl' => array('type' => 'requester'));
        var $displayField = 'username';

	var $belongsTo = array(
            'Group' => array(
                'className' => 'Group',
                'foreignKey' => 'group_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
	);
        var $hasMany = 'OptinUser';
        
    /**
     * @var string $username Username of the logged in user
     */
    var $username = false;

    /**
     * @var string $usergroup Group the logged in user belongs to
     */
    var $usergroup = false;

    /**
     * @var integer $userid Id of the logged in user
     */
    var $userid = false;

    /**
     * @var string $useremail Email address of the logged in user
     */
    var $useremail = false;

    /**
     * @var string $useractiveActive status of the logged in user
     */
    var $useractive = false;

    /**
     * @var array $groupnames map account 'group' values to thier group name
     */
    var $groupnames = array('Administrator'=>1, 'Manager'=>2, 'User'=>3 );
    
    /**
     * Data to verify a proper match of the data to be written and the record to be updated
     * 
     * For untrusted editors, we will hash the form data User.id and User.registration_date
     * This should be the value of User_validate. From that record, we'll pull User.id and
     * Group.id and compare them to the form data. Mismatch = spoofing.
     *
     * @var array|false $valid User.id and Group.id in an array or FALSE if no record found
     */
    var $valid = null;

    /**
     * Hashed concatenation of the record id and registration date.
     *
     * Used to confirm the form data and stored data refer to the same record
     * @var string|false $validate_hash defaut cake password hash method used
     */
    var $validate_hash = false;

        /**
         * A way to pass in the data for the logged in user
         * 
         * The controllers knows a lot of info about the logged in user that
         * is invisible to the User Model. 
         * 
         * @param array|false $userrecord the user data array ($this->Auth->user()
         * @access public
         * @return void
         */
        function setAuthorizedUser($userrecord = null) {
            $this->userdata = $userrecord['User'];
            if ($this->userdata) {
                $this->usergroupid = $userrecord['User']['group_id'];
                $this->useractive = $userrecord['User']['active'];
                $this->username = $userrecord['User']['username'];
                $this->usergroupid = $userrecord['User']['group_id'];
                //$this->usergroup = $this->groupnames[$userrecord['User']['group_id']];
                $this->userid = $userrecord['User']['id'];
                $this->useremail = $userrecord['User']['email'];
            }
        }

        /**
         * After the user record find
         *
         * Hours of effort to get the 'validate' has to write afterSave
         * FAILED! Checking the found record is not ideal
         * but it works. And I'm DONE wasting time on the afterSave method.
         *
         * @param array $results The found data
         * @return array $results The found data
         */
        function afterFind($results, $primary = false) {
            //debug($results);
            foreach ($results as $key => $val) {
                if (isset($val['User']['validate']) && $val['User']['validate'] == 'pending') {
                    $this->saveValidateHash($val);
                    $val['User']['validate'] = $this->validate_hash;
                }
            }
            return $results;
        }

        /**
         * Get the parent to the user record in $this->data
         *
         * Accomodation for passing an id in without form data is made but, do we do this?
         *
         * @return array The id field of the Group record that is parent to user $this->data
         */
	function parentNode() {

            if (!$this->id && empty($this->data)) {
	        return null;
	    }

	    $data = $this->data;
	    if (empty($this->data)) {
	        $data = $this->read();
                debug($data);
	    }
	    if (!isset($data['User']['group_id'])) {
	        return null;
	    } else {
	        return array('Group' => array('id' => $data['User']['group_id']));
	    }
	}

	/** After save callback
	 * Update the aro for the user
	 * @access public
	 * @return void
	 */
	function afterSave($created) {
            if ($created) {
                $alias = $this->data['User']['username'].'::'.$this->id;
                $parent = $this->parentNode();
                $parent = $this->node($parent);
                $node = $this->node();
                $aro = $node[0];
                $aro['Aro']['parent_id'] = $parent[0]['Aro']['id'];
                $aro['Aro']['alias'] = $alias;
                $this->Aro->save($aro);

                $aco = new Aco();
                $parent = $aco->findByAlias('UserRecord');
                $parentId = $parent['Aco']['id'];

                $aco->create();
                $aco->save(array(
                  'model'       => 'User',
                  'foreign_key' => $this->id,
                  'parent_id'   => $parentId,
                  'alias'       => $alias
                ));

                $aro_id = $this->Aro->id;
                $aco_id = $aco->id;

                $permission = new Permission();
                $permission->save(array(
                   'aro_id' => $aro_id,
                   'aco_id' => $aco_id
                ));

            }
	}

        function afterDelete($id = null) {
            // Aro and AcoAro get deleted automatically.
            
            $aco = new Aco();
            $aco->id = $this->Aro->data['Aco'][0]['id'];
            $aco->delete();
        }

        /**
         *
         * @return string|false The hash string or false on failure
         */
        function validateHash($data) {
 //           debug($data);
            if (isset($data['User']['id']) && isset($data['User']['registration_date'])) {
                $this->validate_hash = AuthComponent::password($data['User']['id'].$data['User']['registration_date']);
 //               debug($this->validate_hash);
                return $this->validate_hash;
            } else {
 //               debug('failure of save vh');
                return false;
            }
        }

        /**
         * Create or recreate the validate hash for a record
         *
         * Since validateHash needs id and registration date, these better be in the array!
         * This gets called during afterFind so suppress crazy callbackcallbacks
         *
         * @var array $data The form data
         * @return boolean true on success, false on failure
         */
         function saveValidateHash($data=null) {
//             debug('arrived in svh');
             $this->create($data);
//             debug($this->data);
             if ($this->validateHash($this->data)) {
                $this->set('validate', $this->validate_hash);
//                debug($this->data);
                if ($this->save($this->data,
                        array('validate'=>false,
                              'callbacks'=>false))) {
//                    debug("successful svh");
                    return true;
                } else {
//                    debug ('failed save svh');
                    return false;
                }
//             debug ('failed svh vh call');
             return false;
             }
         }
        /**
         * Trust the data in different ways depending on the logged in users group
         *
         * Assuming 4 ways to have a user record for saving:
         * Registration: ($this->usergroupid = false):
         *  $this->data has fields except no id, no group_id (set to default and passed for save)
         * Admin editing ($this->usergroupid = 1):
         *  $this->data set, id and group_id all exist and are trusted and passed for save
         * Manager editing ($this->usergroupid = 2:
         *  $this->data set, id and group not trusted and not passed for save
         * User account editing ($this->usergroupid = 3:
         *  $this->data set, id and group not trusted and not passed for save
         *
         * Accomodation for passing an id in without form data is made but, do we do this?
         *
         * @return array The id field of the Group record that is parent to user $this->data
         */
        function beforeSave($options = array()) {
//            debug($this->data);
            //debug($this->userdata);
            if (!$this->userdata) {
                //debug($this->data);
                // This is an anonymous user registering a new account
                // They can't be allowed to force an id or set an access level
                $this->data['User']['group_id'] = $this->groupnames['User'];
                unset($this->data['User']['id']);
                // We'll write a validate value later in the registration action after they get an id
                $this->data['User']['validate'] = 'pending';
                //debug($this->data);
            } elseif ($this->usergroupid == $this->groupnames['User']) {
                // This is a user editing their own account
                //debug($this->validateHash($this->data));
                $this->data['User']['group_id'] = $this->groupnames['User'];
                //debug($this->hackCheck($this->validateHash($this->data)));
                $this->hackCheck($this->validateHash($this->data));
                if ($this->valid) {
//                    debug('Looks good.');
//                    debug($this->valid);
                    return true;
                }
                if (!$this->valid) {
//                    debug('Looks bad.');
                    return false;
                    // send user to a relogin for security page
                }
            }

            return true;
        }

        /**
         * Check posted data to see if there was a spoofing attemp
         *
         * Check the post data id and group_id match what we think.
         *  If there is a suspicious discrepancy
         * deactivate the account and logout.
         *
         * ********* TO DO ************
         * add an action log db and send the user an email
         *
         * @return mixed True or redirect to logout
         */
        function hackCheck($hash) {
            $clone = new User();
            $valid = $clone->find('first', array(
                'conditions' => array('User.validate' => $hash),
                'fields' => array('User.id', 'Group.id')));
//            debug($valid);
//            debug($this->data);
            if ($valid['User']['id'] == $this->data['User']['id']
                    && $valid['Group']['id'] == $this->data['User']['group_id']) {
                $this->valid = $valid;
            } else {
                $this->valid = false;
            }
//            if (isset($this->data['Account']['id']) && $this->data['Account']['id'] != $this->userid) {
//                unset($this->data['Account']);
//                $this->data['Account'] = array('id' => $this->userid, 'active' => FALSE);
//                $this->Account->save($this->data);
//                $this->Session->setFlash('Your account has been deactivated because of suspicious activity. Call for more details, (510) 537-9711.');
//                $this->redirect(array('controller'=>'users', 'action'=>'logout'));
//            }
//            return true;
        }

}
?>