<?php
//App::uses('CustomProduct', 'Helper/PurchasePurchaseUtilities');
//App::uses('InventoryProduct', 'Helper/PurchasePurchaseUtilities');
//App::uses('WorkshopProduct', 'Helper/PurchasePurchaseUtilities');
//App::uses('PurchasedProduct', 'Helper/PurchasePurchaseUtilities');
//App::uses('VariationProduct', 'Helper/PurchasePurchaseUtilities');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
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

//	abstract public function itemText($item, $mode);
//
	public function designName($item, $mode) {
		if ($mode === 'item_summary') {
			$text = String::truncate($item['Cart']['design_name'], 40);
		} else {
			$text = $item['Cart']['design_name'];
		}
		return $this->Html->tag('h1', $text);
	}
	
	public function blub($item, $mode) {
		
	}
	
	public function optionList($item, $mode) {
		
	}
	
	public function modeToggle($action, $isNewItem = FALSE) {
		if (!$isNewItem) {
			return $this->Html->para('tools', 
				$this->Html->link($action, '', array('class' => 'tool', 'bind' => 'itemDetailToggle')));
		}
	}
	
	public function itemQuantity($item) {
		return $this->Form->input(
				"{$item['Cart']['id']}.Cart.quantity",
				array(
					'label' => FALSE,
					'div' => FALSE,
					'bind' => 'change.itemQuantityChange',
					'value' => $item['Cart']['quantity']
				)
			);
	}
	
	public function itemPrice($item) {
		return $this->Html->tag('span', $item['Cart']['price'], array('class' => 'price'));
	}

	public function itemTotal($item) {
		return $this->Html->tag('span', $item['Cart']['price'], array('class' => 'total'));
	}

}
