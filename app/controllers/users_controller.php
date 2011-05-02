<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Form');
        var $components = array('UserRecordForm', 'Email');
        var $tempPassword = null;

//        var $first = array('empty');
//        var $second = array('empty');

	function beforeFilter() {
            $this->Auth->allow('logout','register','forgot', 'refreshHash');
            parent::beforeFilter();
	}

	function index() {
            $this->User->recursive = 0;
            $this->set('users', $this->paginate());
	}

	function view($id = null) {
            if (!$id) {
                $this->Session->setFlash(__('Invalid User.', true));
                $this->redirect(array('action'=>'index'));
            }
            $this->set('user', $this->User->read(null, $id));
	}

//        function isAuthorized() {
//            if ($this->Session->params['action'] == 'logout' ||
//                $this->Session->params['action'] == 'login' ||
//                $this->Session->params['action'] == 'register' )
//            {
//                return true;
//            } elseif ($authedLevel == 'Administrator') {
//                return true;
//            } else {
//                return false;
//            }
//        }

    function add() {
        if (!empty($this->data)) {
            $this->User->create();
            if ($this->User->save($this->data)) {
                $this->Session->setFlash(__('The User has been saved', true));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
            }
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    function edit($id = null) {

        if (!$id && empty($this->data)) {
            // what the hell are we even doing here?
            $this->Session->setFlash(__('Invalid User', true));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->data)) {
            if ($this->data['User']['repeat_password'] == '') {
                unset($this->data['User']['repeat_password']);
            }
            $this->User->create($this->data);
            if ($this->User->validates()) {
//                        $a = $this->User->data['User']['repeat_password'];
//                    if (isset($this->User->data['User']['repeat_password'])) {
//                        $this->User->data['User']['password'] = $this->Auth->password($this->User->data['User']['repeat_password']);
//                        $a .= $this->User->data['User']['password'];
//                    }
                if ($this->User->save()) {
                    $this->Session->setFlash(__('The User has been saved', true));
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash(__('The User could not be saved. Please, try again.', true));
                }
                $this->Session->setFlash(__('Please correct the indicated problems', true));
           }
        } else {
            $this->data = $this->User->read(null, $id);
            unset($this->data['User']['password']);
            $groups = $this->User->Group->find('list');
            $this->set(compact('groups'));
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for User', true));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->delete($id)) {
            $this->Session->setFlash(__("User deleted $id", true));
            $this->redirect(array('action'=>'index'));
        }
    }

    function login() {
        if ($this->Auth->user() != null) {
            // What's a logged in user doing here? Fix that!
            $this->redirect(array('action'=>'logout'));
        }
        $this->Auth->login();
        //$this->Session->setFlash("");
        //Auth Magic
    }

    function logout() {
        if($this->Session->read('Message.flash.message') == null) {
            $this->Session->setFlash('Good-Bye');
        }
        $this->redirect($this->Auth->logout());
    }

    function forgot() {
        //debug($this->referer());
        if ($this->Auth->user() != null) {
            // A logged in user might arrive here because of
            // suspicious activity followed by a failure to
            // remember password. Log them out then return
            $this->Session->setFlash('You have been logged out. You may now request your username or password');
            $this->Auth->logoutRedirect=array('action'=>'forgot');
            $this->redirect(array('action'=>'logout'));
        }
       $this->Auth->logoutRedirect(array('controller' => 'users', 'action'=>'login'));
       $mode = $this->params['pass'][0];
       $this->set('mode', $mode);
       if (!empty($this->data)) {
           $result=($this->User->find('first', array('conditions'=>array('email' => $this->data['User']['email']))));

           if (!isset($result['User']) || $this->data['User']['email'] == NULL) {
               // couldn't find email in the db
               $this->Session->setFlash('Did not find the email '. $this->data['User']['email'] . '.');
               $this->set('register',true); // tell the page to offer a 'registration' link

           } else { // found email address in db. Send the info

               if ($this->email($this->data['User']['email'], $mode, $result)) {
                   // email sent ok, now...
                   $this->Session->setFlash("Your $mode has been emailed to {$this->data['User']['email']}");

                   if ($mode == 'password') {
                       $result['User']['password'] = $this->tempPassword;

                       if (!$this->User->save($result)) {
                           // crikey! The new password didn't save properly!
                           $this->Session->setFlash("The email sent but the password was not reset. Try again.");

                       } else { // SUCCESS! everything was fine for password change
                           $this->redirect(array('action'=>'login'));
                       }

                   } else {
                       // SUCCESS! every thing went fine for username lookup and send
                       $this->redirect(array('action'=>'login'));
                   }

               } else { // email failed to send. Nothing at all was accomplished
                   $this->Session->setFlash('The email could not be sent. Try again');
               }
           }
       }
    }

    /**
         * Create or recreate the validate hash for a record
         * 
         *
         */
    function refreshHash($id = null) {
        //debug($id);
        //$this->autoRender = false;
        if (!$id && empty($this->data)) {
            $this->Session->setFlash('Invalid id for User', true);
            $this->redirect(array('action'=>'index'));
        }
        if (empty($this->data)) {
            $this->data = $this->User->read(null, $id);
        }
        //debug($this->data);
        if ($this->User->saveValidateHash($this->data)) {
            $this->Session->setFlash("Validate Hash value for record $id has been reset", true);
            $this->redirect(array('action'=>'index'));
        }
             $this->redirect(array('action'=>'index'));

    }
    function register() {

         if(!empty($this->data)) {
            //$this->data['User']['group_id'] = 3;
            $this->data['User']['active'] = 1;

            // Insure matched input even if javascript failed
            $this->UserRecordForm->isPasswordMatched($this->data);
            $this->UserRecordForm->isEmailMatched($this->data);

            $this->data['User']['registration_date'] = date('Y-m-d h:i:s');
            $this->User->set($this->data);
            if ($this->User->validates(array('fieldList' =>
                array('username', 'email', 'eMatch', 'repeat_password', 'pMatch')))) {
                //echo 'validate ok\n';
               if ($this->User->save()) {
                   $this->Auth->login($this->data);
                   $this->redirect('/');
                   //echo 'save ok\n';

                } else {
                   echo 'save failed\n';
                    $this->Session->setFlash('An error occured while setting up your account. Please try again');
                    $this->data['User']['password'] = $this->data['User']['repeat_password'];
                }

            } else {

                /*
                 * Validation errors were detected. Process them here
                 */

                if (isset ($this->User->validationErrors['email']) && $this->User->validationErrors['email'] == 'You already have an account.') {
                    // Email already in use, redirect for login
                    $message = 'You already have an account associated with the email address ' .
                            $this->data['User']['email'] .
                            '. Go ahead and log in.';
                    $this->Session->setFlash($message);
                    $this->redirect(array('controller'=>'users', 'action'=>'login'));
                }

                /*
                 * If we didn't redirect, prep fields and errors for redisplay of form
                 */
                $this->Session->setFlash('Please correct the indicated problems.');
                $this->UserRecordForm->resetPasswordFields($this->data,$this->User->validationErrors);
                $this->UserRecordForm->resetPasswordError($this->User->validationErrors);
                $this->UserRecordForm->resetEmailError($this->User->validationErrors);
            }
        }
     }

    function email($address, $mode, $result) {

       if ($this->base == '/bindery') {
         $this->Email->delivery = 'debug';
       }
       $this->Email->lineLength = 70;
       //$this->Email->layout = 'forgot';
       $this->Email->sendAs = 'text';
       $this->Email->from = 'ddrake@dreamingmind.com';
       $this->Email->bcc = array('ddrake@dreamingmind.com');
       $this->Email->to = $address;
       $this->Email->subject = 'Dreaming Mind sent the information you requested';
       if ($mode == 'username') {
            $this->set('username', $result['User']['username']);
            return $this->Email->send($mode, 'forgot', 'forgot_username');
       } else {
            $this->set('password', $this->makePassword());
            return $this->Email->send($mode, 'forgot', 'forgot_password');
       }
     }

    function makePassword() {
       $rand = '';
       for ($i = 0; $i < 3; $i++){
           $rand .= strtolower(chr(rand(97,122)));
       }
       $rand .= rand(100,999);
       for ($i = 0; $i < 3; $i++){
           $rand .= strtoupper(chr(rand(97,122)));
       }
       $this->tempPassword = AuthComponent::password($rand);
       return $rand;
}
 
     
//    if ($this->referer() != '/') {
//        $this->redirect($this->referer());
//    } else {
//        $this->redirect(array('controller' => 'pages'));
//    }
//  }

        function account() {
            
        }

        function gallery() {

        }

        function news() {

        }

        function purchase() {

        }

        function show_aco() {
            $aco =& $this->Acl->Aco;
            $aco_data = $aco->find("all");
            debug($aco_data);
            $aro =& $this->Acl->Aro;
            $aro_data = $aro->find('all');
            debug($aro_data);
            $ul = $this->User->find('list');
            debug($ul);
        }

        function initDB() {
	    $group =& $this->User->Group;
	    //Allow admins to everything
	    $group->id = 1;     
	    $this->Acl->allow($group, 'controllers');

	    //allow managers to posts and widgets
	    $group->id = 2;
	    $this->Acl->deny($group, 'controllers');
	    $this->Acl->allow($group, 'controllers/Posts');
	    $this->Acl->allow($group, 'controllers/Widgets');

	    //allow users to only add and edit on posts and widgets
	    $group->id = 3;
	    $this->Acl->deny($group, 'controllers');        
	    $this->Acl->allow($group, 'controllers/Posts/add');
	    $this->Acl->allow($group, 'controllers/Posts/edit');        
	    $this->Acl->allow($group, 'controllers/Widgets/add');
	    $this->Acl->allow($group, 'controllers/Widgets/edit');
	}
/*	*/
	
}
?>