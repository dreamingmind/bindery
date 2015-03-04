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
		if($this->request->action == 'forgotPassword'){
			$this->Security->validatePost = FALSE;
		}
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
        return $this->redirect($this->Auth->logout());
    }

    public function forgotPassword() {
        if($this->request->is('post')){
            $this->registered_user[$this->concrete_model] = $this->request->data['Drawbridge'];
            try {
                $this->Drawbridge->checkRegisteredEmail($this);
                $this->setupUserForPasswordReset();
                $this->sendPasswordResetEmail();
            } catch (Exception $exc) {
                $this->Session->setFlash($exc->message, 'f_error');
            }
        }
    }
    
	protected function setupUserForPasswordReset() {
		$this->registered_user[$this->concrete_model]['token'] = $this->createTokenForPasswordReset();
		unset($this->registered_user[$this->concrete_model]['password']);
		$this->{$this->concrete_model}->save($this->registered_user);
		$this->registered_user[$this->concrete_model]['link'] = $this->createLinkForPasswordReset();
	}
	
	protected function createTokenForPasswordReset() {
		$base_uuid = String::uuid();
		$month = dechex(date('m', time()));
		$day = dechex(date('j', time()));
		$day = strlen($day) == 1 ? '0' . $day : $day;
		$base_uuid_with_month = substr_replace($base_uuid, $month, 0,1);
		return substr_replace($base_uuid_with_month, $day, strlen($base_uuid_with_month)-2,2);
	}
	
	protected function createLinkForPasswordReset() {
		$url = Router::url(array('controller' => 'Drawbridges', 'action' => 'routeUserToPasswordReset'), true);
		$url = $url . '/' . $this->registered_user[$this->concrete_model]['token'];
		dmDebug::ddd($url, 'assembled url');
	}
	
	protected function sendPasswordResetEmail() {
		$Email = new CakeEmail();
		$Email->from(array('user_manager@dreamingmind.com' => 'Dreaming Mind Hand Bindery'))
			->to($this->registered_user[$this->concrete_model]['username'])
			->subject('Your password reset')
			->send('My message');
	}
	
	protected function routeUserToPasswordReset($token) {
		$this->{$this->concrete_model}->checkPasswordResetToken();
		if (!$this->checkExpirationOfPasswordResetToken($token)){
			$this->Session->setFlash('This password reset has expired', 'f_error');
			$this->redirect($this->Auth->logoutRedirect);
		}
	}
	
	protected function checkExpirationOfPasswordResetToken($token) {
		$month = hexdec(ltrim($token, 1));
		$day = hexdec(rtrim($token, 2));
		if($month == '12' && $day > '29'){
			$year = year() - (1 * YEAR);
		} else {
			$year = year();
		}
		$token_date = date('m/d/Y', $month . '/' . $day . '/' . $year);
		if ($token_date < date('m/d/Y', (time() - 2 * DAY))){
			return FALSE;
		} else {
			return TRUE;
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
