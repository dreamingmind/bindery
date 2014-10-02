<?php

/**
 * Biscuit: Take care of setup and verification of Cookies, site wide
 * 
 * Cookies maintain the Session id which links to Cart items for users 
 * that are not logged in. 
 *
 * @author dondrake
 */
class Biscuit {
	
	private $Cookie;
	private $Session;

	private $allowed;
	private $storedSessionId;

	/**
	 * Set up 30day site-wide cookie if possible
	 * 
	 * If the client allows cookies, we'll read the Session id she's stored. 
	 * If she doesn't allow them, we'll FlashMessage a site limitation message 
	 * if we haven't already done it (indicated by a Session value)
	 * 
	 * @param Controller $controller Must have Cookie and Session Components
	 */
	public function __construct(Controller $controller) {
		$this->Cookie = $controller->Cookie;
		$this->Session = $controller->Session;
		
		if (!$this->initSiteCookie()) {
			if (!$this->Session->check('Notices.cookies')) {
				$this->Session->setFlash('Cookies are disabled. You will have to log in to use the shopping cart');
				$this->Session->write('Notices.cookies', TRUE);
			}
		}
	}
	
	/**
	 * If cookies aren't allowed, we sent a notice. Record that so we don't do it again during this Session
	 */
//	public function __destruct() {
//		if (!$this->allowed) {
//		}
//	}

	/**
	 * Configure a 30 day site cookie and verify the client allows cookies
	 * 
	 * @return boolean
	 */
	private function initSiteCookie() {
		$this->Cookie->domain = $_SERVER['HTTP_HOST'];
		$this->Cookie->name = 'dreamingmind';
		$this->Cookie->time = '30 days';
		$this->Cookie->key = 'idjIR97(*5#kdjfmc/.6aa,?,0665+klmvhf=-oijsdfUleJK8^&$%@)$#';
		$this->Cookie->httpOnly = true;
		$this->Cookie->type('rijndael');
		return $this->cookiesAllowed();
	}
	
	/**
	 * Are cookies allowed by the client
	 * 
	 * Prepare an instructive Flash Message if cookies aren't allowed
	 * 
	 * @return boolean
	 */
	public function cookiesAllowed() {
		if (isset($this->allowed)) {
			return $this->allowed;
		}
		$this->Cookie->write('tag', 'verify');
		$this->allowed = $this->Cookie->read('tag') == 'verify';
		return $this->allowed;
	}
	
	/**
	 * Determine if the session named in the cookies is the current session
	 * 
	 * If no Session existed, this will create one
	 * 
	 * @return boolean
	 */
	public function sameSession() {
		return $this->storedSessionId() == $this->Session->id();
	}
	
	/**
	 * Get the session id currently stored in the clients cookie
	 * 
	 * @return string
	 */
	public function storedSessionId() {
		return $this->Cookie->read('session_id');
	}
	
	/**
	 * Get the current php session id
	 * 
	 * @return string
	 */
	public function currentSessionId() {
		return $this->Session->id();
	}
	
	/**
	 * Save the current php session id in a cookie dreamingmind[session_id]
	 */
	public function saveSessionId() {
		$this->Cookie->write('session_id', $this->Session->id());
	}
	
}
