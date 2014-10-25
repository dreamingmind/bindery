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
	
	public $toggleData = array();

//	abstract public function itemText($item, $mode);
//
	public function designName($item, $mode) {
		$summary = $this->Html->tag('h1', String::truncate($item['Cart']['design_name'], 40), array('class' => 'design_name'));
		$full = $this->Html->tag('h1', $item['Cart']['design_name'], array('class' => 'design_name'));
		$this->storeToggleData($item, 'design_name', $summary, $full);
		
		if ($mode === 'item_summary') {
			$text = $summary;
		} else {
			$text = $full;
		}
		return $text;
	}
	
	public function storeToggleData($item, $group, $summary, $full) {
		$this->toggleData[$item['Cart']['id']][$group] = array('summary' => $summary, 'full' => $full);
	}


	public function blub($item, $mode) {
		
	}
	
	public function optionList($item, $mode) {
		
	}
	
	public function modeToggle($item, $action, $isNewItem = FALSE) {
		if (!$isNewItem) {
			return $this->Html->para('tools', 
				$this->Html->link($action, $item['Cart']['id'], array('class' => 'tool toggleDetail', 'bind' => 'click.itemDetailToggle')));
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
		return $this->Html->tag('span', $item['Cart']['total'], array('class' => 'total'));
	}

}
