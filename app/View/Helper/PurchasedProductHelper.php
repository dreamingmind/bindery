<?php
/**
 * Base class for ProdcutHelpers
 * 
 * Product Helpers handle rendering of product purchase tools and displays. 
 * Currently, the tools focus on Cart rending tasks. But it seems likely these would 
 * expand to do button rendering for the various prodcuts too.
 * 
 * Cart records carry a `type` field which is used to instantiate a concrete helpers 
 * for various specific product types. These helpers will be composed in as tools here 
 * and we can call for special result variants (like cart edit links). 
 * 
 * CakePHP PurchasedProductHelper
 * @author dondrake
 */
class PurchasedProductHelper extends AppHelper {

	/**
	 * Expanded and truncated display data for all Items
	 * 
	 * The Item blocks can display full text or truncated text. 
	 * This array will be converted to a json object and sent 
	 * too the page to provide the data variants
	 *
	 * @var array
	 */
	public $modeToggleData;
	
	public $toggleData = array();

	/**
	 * Store the design name text variants and return the currently required version
	 * 
	 * @param array $item
	 * @param string $mode
	 * @return string
	 */
	public function designName($item, $mode) {
		$summary = $this->Html->tag('h1', String::truncate($item['CartItem']['product_name'], 40), array('class' => 'product_name'));
		$full = $this->Html->tag('h1', $item['CartItem']['product_name'], array('class' => 'product_name'));
		$this->storeToggleData($item, 'product_name', $summary, $full);
		
		if ($mode === 'item_summary') {
			$text = $summary;
		} else {
			$text = $full;
		}
		return $text;
	}
	
	/**
	 * Return the HTML for the specified button
	 * 
	 * Generate the buttons required for cart and checkout processes
	 * checkout, express (paypal), creditcard, check, quote, continue
	 * 
	 * @param string $type 
	 * @param object $toolkit The CartToolKit
	 */
	public function checkoutButton($type, CartToolKit $toolkit) {
		switch ($type) {
			case 'checkout':
				if ($toolkit->mustPay()) {
					return $this->Form->button('Checkout', array(
								'class' => 'checkout btn blue',
								'bind' => 'click.checkout'
					)) . "\n";
				} else {
					return '';
				}
				break;
			case 'express' : // && !$toolkit->mustQuote():
				return $toolkit->mustPay()
					? '<img '
					. 'href="checkout_express/set_express" bind="click.buttonLink" '
					. 'method="paypal" '
					. 'src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif">'
					: '' ;
				break;
			case 'confirm' :// && !$toolkit->mustQuote():
				echo $this->Form->button('Confirm', array('href' => "{$this->request->controller}/receipt", 'bind' => 'click.buttonLink', 'class' => 'btn blue'));
				break;
			case 'creditcard' :// && !$toolkit->mustQuote():
				echo !$toolkit->includesQuote() ? "<button class=\"btn\">Credit Card</button>\n" : '';
				break;
			case 'check' :// && !$toolkit->mustQuote():
				echo !$toolkit->includesQuote() ? "<button class=\"btn\">Pay by Check</button>\n" : '';
				break;
			case 'quote' :
				$this->checkoutQuoteButton($toolkit);
				break;
			case 'back_edit' :
				echo "<button class=\"btn ltGrey\" bind=\"click.backToEdit\">Back to edit</button>\n";
				break;
			case 'continue':
				return $this->checkoutContinueButton($toolkit);
				break;
			case 'methods':
				return $this->checkoutMethodSelect($toolkit);
				break;
			default:
				break;
		}
	}
	
	public function checkoutQuoteButton($toolkit) {
		if (!$toolkit->mustPay()) {
			if (stristr($this->request->controller, 'checkout')) {
				$button = $this->Form->button('Recieve a Quote', array('type' => 'submit', 'form' => 'CartIndexForm', 'class' => 'btn'));
			} else {
				$button = $this->Form->button('Recieve a Quote', array('href' => 'checkout_quote', 'bind' => 'click.buttonLink', 'class' => 'btn'));
			}
			echo $button . "\n" . $this->Html->tag('aside', 
					'Once a single item can\'t be priced, your cart will be submitted for quote before arranging for payment.');
		}
	}
	
	public function submitAddressAction($toolkit) {
		if (!$toolkit->mustPay()) {
			return'/checkout_quote';
		}
	}

