<?php

App::uses('UserAuthAppController', 'UserAuth.Controller');

/**
 * CakePHP User
 * @author jasont
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

    public function register() {
        if($this->request->is('POST') || $this->request->is('PUT')){
            if($this->User->registerNewUser()){
                $this->Session->setFlash('Thanks for registering', 'f_success');
                $this->redirect($url)
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
    
    
}
