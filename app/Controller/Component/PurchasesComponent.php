<?php

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
	 * The Cart Model
	 *
	 * @var object
	 */
//	private $Cart;

	/**
	 * The Request object
	 *
	 * @var object
	 */
	private $request;


	public $components = array('Session');
	
//	public $uses = array('Cart');

	public function initialize(Controller $controller) {
//		$this->Session = $controller->Components->load('Session');
		$this->Cart = ClassRegistry::init('Cart');
		$this->request = $controller->request;
	}

	public function startup(Controller $controller) {
		
	}

	public function beforeRender(Controller $controller) {
		
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
		if ($this->request->is('POST')) {
			$this->layout = 'ajax';
		}
		
		$key = $this->request->data['specs_key']; // this is the array node where the detail specs are listed

		$data = array(
			'Cart' => array(
				'user_id' => $this->Auth->user('id'),
				'session_id' => ($this->Auth->user('id') == NULL) ? $this->Session->id() : NULL,
				'data' => serialize($this->request->data),
				'design_name' => $this->request->data[$key]['description'],
				'price' => rand(100, 300)
			)
		);
		
		$this->Cart->save($data);
		$this->set('new', $this->Cart->id);
		$this->set('cart', $this->Cart->fetch($this->Session));
	}

}
