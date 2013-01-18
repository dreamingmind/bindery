<?php
class ContentCollection extends AppModel {
	var $name = 'ContentCollection';
	var $validate = array(
		'publish' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'content_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'collection_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'seq' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'Content' => array(
			'className' => 'Content',
			'foreignKey' => 'content_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Collection' => array(
			'className' => 'Collection',
			'foreignKey' => 'collection_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Supplement' => array(
			'className' => 'Supplement',
			'foreignKey' => 'content_collection_id',
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
        
        var $displayField = 'Content.heading';
        
        /**
         * Return an array of the most recently used Collections
         * 
         * Default to returning the most recent 10 but passing param can change this.
         * The array is indexed by Collection id and the list item shows
         * Collection heading and category.
         * Recentness is determined by the created date of ContentColletion records
         * that link to the Collection.
         *
         * @return array A Cake list of the most recently used Collections
         */
        function recentCollections($limit=null) {
            $limit = ($limit==null) ? 10 : $limit;
            
            $recentCollections = $this->find('all',array(
                'fields'=>array(
                     'DISTINCT Collection.heading', 'Collection.id','Collection.category_id'
                ),
                'order'=>'ContentCollection.created DESC',
                'limit'=>$limit
            ));
            
            $this->recentCollections = array(' ');
                    
            foreach($recentCollections as $entry){
                $collection_name = $this->Collection->Category->categoryIN[$entry['Collection']['category_id']];
                $this->recentCollections[$entry['Collection']['id']] = 
                    "{$entry['Collection']['heading']} ($collection_name)";
            }
            return $this->recentCollections;
        }

}
?>