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
 * Users Controller
 * 
 * Methods to manage User registration and stored data
 * 
 * @package       bindery
 * @subpackage    bindery.User
 * @todo figure out why this is separate from Account
 */
class UsersController extends AppController {

	var $name = 'Users';
        var $components = array('UserRecordForm', 'Email');
        var $tempPassword = null;

//        var $first = array('empty');
//        var $second = array('empty');

	function beforeFilter() {
            $this->Auth->allow('logout','register','forgot', 'refreshHash');
            parent::beforeFilter();
            $this->css[] = 'login';
	}

        function beforeRender() {
            parent::beforeRender();
        }
        
	function index() {
            $this->User->recursive = 0;
            $this->set('users', $this->paginate());
	}

	function view($id = null) {
            if (!$id) {
                $this->Session->setFlash(__('Invalid User.'));
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
        if (!empty($this->request->data)) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The User has been saved'));
                $this->redirect(array('action'=>'index'));
            } else {
                $this->Session->setFlash(__('The User could not be saved. Please, try again.'));
            }
        }
        $groups = $this->User->Group->find('list');
        $this->set(compact('groups'));
    }

    function edit($id = null) {

        if (!$id && empty($this->request->data)) {
            // what the hell are we even doing here?
            $this->Session->setFlash(__('Invalid User'));
            $this->redirect(array('action'=>'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->request->data['User']['repeat_password'] == '') {
                unset($this->request->data['User']['repeat_password']);
            }
            $this->User->create($this->request->data);
            if ($this->User->validates()) {
//                        $a = $this->User->data['User']['repeat_password'];
//                    if (isset($this->User->data['User']['repeat_password'])) {
//                        $this->User->data['User']['password'] = $this->Auth->password($this->User->data['User']['repeat_password']);
//                        $a .= $this->User->data['User']['password'];
//                    }
                if ($this->User->save()) {
                    $this->Session->setFlash(__('The User has been saved'));
                    $this->redirect(array('action'=>'index'));
                } else {
                    $this->Session->setFlash(__('The User could not be saved. Please, try again.'));
                }
                $this->Session->setFlash(__('Please correct the indicated problems'));
           }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
            $groups = $this->User->Group->find('list');
            $this->set(compact('groups'));
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for User'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->delete($id)) {
            $this->Session->setFlash(__("User deleted $id"));
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
            $this->Session->setFlash('You are logged out. Thanks for visiting.');
        }
        $this->redirect($this->Auth->logout());
    }

    function forgot() {
//        debug($this->referer());
        if ($this->Auth->user() != null) {
            // A logged in user might arrive here because of
            // suspicious activity followed by a failure to
            // remember password. Log them out then return
            $this->Session->setFlash('You have been logged out. You may now request your username or password');
            $this->Auth->logoutRedirect=array('action'=>'forgot');
            $this->redirect(array('action'=>'logout'));
        }
//		debug($this->request->params);
       $this->Auth->redirect(array('controller' => 'users', 'action'=>'login'));
       $mode = $this->request->params['pass'][0];
//	   debug($mode);
       $this->set('mode', $mode);
//	   debug($this->request->data);
       if (!empty($this->request->data)) {
           $result=($this->User->find('first', array('conditions'=>array('email' => $this->request->data['User']['email']))));
//		   debug($result);
           if (!isset($result['User']) || $this->request->data['User']['email'] == NULL) {
               // couldn't find email in the db
               $this->Session->setFlash('Did not find the email '. $this->request->data['User']['email'] . '.');
               $this->set('register',true); // tell the page to offer a 'registration' link

           } else { // found email address in db. Send the info

               if ($this->email($this->request->data['User']['email'], $mode, $result)) {
                   // email sent ok, now...
                   $this->Session->setFlash("Your $mode has been emailed to {$this->request->data['User']['email']}");

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
				   debug('fail');die;
                   $this->Session->setFlash('The email could not be sent. Try again');
               }
           }
	   debug('render');die;
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
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash('Invalid id for User', true);
            $this->redirect(array('action'=>'index'));
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->User->read(null, $id);
        }
        //debug($this->request->data);
        if ($this->User->saveValidateHash($this->request->data)) {
            $this->Session->setFlash("Validate Hash value for record $id has been reset", true);
            $this->redirect(array('action'=>'index'));
        }
             $this->redirect(array('action'=>'index'));

    }
    function register() {

         if(!empty($this->request->data)) {
            //$this->request->data['User']['group_id'] = 3;
            $this->request->data['User']['active'] = 1;

            // Insure matched input even if javascript failed
            $this->UserRecordForm->isPasswordMatched($this->request->data);
            $this->UserRecordForm->isEmailMatched($this->request->data);

            $this->request->data['User']['registration_date'] = date('Y-m-d h:i:s');
            $this->User->set($this->request->data);
            if ($this->User->validates(array('fieldList' =>
                array('username', 'email', 'eMatch', 'repeat_password', 'pMatch')))) {
                //echo 'validate ok\n';
               $this->User->validate = false; // validaton will fail the second time for some reason. Off then.
               if ($this->User->save()) {
                   $this->Auth->login($this->request->data);
                   $this->redirect('/');
                   //echo 'save ok\n';

                } else {
                   echo 'save failed\n';
                    $this->Session->setFlash('An error occured while setting up your account. Please try again');
                    $this->request->data['User']['password'] = $this->request->data['User']['repeat_password'];
                }

            } else {

                /*
                 * Validation errors were detected. Process them here
                 */

                if (isset ($this->User->validationErrors['email']) && $this->User->validationErrors['email'] == 'You already have an account.') {
                    // Email already in use, redirect for login
                    $message = 'You already have an account associated with the email address ' .
                            $this->request->data['User']['email'] .
                            '. Go ahead and log in.';
                    $this->Session->setFlash($message);
                    $this->redirect(array('controller'=>'users', 'action'=>'login'));
                }

                /*
                 * If we didn't redirect, prep fields and errors for redisplay of form
                 */
                $this->Session->setFlash('Please correct the indicated problems.');
                $this->UserRecordForm->resetPasswordFields($this->request->data,$this->User->validationErrors);
                $this->UserRecordForm->resetPasswordError($this->User->validationErrors);
                $this->UserRecordForm->resetEmailError($this->User->validationErrors);
            }
        }
     }

    function email($address, $mode, $result) {
		debug(class_implements($this->Email));
       if ($this->request->base == '/bindery') {
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

	
}
?>