<?php
App::uses('AppModel', 'Model');

/**
 * ThemedWorkshop allows Workshops to be accessed based on the nested navigational menu structure
 * 
 * @author dondrake
 */
class ThemedWorkshop extends AppModel {
	
	public $useTable = 'navigators';
	
	public $actsAs = array('Tree');
	
	public function childrenOfTheme($workshop_id) {
		return $this->children($workshop_id, TRUE);
	}
	
	public function descendentsOfTheme($workshop_id) {
		return $this->children($workshop_id, FALSE);
	}
	
}
