<?php
class Request extends AppModel {
	var $name = 'Request';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Workshop' => array(
			'className' => 'Workshop',
			'foreignKey' => 'workshop_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>