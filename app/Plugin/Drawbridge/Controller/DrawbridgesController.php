<?php

App::uses('DrawbridgeAppController', 'Drawbridge.Controller');
App::uses('UserEvent', 'Lib/Event');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * A general class for handling the user registration and login processes
 * 
 * CakePHP User
 * @author Jason T - Curly Mind
 * 
 * Plug-in requires:
 *  Auth Component
 *  BlowfishPasswordHasher
 * 
 * Database Schema Requirements
 * A 'users' table, which can be named anything, but must be recorded in bootstrap under
 *      Drawbridge.Model
 * In the 'users' table, you must have the following columns (this is a SQL create fraction)
 *        `password` varchar(255) DEFAULT NULL COMMENT 'password hash',
 *        `ip` varchar(50) DEFAULT NULL,
 *        `username` varchar(255) NOT NULL,

 * 
 * Must configure bootstrap.php with the following keys:
 * Drawbridge.RegistrationRedirect containing a redirect url to use after first login
 *      formatted to match the Auth->redirect property
 * Drawbridge.PasswordComplexity can be used to establish password complexity guidelines
 * Drawbridge.Model for the model name of the standard User model
 * 
 * In routes.php, add
 * //Drawbridge Plug-In Routes
    Router::connect('/login', array('plugin' => 'Drawbridge', 'controller' => 'drawbridges', 'action' => 'login'));
    Router::connect('/register', array('plugin' => 'Drawbridge', 'controller' => 'drawbridges', 'action' => 'register'));
    Router::connect('/logout', array('plugin' => 'Drawbridge', 'controller' => 'drawbridges', 'action' => 'logout'));
 * 
 * 
 * In AuthConfiguration, you must add a loginAction
 * **'loginAction' => '/login',

 * 
 */
class DrawbridgesController extends DrawbridgeAppController {
    

    /**
     * Helpers
     *
     * @var array
     */
    public $helpers = array(
        'Time',
        'Text'
    );

    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Security',
//        'Auth' => array(
//            'userModel' => 'Drawbridge'
//        )
    );
    
    /**
     * The Model name of the 'users' model
     * 
     * @var string
     */
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
    public $registered_user = array();

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
            $this->redirect($redirect);
        }
    }

    /**
     * Login method for drawbridge plug-in
     * 
     * THERE IS A BIG DODGE IN THIS CODE**************
     * **The auth component cannot abstract the table used by the model chosen
     * **We could, using $this->Auth->authenticate = array('Form' => array('userModel' => 'Drawbridge')
     * **connect the Auth component to our model.
     * **The Drawbridge model, however, uses the table specified in the configuration 'Drawbridge.Model'
     * **and the Auth component does not inspect our model file to determine a table to use
     * **if we specify the Drawbridge model, it expects a 'drawbridges' table.
     * **
     * **SO************
     * **We set the $this->request->data['Drawbridge'] array index to the specified model name index (Drawbridge.Model, again)
     * **and unset the Drawbridge index, generated automatically by the login form.
     * *******************
     * 
     * 
     * @return type
     */
    public function login() {
        if ($this->request->is('post')) {
            $this->request->data[$this->concrete_model] = $this->request->data['Drawbridge'];
            unset($this->request->data['Drawbridge']);
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        dmDebug::logVars($this->Auth->logout(), 'This auth logout');
        return $this->redirect($this->Auth->logout());
    }

    public function forgotPassword() {
        dmDebug::logVars($this->request->data, 'trd');
        if($this->request->is('post')){
            dmDebug::logVars($this->request->data, 'trd');
            $this->registered_user[$this->concrete_model] = $this->request->data['Drawbridge'];
            try {
                $this->Drawbridge->checkRegisteredEmail($this->registered_user[$this->concrete_model]['username']);
                $this->setupUserForPasswordReset();
                $this->sendPasswordResetEmail();
            } catch (Exception $exc) {
                $this->Session->setFlash($exc->message, 'f_error');
            }
        }
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
