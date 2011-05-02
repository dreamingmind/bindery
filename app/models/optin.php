<?php
class Optin extends AppModel {
	var $name = 'Optin';
        //var $displayField = 'Optin.name';

	var $hasMany = array('OptinUser');

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