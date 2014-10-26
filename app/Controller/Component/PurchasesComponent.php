<?php
App::uses('Biscuit', 'Lib');	
App::uses('PurchasedProductFactory', 'Lib/PurchaseUtilities');

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
	
	public $product;
	
	public $controller;

	/**
	 * Load the Cart Model and memorize the controller
	 * 
	 * @param Controller $controller
	 */
	public function initialize(Controller $controller) {
//		$this->Session = $controller->Components->load('Session');
		$this->Cart = ClassRegistry::init('Cart');
		$this->controller = $controller;
	}

	/**
	 * As the new server visit gears up, keep the Cart linked properly to Session or User
	 * 
	 * If the user has a cookie and it doesn't match the current Session id, it means 
	 * they've been here before and may have old Cart items linked to the previous Session. 
	 * We'll move those cart items to the current sesion if they exist. 
	 * 
	 * If cookies aren't allowed, we'll send a Flash message the first time we discover the fact 
	 * 
	 * If a Session doesn't exist, one will be created 
	 * 
	 * Logging in changes the Session id also, and would leave an orphan Cart, 
	 * but we take care of that problem in users->login()
	 * 
	 * @param Controller $controller
	 */
	public function startup(Controller $controller) {
		$this->Biscuit = new Biscuit($controller);
		if ($this->Biscuit->cookiesAllowed()) {
			if ($this->Biscuit->storedSessionId() != NULL && !$this->Biscuit->sameSession()) {
				$this->Cart->maintain($this->Session, $this->Biscuit->storedSessionId());
				$this->Biscuit->saveSessionId();
			}
		}
	}

	public function beforeRender(Controller $controller) {
		$controller->set('purchaseCount', $this->itemCount());

	}

	public function shutDown(Controller $controller) {
		
	}

	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
		
	}
	
	/**
	 * Ajax return of new cart badge
	 * 
	 * Call to any controller will get here through an appController pass through. 
	 */
	public function newBadge($finish = TRUE) {
		$this->controller->layout = 'ajax';
		$this->controller->set('purchaseCount', $this->itemCount());
		if ($finish) {
			$this->controller->render('/Elements/Cart/cart_badge');
		} else {
			return $this->controller->render('/Elements/Cart/cart_badge');
		}
	}


	/**
	 * Return the count of items in the cart
	 * 
	 * @return int
	 */
	public function itemCount() {
		return $this->Cart->count($this->Session);
	}
		
	/**
	 * Does the logged in or anonomous user have a cart 
	 * 
	 * @return boolean
	 */
	public function exists() {
		return $this->Cart->cartExists($this->Session);
	}
	
	
	/**
	 * Delete an item
	 * 
	 * @param string $id
	 */
	public function delete($id) {
		$this->Cart->delete($id);
	}


	/**
	 * Add another item to the shopping cart
	 * 
	 * Makes the new Cart record id available at $new
	 * Makes the Cart data and linked data available at $cart
	 * 
	 */
	public function add() {
		if ($this->controller->request->is('POST')) {
			$this->controller->layout = 'ajax';
			try {
				// the factory will make the proper concrete product after examining t->c->r->data
				$this->product = PurchasedProductFactory::makeProduct($this->Session, $this->controller->request->data);
				$this->Cart->saveAssociated($this->product->cartEntry());
			} catch (Exception $exc) {
				echo $exc->getTraceAsString();
			}
		}
		$this->controller->set('new', $this->Cart->id);
		$this->controller->set('cart', $this->Cart->fetch($this->Session, TRUE));
	}
	
	/**
	 * Keep the cart associated with the user that created it
	 * 
	 * @param object $Session The current Session Component
	 * @param string $oldSession The last known session link for the cart
	 */
	public function maintain($Session, $oldSession) {
		$this->Cart->maintain($Session, $oldSession);
	}
	
	/**
	 * When a User logs in, move their Cart from the Session to thier User id
	 */
	public function login() {
		$this->maintain($this->Session, $this->Biscuit->storedSessionId());
		$this->Biscuit->saveSessionId();
	}

}