	protected function checkoutMethodSelect($toolkit) {
		$method = array(
			'check' => 'Check',
			'credit_card' => 'Credit Card',
			'quote' => 'Request and quote',
			'paypal' => 'PayPal'
			);
		echo $this->Form->input('method', array(
			'options' => $method,
			'empty' => 'Select a payment method',
			'bind' => 'change.methodChoice'
		));
	}
	/**
	 * Make a 'Continue Shopping' button for cart UIs
	 * 
	 * Will attempt to send the user back to their last viewed page 
	 * prior to starting the checkout process. If this can't be done, 
	 * will route to the main product page. cart.js actually handles 
	 * the navigation because sometimes we're in a floating pallet view.
	 * 
	 * @param CartToolKit $toolkit
	 * @return string
	 */
	public function checkoutContinueButton(CartToolKit $toolkit) {
		if (stristr('/checkout', $this->request->referer())) {
			$href = Router::url(array('controller' => 'contents', 'action' => 'products'));
		} else {
			$href = $this->request->referer();
		}
		//dmDebug::ddd($this->request->referer(), 'referer');
		return $this->Form->button('Continue Shopping', array(
				'id' => 'continue',
				'bind' => 'click.continueShopping',
				'href' => $href,
				'class' => 'btn ltGrey'
			)) . "\n";
	}				

	/**
	 * Save expand/collapse item-text data for assembly into a json package
	 * 
	 * On a cart page, each item has a text section which displays 
	 * name, blurb, and option list data describe the product ordered. 
	 * These data may display truncated or fully expanded and this array/json obj 
	 * will contain both versions indexed by id.node.variant 
	 * (eg: toggleData[356][blurb][summary] = 'short tex...' or 
	 * toggle Data[722][name][full] = 'Amending Self' )
	 * 
	 * @param array $item
	 * @param string $group
	 * @param string $summary
	 * @param string $full
	 */
	protected function storeToggleData($item, $group, $summary, $full) {
		$this->toggleData[$item['CartItem']['id']][$group] = array('summary' => $summary, 'full' => $full);
	}


	/**
	 * Fallback blurb creation method
	 * 
	 * This handles making an empty blurb node for the cart item_text section 
	 * as a default in cases where the concrete Product doesn't have an implementation
	 * 
	 * @param array $item
	 * @param string $mode
	 * @return string
	 */
	public function blurb($item, $mode) {
//		$summary = $full = '';
//		$this->storeToggleData($item, 'blurb', $summary, $full);
//		return '';
		$summary = $this->Html->div('blurb', '<p>'.String::truncate($item['CartItem']['blurb'], 40).'</p>');
//		$full = $this->Html->tag('h1', $item['CartItem']['blurb'], array('class' => 'blurb'));
		$full = $this->Html->div('blurb', $this->Markdown->transform($item['CartItem']['blurb']));
		$this->storeToggleData($item, 'blurb', $summary, $full);
		
		if ($mode === 'item_summary') {
			$text = $summary;
		} else {
			$text = $full;
		}
		return $text;
	}
	
	/**
	 * Fallback option list creation method
	 * 
	 * This handles making an empty option list node for the cart item_text section 
	 * as a default in cases where the concrete Product doesn't have an implementation
	 * 
	 * @param array $item
	 * @param string $mode
	 * @return string
	 */
	public function optionList($item, $mode) {
//		dmDebug::ddd($item, 'item');
		$summary = $this->Html->div('options', '<p>'.String::truncate($item['CartItem']['options'], 40).'</p>');
//		$full = $this->Html->tag('h1', $item['CartItem']['options'], array('class' => 'options'));
		$full = $this->Html->div('options', $this->Markdown->transform($item['CartItem']['options']));
		$this->storeToggleData($item, 'options', $summary, $full);
		
		if ($mode === 'item_summary') {
			$text = $summary;
		} else {
			$text = $full;
		}
		return $text;
}
	
	/**
	 * Create the tool that initiates collapse/expand feature of cart item_text nodes
	 * 
	 * @param array $item
	 * @param string $action
	 * @param boolean $isNewItem
	 * @return string
	 */
	public function modeToggle($item, $action, $isNewItem = FALSE) {
//		if (!$isNewItem) {
			return $this->Html->para('tools', 
				$this->wishListTool($item) . $this->Html->link($action, $item['CartItem']['id'], array('class' => 'tool toggleDetail', 'bind' => 'click.itemDetailToggle')));
//		}
	}
	
