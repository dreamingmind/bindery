<?php
/**
 * CakePHP CheckoutComponent
 * 
 * Provide common services for Controllers that are doing checkout tasks
 * 
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
	
	/**
	 * Perform appropriate redirect when landing of page that reqires a cart when none exists
	 * 
	 * This is assumed to be an error condition and a customer may have lost their cart. 
	 * So, do some data collection and notification processes then redirect.
	 */
	public function doNoCartRedirect(){
		$this->controller->redirect($this->calculateCartRedirect(array('controller' => 'pages', 'action' => 'empty_cart')));
	}
	
	/**
	 * return appropriate redirect to accompany notification of cart becoming empty
	 * 
	 * @return array
	 */
	public function lastItemRedirect() {
		return $this->calculateCartRedirect(array('controller' => 'products'));
	}
	
	/**
	 * Determine contextually where a redirect should point from an 'empty cart' situation
	 * 
	 * There are two 'empty cart' situatuations. 
	 *	First, the user was in a cart pallet or in a checkout process and removed the last cart item 
	 *		This will leave a flash message with a link. The link will hold this
	 *		calculated redirect. If the user is on a page that requires an 
	 *		existing cart, the defaultUrl will be used (currently the base products page). 
	 *		If the referer is a page that doesn't need an existing cart, that location will be used.
	 * Second, the user has, for some reason, arrived on a page that requires a cart but none exists. 
	 *		In this case, if they have come here from some browsable page that doesn't 
	 *		require a cart they will be returned there with a message. 
	 *		Otherwise they'll be sent to an error page because there should be no situation that 
	 *		would allow them to get to such a page with no cart.
	 * 
	 * @param array $defaultUrl
	 * @return array
	 */
	private function calculateCartRedirect($defaultUrl) {
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

}
