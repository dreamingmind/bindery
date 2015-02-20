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
	
	/**
	 * The Category Model
	 * 
	 * @var object Model
	 */
	protected $Category;


	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->Category = ClassRegistry::init('Category');
	}
	
	/**
	 * Get the set of workshops that are menu-children of the one who's navline/MenuEntry.route = given-slug
	 * 
	 * Menus were never made with direct links to other models so this is a bit twisted. 
	 * I added category_id to the schema to aid in isolation of workshop navigator/ThemedWorkshop items, since navline/MenuEntrys 
	 * can be reused in ThemedWorkshops but MenuEntrys carry our match field. Without the new field we could 
	 * have backed into multilple ThemedWorkshops hits on a slug, some of them might have been non-workshops
	 * 
	 * @param string $workshop_slug
	 * @return array
	 */
	public function childrenOfTheme($workshop_slug) {
		$menu_label_id = $this->MenuEntry->field('id', array('MenuEntry.route' => $workshop_slug));
		$menu_tree_parent_node_id = $this->field('id', array('navline_id' => $menu_label_id, 'category_id' => $this->Category->categoryNI['workshop']));
		$child_workshop_menu_nodes = $this->find('all', array('conditions' => array(
			'ThemedWorkshop.parent_id' => $menu_tree_parent_node_id),
			'contain' => 'MenuEntry'
		));
		$slugsOfChildrenInTheme = Hash::extract($child_workshop_menu_nodes, '{n}.MenuEntry.route');
		return $slugsOfChildrenInTheme;
	}
	
//	public function descendentsOfTheme($workshop_id) {
//		return $this->children($workshop_id, FALSE);
//	}
	
}
