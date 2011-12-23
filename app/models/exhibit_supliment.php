<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.model
*/
/**
 * ExhibitSupliment Model
 * 
 * @package       bindery
 * @subpackage    bindery.model
 * @property Content $Content
 */
class ExhibitSupliment extends AppModel {
	var $name = 'ExhibitSupliment';
	var $validate = array(
		'image_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'exhibit_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
//		'Image' => array(
//			'className' => 'Image',
//			'foreignKey' => 'image_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
//		'Exhibit' => array(
//			'className' => 'Exhibit',
//			'foreignKey' => 'exhibit_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		),
		'Content' => array(
			'className' => 'Content',
			'foreignKey' => 'content_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
}
?>