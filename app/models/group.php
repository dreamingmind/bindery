<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.User.Model
 */
/**
 * Group Model
 * 
 * System for categorizing users. These categories are the basis 
 * for making display and feature choices when sending pages to the client
 * 
 * @package       bindery
 * @subpackage    bindery.User.Model
 * @todo The id is used as a access level indicator. This is too arbitrary.
 *       The determination should be made on a hand set value.
 * 
 */
class Group extends AppModel {

	var $name = 'Group';
	var $validate = array(
		'name' => array('notempty')
	);
	var $actsAs = array(
            'Acl' => array('type' => 'requester')//,
//            'Acl' => array('type' => 'controlled')
            );

	function parentNode() {
		return null;
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>