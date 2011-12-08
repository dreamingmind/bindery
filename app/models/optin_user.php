<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.model
 */
/**
 * OptinUser Model
 * 
 * @package       bindery
 * @subpackage    bindery.model
*/
class OptinUser extends AppModel {
	var $name = 'OptinUser';
        var $displayField = 'Optin.name';

	var $belongsTo = array('Optin','User');

//	var $hasMany = array(
//		'ChildAro' => array(
//			'className' => 'Aro',
//			'foreignKey' => 'parent_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		)
//	);
//
//
//	var $hasAndBelongsToMany = array(
//		'Aco' => array(
//			'className' => 'Aco',
//			'joinTable' => 'aros_acos',
//			'foreignKey' => 'aro_id',
//			'associationForeignKey' => 'aco_id',
//			'unique' => true,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'finderQuery' => '',
//			'deleteQuery' => '',
//			'insertQuery' => ''
//		)
//	);
//
//        function parentNode() {
//            return null;
//        }
//

}
?>