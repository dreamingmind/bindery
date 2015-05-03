<?php

App::uses('DrawbridgeAppModel', 'Drawbridge.Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * CakePHP Drawbridge
 * @author jasont
 */
class Drawbridge extends DrawbridgeAppModel {

    public $useTable = 'users';
    var $validate = array(
        'username' => array(
            'content' => array(
                'rule' => array('email', true),
                'message' => 'Please supply a valid email address.'
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'This email address is already a registered user.'
            )
//            'rule' => array('email', true),
//            'message' => 'Please supply a valid email address.'
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
	
	private $token = '';
	
	public $passwordReset = array();

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        //replace default password complexity with configured password complexity
        try {
            $this->passwordComplexity = Configure::read('Drawbridge.PasswordComplexity');
        } catch (Exception $exc) {
            
        }
    }

    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
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
        if ($alpha && $upper && $digit && $special && $length) {
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
            return $this->save();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    /**
     * Check if a username exists in the database
     * 
     * @param string $username
     * @return boolean
     */
    public function checkRegisteredEmail($controller) {
        if(!$user = $this->find('first', 
				array(
					'conditions' => array(
						'username' => $controller->registered_user[$controller->concrete_model]['username']
							)
					))){
            throw new NotFoundException('There is no user registered under that username');
        }
		$controller->registered_user[$controller->concrete_model]['id'] = $user['Drawbridge']['id'];
    }
	
	/**
	 * Use provided token to access and store a user record
	 * 
	 * Validate that the token has also not expired through embedded date encoding
	 * 
	 * @param string $token the password reset token
	 */
	public function checkPasswordResetToken($token) {
		$this->token = $token;
		$this->passwordReset['result'] = FALSE;
		if ($this->queryDatabaseForPasswordResetToken()) {
			$this->checkExpirationOfPasswordResetToken();
		}		
	}
	
	/**
	 * Lookup user based upon password reset token
	 * 
	 * Set the passwordReset property to the retreived user
	 * 
	 * @return boolean
	 */
	protected function queryDatabaseForPasswordResetToken() {
		$this->passwordReset['User'] = $this->find('first', array(
			'conditions' => array(
				'token' => $this->token
			)
		));
		if($this->passwordReset['User'] == array()){
			$this->passwordReset['message'] = 'This password reset token is invalid. Please request a new password reset.';
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 * Using the encoded date, check the password reset token for expiration
	 * 
	 */
	protected function checkExpirationOfPasswordResetToken() {
		$month = hexdec(substr($this->token, 0, 1));
		$day = hexdec(substr($this->token, -2));
		if($month == '12' && $day > '29'){
			$year = date('Y', time() - (1 * YEAR));
		} else {
			$year = date('Y', time());
		}
		$this->token_date = date('m/d/Y', strtotime($year . '-' . $month . '-' . $day));
		if ($this->token_date < date('m/d/Y', (time() - 2 * DAY))){
			$this->passwordReset['User'] = array();
			$this->passwordReset['message'] = 'This password reset token has expired. Please request a new password reset.';
		} else {
			$this->passwordReset['result'] = TRUE;
		}
	}
	
	
}
