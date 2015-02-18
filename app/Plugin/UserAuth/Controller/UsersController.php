<?php

App::uses('UserAuthAppController', 'UserAuth.Controller');

/**
 * A general class for handling the user registration and login processes
 * 
 * CakePHP User
 * @author jasont
 * 
 * Must configure bootstrap.php with the following keys:
 * UserAuth.RegistrationRedirect containing a redirect url to use after first login
 *      formatted to match the Auth->redirect property
 * 
 */
class UsersController extends UserAuthAppController {

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

    /**
     * Register a new user
     * 
     * Upon success redirect to the UserAuth.RegistrationRedirect url or
     * to the Auth redirect url
     */
    public function register() {
        if ($this->request->is('POST') || $this->request->is('PUT')) {
            try {
                $redirect = Configure::read('UserAuth.RegistrationRedirect');
            } catch (Exception $exc) {
                $redirect = $this->Auth->redirectUrl();
            }
            if ($this->User->registerNewUser()) {
                $this->Session->setFlash('Thanks for registering', 'f_success');
                $this->redirect($redirect);
            } else {
                $this->redirect('register');
            }
        }
    }

    public function login() {
        
    }

    public function logout() {
        
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
    private function _dispatchAuthUserEvent($event_name, $data) {
        $event = new CakeEvent($event_name, $this, $data);
        $this->getEventManager()->dispatch($event);
    }
    
    public function testMe() {
        $this->layout = 'ajax';
        dmDebug::ddd(Configure::read('UserAuth.RegistrationRedirect'), 'registration redirect');
        dmDebug::ddd($this->Auth->redirectUrl(), 'Auth redirect URL');
    }

}
