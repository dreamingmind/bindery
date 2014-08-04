<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Navigation
 */
/**
 * Navigator Model
 * 
 * @package       bindery
 * @subpackage    bindery.Navigation
 */
class Navigator extends AppModel {

	var $name = 'Navigator';
	var $actsAs = array('GroupTree', 'Acl' => array('type' => 'controlled'));
        var $displayField = 'Navline.name';
        var $belongsTo = array('Navline');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
//	var $belongsTo = array(
//		'Navline' => array(
//			'className' => 'Navline',
//			'foreignKey' => 'navline_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
//	);
//        var $options = array('joins' =>
//            array('table' => 'navlines',
//                'alias' => 'Navline',
//                'type' => 'LEFT',
//                'conditions' => array('Navigator.navline_id' => 'Navline.id')
//            )
//        );
//        var $hasOne = array(
//            'Navline' => array(
//                'className' => 'Navline',
//        	'foreignKey' => 'id'
//            )
//        );

//        var $virtualFields = array('name'=>'Navline.name');
//        var $hasOne = "Navline";

        function parentNode() {
            return null;
        }

}
?>