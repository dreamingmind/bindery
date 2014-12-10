<?php
/**
 * Base class for ProdcutHelpers
 * 
 * Product Helpers handle rendering of product purchase tools and displays. 
 * Currently, the tools focus on Cart rending tasks. But it seems likely these would 
 * expand to do button rendering for the various prodcuts too.
 * 
 * Cart records carry a `type` field which is used to instantiate a concrete Product Helper. 
 * This base class comes along for the ride, supplying common code and default implementations 
 * for methods that aren't needed in the concrete classes.
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
		if (!$isNewItem) {
			return $this->Html->para('tools', 
				$this->Html->link($action, $item['CartItem']['id'], array('class' => 'tool toggleDetail', 'bind' => 'click.itemDetailToggle')));
		}
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
					'old_val' => $item['CartItem']['quantity']
				)
			);
	}
	
	/**
	 * Create the price display-chip for a cart item
	 * 
	 * Price is the cost of one unit, without accounting for quantity ordered
	 * 
	 * @param array $item
	 * @return string
	 */
	public function itemPrice($item) {
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
		return $this->Html->link('Remove', "/cart_item/delete/{$item['CartItem']['id']}", array('class' => 'tool remove', 'bind' => 'click.removeItem'));
	}
		
	/**
	 * Provide a default implementation of the edit-request tool
	 * 
	 * @param array $item
	 * @return string
	 */
	public function editItemTool($item) {
		return '';
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
