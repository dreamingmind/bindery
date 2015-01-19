<?php
App::uses('Biscuit', 'Lib');	
App::uses('CartToolKit', 'Lib');	
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

	public $components = array('Session', 'CartLog');
	
	public $product;
	
	public $controller;
	
	private $cartModel = 'Cart';
	
	private $cartItemModel = 'CartItem';

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
		$this->Cart->Session = $this->Session;
		if ($this->Biscuit->cookiesAllowed()) {
			if ($this->Biscuit->storedSessionId() != NULL && !$this->Biscuit->sameSession()) {
				$this->Cart->maintain($this->Biscuit->storedSessionId());
				$this->Biscuit->saveSessionId();
			}
		}
	}

	/**
	 * Always set cart related values to the View
	 * 
	 * Sets the count of cart items for the view at $purchaseCount
	 * Sets contact info to $cartContact array
	 * 
	 * @param Controller $controller
	 */
	public function beforeRender(Controller $controller) {
		$controller->set('purchaseCount', $this->itemCount());
		$controller->set('cartContact', $this->cartContact());
	}

	public function shutDown(Controller $controller) {
		
	}

	public function beforeRedirect(Controller $controller, $url, $status = null, $exit = true) {
		
	}
	
	/**
	 * Ajax return of new cart badge
	 * 
	 * Call to any controller will get here through an appController pass through. 
	 * Many other cart ajax processes will call here to get the count set but will 
	 * handle rendering of the badge in their own element.
	 * 
	 * @param boolean render final render or set up for later render
	 */
	public function newBadge($render = false) {
		$this->controller->layout = 'ajax';
		$this->controller->set('purchaseCount', $this->itemCount());
		if ($render) {
			$this->controller->render('/Elements/Cart/cart_badge');
		} else {
			return;
		}
	}

	/**
	 * Set contact info for customer contact element (email.ctp) in purchase forms
	 * 
	 * There may be contact info in the cart record 
	 * or if not, the user may be logged in and have the info recorded there, 
	 * otherwise we don't know this data and use an empty array
	 * 
	 * @return array
	 */
	public function cartContact() {
		if ($this->cartExists()) {
			$contact = $this->Cart->getContactData();
		} elseif ($this->controller->Auth->user()) {
			$contact = array('Cart' => array(
				'name' => $this->controller->Auth->user('first_name') . ' ' . $this->controller->Auth->user('last_name'),
				'email' => $this->controller->Auth->user('email'),
				'phone' => $this->controller->Auth->user('phone')
			));
		} else {
			$contact = array();
		}
		return $contact;
	}

	/**
	 * Return the count of items in the cart
	 * 
	 * @return int
	 */
	public function itemCount() {
		return $this->Cart->count();
	}
	
	/**
	 * Get the current cart and its items
	 * 
	 * @return type
	 */
	public function retrieveCart() {
		$cart = $this->Cart->retrieve();
		$cart['toolkit'] = new CartToolKit($cart);
		return $cart;
	}
		
	/**
	 * Does the logged in or anonomous user have a cart 
	 * 
	 * @return boolean
	 */
	public function cartExists() {
		return $this->Cart->cartExists();
	}
	
	public function verifyCartVolume() {
		if ($this->itemCount() == '0') {
			$this->Cart->delete($this->Cart->cartId());
		}
	}

	/**
	 * Remove a cart item and possibly a cart
	 * 
	 * @param string $id
	 */
	public function remove($id, $delete = 'delete') {
		$this->controller->$delete($id);
		$this->verifyCartVolume();
		$this->newBadge();
	}
	
	public function wish() {
		$this->verifyCartVolume();
		$this->newBadge();
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
			try {
				$cart = $this->retrieveCart();
				// the factory will make the proper concrete product after examining t->c->r->data
				$this->product = PurchasedProductFactory::makeProduct($this->controller->request->data, $cart);
				$this->CartItem = ClassRegistry::init($this->cartItemModel);
				$this->CartItem->saveAssociated($this->product->cartEntry($cart['Cart']['id']));
			} catch (Exception $exc) {
				echo $exc->getTraceAsString();
			}
		}
		$this->controller->layout = 'ajax';
		$this->controller->set('new', $this->CartItem->id);
		$cart = $this->retrieveCart();
		$this->controller->set('cart', $cart);
	}
	
	/**
	 * Handle a cart item after the specs have been edited
	 */
	public function updateItem() {
//		dmDebug::ddd($this->controller->request->data, 'trd');die;
		if ($this->controller->request->is('POST')) {
			try {
				$cart = $this->retrieveCart();
				// the factory will make the proper concrete product after examining t->c->r->data
				$this->product = PurchasedProductFactory::makeProduct($this->controller->request->data, $cart);
				// inject the new data (there are some problems handling all the constuct variations)
				$this->product->data($this->controller->request->data);
				$this->CartItem = ClassRegistry::init($this->cartItemModel);
				$this->CartItem->saveAssociated($this->product->cartEntry($cart['Cart']['id']));
			} catch (Exception $exc) {
				echo $exc->getTraceAsString();
			}
		}
		$this->controller->layout = 'ajax';
		$this->controller->set('new', $this->CartItem->id);
		$cart = $this->retrieveCart();
		$this->controller->set('cart', $cart);
	}

	/**
	 * Change a CartItem [and Supplement] quantity values
	 * 
	 * @param string $id
	 * @param int $qty
	 */
	public function updateQuantity($id, $qty) {
		// js front-loads all the zero qty and empty cart processes. Ignore those here
		// 
		try {
			$this->CartItem = ClassRegistry::init($this->cartItemModel);
			$cartItem = $this->CartItem->retrieve($id);
			$this->product = PurchasedProductFactory::makeProduct($cartItem, $this->retrieveCart());
			$item = $this->product->updateQuantity($id, $qty);
			return $this->CartItem->saveAssociated($item);
		} catch (Exception $exc) {
			echo $exc->getTraceAsString();
		}
	}
	
	/**
	 * Given a CartItem id, return the form data that originally defined the item
	 * 
	 * @param string $id CartItem id
	 */
	public function sourceFormData($id) {
		$this->CartItem = ClassRegistry::init($this->cartItemModel);
		$cartItem = $this->CartItem->retrieve($id);
		$this->product = PurchasedProductFactory::makeProduct($cartItem, $this->retrieveCart());
		return $this->product->data();
	}

	/**
	 * Keep the cart associated with the user that created it
	 * 
	 * @param string $oldSession The last known session link for the cart
	 */
	public function maintain($oldSession) {
		$this->Cart->maintain($oldSession);
	}
	
	/**
	 * When a User logs in, move their Cart from the Session to thier User id
	 */
	public function login() {
		$this->maintain($this->Biscuit->storedSessionId());
		$this->Biscuit->saveSessionId();
	}

}