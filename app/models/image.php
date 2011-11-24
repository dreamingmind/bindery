<?php
class Image extends AppModel {
	var $name = 'Image';
	var $displayField = 'img_file';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Dispatch' => array(
			'className' => 'Dispatch',
			'foreignKey' => 'image_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Exhibit' => array(
			'className' => 'Exhibit',
			'foreignKey' => 'image_id',
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