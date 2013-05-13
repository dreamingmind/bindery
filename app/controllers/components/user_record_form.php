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
 * UserRecordForm Component
 *
 * Method to check for proper password and email entries
 * and to massage form content and error messages in case
 * of entry error or non valid input
 * 
 * @author dondrake
 * @package       bindery
 * @subpackage    bindery.User
 */
class UserRecordFormComponent extends Object {

    var $components = array('Auth');

    function initialize(&$controller) {
        //$this->controller = $controller;
        //$this->model = &$controller->{$this->controller->modelClass};
    }
    
    /**
     * Password input, check for match
     * 
     * If the user hits enter while in one of the password fields
     * or if javascript is disabled, the check for matched input fails
     * and the flag field is not set properly.
     * This code insures the two input fields are checked
     * for equivalence
     * 
     * @param array $data A reference to the controllers $this->data array
     */

    function isPasswordMatched(&$data) {
        $hpass = $this->Auth->password($data['User']['repeat_password']);
        if ($hpass == $data['User']['password']) {
            $data['User']['pMatch'] = 'true';
        } else {
            $data['User']['pMatch'] = 'false';
        }
    }
    
    /**
     * Email input, check for match
     * 
     * If the user hits enter while in one of the email fields
     * or if javascript is disabled, the check for matched input fails
     * and the flag field is not set properly.
     * This code insures the two input fields are checked
     * for equivalence
     * 
     * @param array $data A reference to the controllers $this->data array
     */
  
    function isEmailMatched(&$data) {
        if ($data['User']['email'] == $data['User']['repeat_email']) {
            $data['User']['eMatch'] = 'true';
        } else {
            $data['User']['eMatch'] = 'false';
        }
    }
    
        // Reset the password field to the non-encrypted form and
        // handle other password verification results
    /**
     * Reset Password fields when the form must be redisplayed
     *
     * If the from must be returned for further work, on of the password fields will be
     * encrypted, the other not. This clears both fields if they never matched
     * and tweaks the error message. If they did match it makes them both
     * un-encrypted for proper handling when the form resubmits.
     *
     * @param array $data
     * @param array $errors
     */
    function resetPasswordFields(&$data,&$errors) {
        if ($data['User']['pMatch'] == 'false') {
            $data['User']['repeat_password'] = '';
            $data['User']['password'] = '';
            $errors['password'] = 'Passwords did not match. ';
            if (isset($errors['repeat_password'])) {
                $errors['password'] .= $errors['repeat_password'];
                unset($errors['repeat_password']);
            }

        } else {
            $data['User']['password'] = $data['User']['repeat_password'];
        }
    }

    /**
     * Tweak Password error message when password didn't validate
     *
     * If the password didn't validate for reasons other than missmatch
     * in the two fields, get the error on the right field
     *
     * @param array $errors
     */
    function resetPasswordError(&$errors) {
        // move the password error message to display on the right field
        // it would be on 'repeat' because password was encrypted and couldn't be checked directly
        if (isset($errors['repeat_password'])) {
            $errors['password'] = $errors['repeat_password'];
            unset($errors['repeat_password']);
        }
    }
    
    /**
     * Tweak Email error message when email didn't validate
     *
     * If the email didn't validate for reasons other than missmatch
     * in the two fields, get the error on the right field.
     *
     * @param array $errors 
     */
    function resetEmailError(&$errors) {
        // place the email error on the right field
        if (isset($errors['eMatch'])) {
            $errors['email'] = $errors['eMatch'];
            unset($errors['eMatch']);
        }
    }

}
?>