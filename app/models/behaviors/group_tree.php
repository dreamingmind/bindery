<?php 
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.Daa
 */
App::import('Behavior', array('Tree'));

/**
 * GroupTree Behavior
 * 
 * An output packaging method for trees
 * 
 * @package       bindery
 * @subpackage    bindery.Data
*/
class GroupTreeBehavior extends TreeBehavior {
	function generatetreegrouped(&$Model, $conditions = null, $keyPath = null, $valuePath = null, $groupPath = null, $recursive = null) {
		$overrideRecursive = $recursive;
		extract($this->settings[$Model->alias]);
		if (!is_null($overrideRecursive)) {
			$recursive = $overrideRecursive;
		}

		if ($keyPath == null && $valuePath == null && $groupPath == null && $Model->hasField($Model->displayField)) {
			$fields = array($Model->primaryKey, $Model->displayField, 'parent_id', $left, $right);
		} else {
			$fields = null;
		}

		if ($keyPath == null) {
			$keyPath = '{n}.' . $Model->alias . '.' . $Model->primaryKey;
		}

		if ($valuePath == null) {
			$valuePath = '{n}.' . $Model->alias . '.' . $Model->displayField;
		}
		
		if ($groupPath == null) {
			$groupPath = '{n}.' . $Model->alias . '.parent_id';
		}
		
		$order = $Model->alias . '.' . $left . ' asc';
		$results = $Model->find('all', compact('conditions', 'fields', 'order', 'recursive'));
		$stack = array();

		foreach ($results as $i => $result) {
			while ($stack && ($stack[count($stack) - 1] < $result[$Model->alias][$right])) {
				array_pop($stack);
			}
			$stack[] = $result[$Model->alias][$right];
		}
		if (empty($results)) {
			return array();
		}
		return Set::combine($results, $keyPath, $valuePath, $groupPath);
		//return $results;
	}
	
        }
?>