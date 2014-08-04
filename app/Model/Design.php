<?php
class Design extends AppModel {
	var $name = 'Design';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Supplement' => array(
			'className' => 'Supplement',
			'foreignKey' => 'supplement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>