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
	
	public $belongsTo = array(
		'MenuEntry' => array(
			'className' => 'Navline',
			'foreignKey' => 'navline_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function childrenOfTheme($workshop_slug) {
		$menu_label_id = $this->MenuEntry->field('id', array('MenuEntry.route' => $workshop_slug));
		$menu_tree_parent_node_id = $this->field('id', array('navline_id' => $menu_label_id, 'category_id' => 1471));
		$child_workshop_menu_nodes = $this->find('all', array('conditions' => array(
			'ThemedWorkshop.parent_id' => $menu_tree_parent_node_id),
			'contain' => 'MenuEntry'
		));
		$slugsOfChildrenInTheme = Hash::extract($child_workshop_menu_nodes, '{n}.MenuEntry.route');
//		dmDebug::ddd($slugsOfChildrenInTheme, 'slugs');
		return $slugsOfChildrenInTheme;
//		dmDebug::ddd($child_workshop_menu_nodes, 'children in theme');
//		dmDebug::ddd(Hash::extract($child_workshop_menu_nodes, '{n}.MenuEntry.route'), 'extracted data');
//		return $this->children($menu_tree_parent_node_id, TRUE);
	}
	
	public function descendentsOfTheme($workshop_id) {
		return $this->children($workshop_id, FALSE);
	}
	
}
