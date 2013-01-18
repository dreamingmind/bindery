<?php
class Category extends AppModel {
	var $name = 'Category';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Collection' => array(
			'className' => 'Collection',
			'foreignKey' => 'category_id',
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

        /**
         * @var array $categoryNI list of categories name => id
         */
        var $categoryNI;
        
        /**
         * @var array $categoryIN list of categories id => name
         */
        var $categoryIN;
        
        public function __construct($id = false, $table = null, $ds = null) {
            parent::__construct($id, $table, $ds);
            
            $this->categoryIN = $this->find('list');
            $this->categoryNI = $this->find('list',array('fields'=>array('name','id')));
        }

}
?>