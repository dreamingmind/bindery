<?php
class Collection extends AppModel {
	var $name = 'Collection';
	var $validate = array(
		'heading' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ContentCollection' => array(
			'className' => 'ContentCollection',
			'foreignKey' => 'collection_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)	);

        var $actsAs = array('Sluggable'=>array(
            'label'=>'heading',
            'overwrite'=>true,
            'dups' => 'category_id'
        ));
        
        /**
         * Return a Cake list array of all collection headings (indexed by id) grouped by category
         *
         * @return array A cake list array of collections grouped by category
         */
        function allCollections(){
            $collections = $this->find('list',array(
                'fields'=> array('Collection.id','Collection.heading', 'Collection.category_id'),
                'order' => 'Collection.role ASC'
            ));
            foreach($collections as $id => $list){
                $this->allCollections[$this->Category->categoryIN[$id]] = $list;
            }
            
            return $this->allCollections;
        }


}
?>