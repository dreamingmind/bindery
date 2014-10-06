<?php
App::uses('Biscuit', 'Lib');	
App::uses('PurchasedProductFactory', 'Lib/PurchaseUtilities');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP cart
 * @author dondrake
 */
class PurchasesComponent extends Component {
	
	/**
	 * The Request object
	 *
	 * @var object
	 */
	private $request;

	public $Biscuit;

	public $components = array('Session');
	
//	public $uses = array('Cart');

	public function initialize(Controller $controller) {
//		$this->Session = $controller->Components->load('Session');
		$this->Cart = ClassRegistry::init('Cart');
		$this->controller = $controller;
	}

	public function startup(Controller $controller) {
		// If the user has a cookie and it doesn't match the current Session id, it means 
		// they've been here before and may have old Cart items linked to the previous Session. 
		// We'll move those cart items to the current sesion if they exist.
		
		// If cookies aren't allowed, we'll send a Flash message the first time we discover the fact
		
		// If a Session doesn't exist, one will be created
		
		// Logging in changes the Session id also, and would leave an orphan Cart, 
		// but we take care of that problem in users->login()
		$this->Biscuit = new Biscuit($controller);
//		echo 'cookie:'.$this->Biscuit->storedSessionId().' | session:'.$this->Session->id();
		
		if ($this->Biscuit->cookiesAllowed()) {
//			dmDebug::ddd($this->Biscuit->currentSessionId(), 'current session');
//			dmDebug::ddd($this->Session->read('Auth.User.id'), 'user id');
			
			if ($this->Biscuit->storedSessionId() != NULL && !$this->Biscuit->sameSession()) {
				
				$this->Cart->maintain($this->Session, $this->Biscuit->storedSessionId());
				$this->Biscuit->saveSessionId();
			}
//			$this->set('cart', $this->Cart->fetch($this->Session));
		}
	}

	public function beforeRender(Controller $controller) {
		$controller->set('purchaseCount', $this->itemCount());

	}

	public function shutDown(Controller $controller) {
		
	}

	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
		
	}
	
	public function itemCount() {
		return $this->Cart->count($this->Session);
	}
	
	/**
	 * Add another item to the shopping cart
	 * 
	 * This will have to detect the dfferent kinds of products: 
	 *		-- spec'd vs standard --
	 * and take appropriate action
	 */
	public function add() {
		if ($this->controller->request->is('POST')) {
			$this->controller->layout = 'ajax';
			try {
				$this->validator = PurchasedProductFactory::makeProduct($this->controller->request->data);
				$price = $this->validator->calculatePrice();				
			} catch (Exception $exc) {
				echo $exc->getTraceAsString();
			}

		}
		
		$key = $this->controller->request->data['specs_key']; // this is the array node where the detail specs are listed

		$data = array(
			'Cart' => array(
				'user_id' => $this->Session->read('Auth.User.id'),
				'session_id' => ($this->Session->read('Auth.User.id') == NULL) ? $this->Session->id() : NULL,
				'data' => serialize($this->controller->request->data),
				'design_name' => $this->controller->request->data[$key]['description'],
				'price' => rand(100, 300)
			)
		);
		
		$this->Cart->save($data);
		$this->controller->set('new', $this->Cart->id);
		$this->controller->set('cart', $this->Cart->fetch($this->Session));
	}
	
	public function maintain($Session, $oldSession) {
		$this->Cart->maintain($Session, $oldSession);
	}
	
	public function login() {
		$this->maintain($this->Session, $this->Biscuit->storedSessionId());
		$this->Biscuit->saveSessionId();
	}

}
