<?php

App::uses('DrawbridgeAppModel', 'Drawbridge.Model');

/**
 * CakePHP Drawbridge
 * @author jasont
 */
class Drawbridge extends DrawbridgeAppModel {

    public $useTable = 'users';
    var $validate = array(
        'username' => array(
            'rule' => array('email', true),
            'message' => 'Please supply a valid email address.'
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'required' => true
            ),
            'checkPasswordComplexity' => array(
                'rule' => 'checkPasswordComplexity',
                'message' => 'Password is not complex enough.'
            )
        ),
        'confirm_password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            ),
            'comparePasswords' => array(
                'rule' => 'comparePasswords',
                'message' => 'Passwords do not match.'
            )
        )
    );
    private $passwordComplexity = array(
        'alpha' => '+',
        'upper' => '+',
        'digit' => '+',
        'special' => '+',
        'length' => '8,256'
    );

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //replace default password complexity with configured password complexity
        try {
            $this->passwordComplexity = Configure::read('Drawbridge.PasswordComplexity');
        } catch (Exception $exc) {
            
        }
    }

    public function comparePasswords($field) {
        return ($this->data['Drawbridge']['confirm_password'] === $this->data['Drawbridge']['password']);
    }

    public function checkPasswordComplexity($field) {
        //extract the password from the supplied validation array element
        $value = array_values($field);
        $password = $value[0];
        
        //check individual regex test for each type of complexity
        $alpha = preg_match("/[a-zA-Z]{$this->passwordComplexity['alpha']}/", $password);
        $upper = preg_match("/[A-Z]{$this->passwordComplexity['upper']}/", $password);
        $digit = preg_match("/[\d]{$this->passwordComplexity['digit']}/", $password);
        $special = preg_match("/[\W]{$this->passwordComplexity['special']}/", $password);
        $length = preg_match("/.{{$this->passwordComplexity['length']}}/", $password);
        
        //if all pass, OK, else assemble validation message
        if($alpha && $upper && $digit && $special && $length){
            return true;
        } else {
            $exploded_length = explode(',', $this->passwordComplexity['length']);
            $message = array(
                !$alpha ? 'You must have one or more letters.' : '',
                !$upper ? 'You must have one or more upper case letters.' : '',
                !$digit ? 'You must have one or more numbers.' : '',
                !$special ? 'You must have one or more special characters.' : '',
                !$length ? "You must have between $exploded_length[0] and $exploded_length[1] characters." : ''
            );
            $this->validator()->getField('password')->getRule('checkPasswordComplexity')->message = implode('\n', $message);
            return false;
        }
    }

    public function resetPassword($user_id, $new_password) {
        
    }

    public function registerNewUser() {
        try {
            $this->save();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
