<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.User.Model
 */
/**
 * OptinUser Model
 * 
 * The system to track which site services Users have requested.
 * This is the join table between User and Optin.
 * 
 * @package       bindery
 * @subpackage    bindery.User.Model
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