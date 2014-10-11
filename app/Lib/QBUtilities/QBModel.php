<?php
/**
 * QBModel: a cherry-pick tool for quickbooks data
 * 
 * A static class to return an instance of any quickbook model 
 * and static tools to get various kinds of records via cache or query
 * 
 * There are so many quickbooks tables, it might be a nuisence to make actual 
 * model classes for all of them. And, they will never have to do C, U or D calls 
 * nor any of the normal callback methods. So I'm going to try this static class. 
 * Ask for a generic Model instance for any of the tables, or call one of the 
 * getter methods to do simple, single record retrievals on single conditions.
 *
 * @author dondrake
 */
class QBModel {
	
	/**
	 * Return the named Model object from the QB set
	 * 
	 * This will be handy if you wanted to do more complex tasks 
	 * which don't have standing methods available in this Class 
	 * 
	 * @param string $alias 
	 * @return object
	 */
	public static function init($alias) {
		$model = ClassRegistry::init($alias);
		$model->useTable = $alias;
		$model->table = $alias;
		$model->tableToModel = array($alias => $alias);
		$model->useDbConfig = 'qb';
		return $model;
	}
	
	/**
	 * Get query or cache data from INVITEM conditioned on one field
	 * 
	 * The field condition can be an 'equal' match or a %LIKE%
	 * 
	 * @param string $field The field to search
	 * @param string $val The value to search for
	 * @param boolean $like Whether to do a LIKE search or not
	 * @return array
	 */
	public static function InvItem($field, $val, $like = FALSE) {
		// make cache key values
		$f = strtolower($field);
		$v = strtolower(preg_replace('/[^A-Za-z0-9]+/', '-', $val));
		$l = $like ? '1' : '0';
		
		if (! $result = Cache::read("{$f}_{$v}_{$l}", 'qb')) {
			$db = self::init('INVITEM');
			if (!$like) {
				$result = $db->find('first', array('conditions' => array($field => $val)));
			} else {
				$result = $db->find('first', array('conditions' => array("$field LIKE" => "%$val%")));
			}
			Cache::write("{$f}_{$v}_{$l}", $result, 'qb');
		}
		return $result;
	}
	
	/**
	 * Return the queried or cached price list
	 * 
	 * This is all the items in INVITEM keyed: NAME => PRICE 
	 * or if $code is TRUE, code => PRICE. 
	 * code is the last portion of the NAME excluding all parent categories
	 * sample NAME [ Editions:Collab:KJ:Conversation:song ]
	 * 
	 * @param boolean $code key the array with only the last portion of NAME (the item code)
	 * @return array
	 */
	public static function priceList($code = FALSE) {
		
		if (!$prices = Cache::read('qbPrices', 'qb')) {
			$db = self::init('INVITEM');
			$prices = $db->find('list', array('fields' => array('NAME', 'PRICE')));
			Cache::write('qbPrices', $prices, 'qb');
		}
		if ($code) {
			if (!$codePrices = Cache::read('qbCodePrices', 'qb')) {
				$codePrices = array();
				foreach ($prices as $name => $price) {
					$nodes = explode(':', $name);
					$codePrices[array_pop($nodes)] = $price;
				}
				Cache::write('qbCodePrices', $codePrices, 'qb');
			}
			$prices = $codePrices;
		}
		return $prices;
	}
}
