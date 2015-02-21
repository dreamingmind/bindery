<?php

App::uses('DrawbridgeAppController', 'Drawbridge.Controller');
App::uses('UserEvent', 'Lib/Event');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * A general class for handling the user registration and login processes
 * 
 * CakePHP User
 * @author jasont
 * 
 * Plug-in requires:
 *  Auth Component
 *  BlowfishPasswordHasher
 * 
 * Must configure bootstrap.php with the following keys:
 * Drawbridge.RegistrationRedirect containing a redirect url to use after first login
 *      formatted to match the Auth->redirect property
 * Drawbridge.PasswordComplexity can be used to establish password complexity guidelines
 * Drawbridge.Model for the model name of the standard User model
 * 
 */
class DrawbridgesController extends DrawbridgeAppController {

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array(
        'Html',
        'Form',
        'Session',
        'Time',
        'Text'
    );

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Auth',
        'Session',
        'Cookie',
        'Security',
    );
    public $concrete_model = '';
    
    /**
     * This public property is made available to event handlers
     * 
     * It should be used to contain any additional data you wish to add to the Auth user
     * for login.
     * 
     * These values will show up in the Auth/User session, often used for access control
     * and user tracking.
     * 
     * @var array 
     */
    public $registered_user = array('User');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
        $this->concrete_model = Configure::read('Drawbridge.Model');
        $this->registered_user = array($this->concrete_model => array());
        CakeEventManager::instance()->attach(new UserEvent());
    }

    /**
     * Register a new user
     * 
     * Upon success redirect to the Drawbridge.RegistrationRedirect url or
     * to the Auth redirect url
     */
    public function register() {
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            $this->Drawbridge->data = $this->request->data;
            if (!$this->Drawbridge->registerNewUser()) {
                $this->redirect('register');
            }
            $this->registered_user[$this->concrete_model] = $registered_user_array = array(
                'id' => $this->Drawbridge->id,
                'username' => $this->request->data['Drawbridge']['username']
            );
            $this->Session->setFlash('Thanks for registering', 'f_success');
            $this->_dispatchDrawbridgeEvent('Drawbridge.newRegisteredUser', $registered_user_array);
            $this->Auth->login($this->registered_user[$this->concrete_model]);
            if(is_null(Configure::read('Drawbridge.RegistrationRedirect'))){
                $redirect = $this->Auth->redirectUrl();
            } else {
                $redirect = Router::url(Configure::read('Drawbridge.RegistrationRedirect'), true);
            }
            dmDebug::logVars($this->Session->read('Auth.redirect'), 'Session Auth redirect');
            dmDebug::logVars($this->Auth->loginRedirect, 'this Auth login redirect');
            dmDebug::logVars($this->Auth->redirectUrl(), 'this auth redirectUrl()');
            dmDebug::logVars($redirect, 'final redirect');
            $this->redirect($redirect);
        }
    }

    public function login() {
        if ($this->request->is('post')) {
            $this->testMe();
            exit();
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function forgotPassword() {
        
    }

    public function resetPassword($new_password) {
        
    }

    public function resetUserPassword($user_id) {
        
    }

    private function _generateNewPassword() {
        
    }

    public function forgotUsername() {
        
    }

    public function changeUsername($new_user_name) {
        
    }

    public function changeUserUsername($user_id, $new_user_name) {
        
    }

    public function deleteAccount() {
        
    }

    public function deleteUserAccount($user_id) {
        
    }

    public function disableUser($user_id) {
        
    }

    public function banIP($ip_address) {
        
    }

    /**
     * Send a named event
     * 
     * @param type $event_name the name of the event
     * @param type $data the data we wish to send with the event
     */
    private function _dispatchDrawbridgeEvent($event_name, $data) {
        $event = new CakeEvent($event_name, $this, $data);
        $this->getEventManager()->dispatch($event);
    }

    public function testMe() {
        $this->layout = 'ajax';
//            $passwordHasher = new BlowfishPasswordHasher();
//            $pass = $this->request->data['Drawbridge']['password'];
//            dmDebug::ddd($pass, 'password cleartext');
//            $this->request->data['Drawbridge']['password'] = $passwordHasher->hash($this->request->data['Drawbridge']['password']);
//            $pass = $this->request->data['Drawbridge']['password'];
//            dmDebug::ddd($pass, 'password hash');
            $p = 'xx';
            $i=0;
            while ($i<11){
                $passwordHasher = new BlowfishPasswordHasher();
                $out = $passwordHasher->hash($p);
                echo "<p>$out</p>";
                $i++;
            }
    }

}
