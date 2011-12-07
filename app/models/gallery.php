<?php
class Gallery extends AppModel {
	var $name = 'Gallery';
//	var $validate = array(
//		'name' => array(
//			'notempty' => array(
//				'rule' => array('notempty'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

        var $hasMany = array('DispatchGallery');
        
	var $hasAndBelongsToMany = array(
//		'Dispatch' =>
//			array (
//				'className'=>'Dispatch',
//				'joinTable'=>'dispatch_galleries',
//				'foreignKey'=>'gallery_id',
//				'associationForeignKey'=>'dispatch_id',
//				'unique'=>true,
//				'conditions'=>'',
//				'fields'=>'',
//				'order'=>'',
//				'limit'=>'',
//				'offset'=>'',
//				'finderQuery'=>'',
//				'deletQuery'=>'',
//				'insertQuery'=>'',
//			),
                'Exhibit' =>
			array (
				'className'=>'Exhibit',
				'joinTable'=>'exhibit_galleries',
				'foreignKey'=>'gallery_id',
				'associationForeignKey'=>'exhibit_id',
				'unique'=>true,
				'conditions'=>'',
				'fields'=>'',
				'order'=>'',
				'limit'=>'',
				'offset'=>'',
				'finderQuery'=>'',
				'deletQuery'=>'',
				'insertQuery'=>'',
			)
	);
        var $displayField = 'role';

}
?>