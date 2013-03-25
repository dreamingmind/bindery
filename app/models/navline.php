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
 * Navline Model
 * 
 * @package       bindery
 * @subpackage    bindery.model
 */
class Navline extends AppModel {
	var $name = 'Navline';
        //var $actsAs = array('Acl' => array('type' => 'controlled'));
        //var $virtualFields = array('nameData' => "CONCAT(Navline.name, ' (', Navline.route_type, ')')");

	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Navigator' => array(
			'className' => 'Navigator',
			'foreignKey' => 'navline_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)//,
//            'Content' => array(
//                'className'=>'Content',
//                'foreignKey'=>'navline_id'
//                )
            
	);


        function parentNode() {
            return null;
        }

}
?>