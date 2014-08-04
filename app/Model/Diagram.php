<?php
class Diagram extends AppModel {
	var $name = 'Diagram';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Catalog' => array(
			'className' => 'Catalog',
			'foreignKey' => 'product_group',
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
        
        var $primaryKey = 'product_group';

}
?>