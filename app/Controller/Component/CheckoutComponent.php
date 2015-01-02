<?php
/**
 * CakePHP CheckoutComponent
 * @author dondrake
 */
class CheckoutComponent extends Component {

	public $components = array();
	
	/**
	 * Controllers that don't accept redirect when the cart is found empty
	 */
	private $noRedirect = array(
		'checkout',
		'cart'
	);

	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

	public function startup(Controller $controller) {
		
	}

	public function beforeRender(Controller $controller) {
		
	}

	public function shutDown(Controller $controller) {
		
	}

	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
		
	}
	
	public function doNoCartRedirect(){
		$this->controller->redirect($this->calculateCartRedirect(array('controller' => 'pages', 'action' => 'empty_cart')));
	}
	
	public function calculateCartRedirect($defaultUrl) {
		$referer = $this->controller->referer();
		$l = strrpos($referer, $this->controller->request->webroot) + strlen($this->controller->request->webroot);
		$url = substr($referer, $l, strlen($referer) - $l);
		$referer = Router::parse($url);
		
		$this->controller->Session->setFlash('Your cart is empty');
		//if redirecet is to somewhere non-cartish
		if (in_array($referer['controller'], $this->noRedirect)) { 
			return $defaultUrl;
			
		// if redirect is to ok-to-browse page
		} else {
			return $this->controller->referer();
		}
	}
	
	public function lastItemRedirect() {
		return $this->calculateCartRedirect(array('controller' => 'products'));
	}

}
