<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.helper
 */

class NestedHelper extends AppHelper {
	function getCategories($key, $categories, &$mainList) {
		$result = '<ul>';
		foreach($categories as $catKey => $name) {
			$result .= $this->getCategory($catKey, $name, $mainList);
		}
		$result .= '</ul>';
		return $result;
	}
	function getCategory($key, $value, &$mainList) {
		$result = '<li>';
//		$result .= $value;
		$result .= "<a href='$value'>$value</a>";
		if(array_key_exists($key, $mainList)) {
			$result .= $this->getCategories($key, $mainList[$key], $mainList);
		}
		$result .= '</li>';
		return $result;
	}
}
?>