	/**
	 * Create the quantity input for a cart item
	 * 
	 * This input will allow quantity change for the item whenever the 
	 * cart ui is visible. It always works via ajax and will update the 
	 * proper item display values. It will also handle removal of the 
	 * item when the quantity is set to zero.
	 * 
	 * @param array $item
	 * @return string
	 */
	public function itemQuantity($item) {
		return $this->Form->input(
				"{$item['CartItem']['id']}.Cart.quantity",
				array(
					'label' => FALSE,
					'div' => FALSE,
					'bind' => 'change.updateQuantity',
					'value' => $item['CartItem']['quantity'],
					'cart_item_id' => $item['CartItem']['id'],
					'old_val' => $item['CartItem']['quantity'],
					'before' => '<span id="check" style="opacity: 0; color: green;">✓ </span>'
				)
			);
	}
	
	/**
	 * Create a display-only qty-at-price string for item receipt/confirmation display
	 * 
	 * @param array $item
	 * @return string 
	 */
	public function itemQuantitySummary($item) {
		return $this->Html->tag('span', $item['CartItem']['quantity'], array('class' => 'quantity'));
	}


	/**
	 * Create the price display-chip for a cart item
	 * 
	 * Price is the cost of one unit, without accounting for quantity ordered
	 * The $price object travels all the way back to cart_ui and is 
	 * used to make decisions about what buttons to put on the interface
	 * 
	 * @param array $item
	 * @param stdObj $prices track whether any items have a zero price
	 * @return string
	 */
	public function itemPrice($item, $prices = false) {
//		$prices->zeroItem = $prices->zeroItem || ($item['CartItem']['price'] == '0');
		return $this->Html->tag('span', $item['CartItem']['price'], array('class' => 'price'));
	}

	/**
	 * Create the 'total' display chip for a cart item
	 * 
	 * Total is quantity * price and will update if the quantity input changes
	 * 
	 * @param array $item
	 * @return string
	 */
	public function itemTotal($item) {
		return $this->Html->tag('span', $item['CartItem']['total'], array('class' => 'total', 'id' => "item_total-{$item['CartItem']['id']}"));
	}
	
	/**
	 * Create the remove tool for a cart item
	 * 
	 * Does it's work through an ajax call
	 * 
	 * @param array $item
	 * @return string
	 */
	public function removeItemTool($item) {
		return $this->Html->link('Remove', "/cart_item/remove/{$item['CartItem']['id']}", array('class' => 'tool remove', 'bind' => 'click.removeItem'));
	}
		
	/**
	 * Create the remove tool for a cart item
	 * 
	 * Does it's work through an ajax call
	 * 
	 * @param array $item
	 * @return string
	 */
	public function wishListTool($item) {
		return ($this->Session->read('Auth.User.id') 
				? $this->Html->link('Save To Wish List', "/cart_item/wish/{$item['CartItem']['id']}", array('class' => 'tool wish', 'bind' => 'click.wishItem')) . ' • ' 
				: '');
	}
		
	/**
	 * Provide a default implementation of the edit-request tool
	 * 
	 * @param array $item
	 * @return string
	 */
	public function editItemTool($item) {
		$helper = "{$item['CartItem']['type']}Product";
		$concrete = $this->_View->Helpers->load($helper);;
		return $concrete->editItemTool($item);
	}
	
	/**
	 * Intelligently assemble 'Name • Contact' display line from cart data
	 * 
	 * @param array $cart Cart record
	 * @return string
	 */
	public function cartContactHeader($cart) {
		$cartOwner = ($cart['Cart']['name'] != '') ? $cart['Cart']['name'] : 'Anonymous';
		$cartOwnerContact = (($cart['Cart']['email'] != '')) 
			? " • {$cart['Cart']['email']}" 
			: ((($cart['Cart']['phone'] != '')) 
				? " • {$cart['Cart']['phone']}"
				: '');
		return $this->Html->para('contact', $cartOwner . $cartOwnerContact);
}

//	public function cartSubtotal($subtotal) {
//		echo "
//	<p>
//		<span class='label'>Subtotal:</span>
//		<span class='amt'>$subtotal</span>
//	</p>
//";
//	}

	/**
	 * Provide the edit-request tool for a custom product
	 * 
	 * ==============================================================================================
	 * This has been moved from CustomProductHelper during the elimination of concrete helpers
	 * when CartItem blurb and options fields were created.
	 * It's not clear how this should be handled now. And a weird pattern of enstantiating the helper 
	 * is in use now in cart_ui.ctp. That should be chased up to the controller as usual.
	 * 
	 * @param array $item
	 * @return string
	 */
//	public function editItemTool($item) {
//		$supplement = unserialize($item['Supplement'][0]['data']);
//		return $this->Html->link('Edit', array(
//			'controller' => 'catalogs',
//			'action' => 'editProduct',
//			$supplement['specs_key']
//			),
//			array('class' => 'tool')
//		);
//	}
}
