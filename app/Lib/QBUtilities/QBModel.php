<?php
/**
 * QBModel: a cherry-pick tool for quickbooks data
 * 
 * A static class to return an instance of any quickbook model 
 * and static tools to get various kinds of records
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
	
	public static function init($alias) {
		$model = ClassRegistry::init($alias);
		$model->useTable = $alias;
		$model->table = $alias;
		$model->tableToModel = array($alias => $alias);
		$model->useDbConfig = 'qb';
		return $model;
	}
	
	public static function InvItem($field, $val, $like = FALSE) {
		$db = self::init('INVITEM');
		if (!$like) {
			return $db->find('first', array('conditions' => array($field => $val)));
		} else {
			return $db->find('first', array('conditions' => array("$field LIKE" => "%$val%")));
		}
		
	}
}
