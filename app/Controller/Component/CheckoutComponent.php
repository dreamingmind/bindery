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
	
	public function noCartRedirect(){
		
		$referer = $this->controller->referer();
		$l = strrpos($referer, $this->controller->request->webroot) + strlen($this->controller->request->webroot);
		$url = substr($referer, $l, strlen($referer) - $l);
		$referer = Router::parse($url);
		
		$this->controller->Session->setFlash('Your cart is empty');
		if (in_array($referer['controller'], $this->noRedirect)) { //if redirecet is to somewhere non-cartish
			$this->controller->redirect(array('controller' => 'pages', 'action' => 'empty_cart'));
		} else {
			$this->controller->redirect($this->controller->referer());
		}
	}

}
