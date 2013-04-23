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

    /**
     * Return an alphabetical list of all Content.slug
     * 
     * Returns a select option list. Big hammer approach
     * to allowing blog articles to be linked to any ContentCollection
     * record as detail/supplement reading
     * The index can be parsed for standard blog article retrieval and
     * also includes the first image for the article
     * so a picture link can be constructed
     * 
     * @return array The Collection.id:Content.slug:Image.img_file=>Content.heading list
     */
    function pullArticleList(){
        $rawList = $this->find('all',array(
            'fields'=> array(
                'ContentCollection.id',
                'ContentCollection.collection_id',
                'ContentCollection.content_id'),
            'contain' => array(
                'Collection'=>array(
                    'fields'=>array(
                        'Collection.id',
                        'Collection.category_id'
                    )
                ),
                'Content'=>array(
                    'fields'=>array(
                        'Content.id',
                        'Content.slug',
                        'Content.heading',
                        'Content.image_id'
                    ),
                    'Image'=>array(
                        'fields'=>array(
                            'id',
                            'img_file'
                        )
                    )
                )
            ),
            'group'=>'Content.slug',
            'order' => array(
                'ContentCollection.seq',
                'ContentCollection.modified',
                'Content.slug ASC'
            ),
            'conditions'=>array(
                'Collection.category_id'=>$this->Collection->Category->categoryNI['dispatch']
            )
            ));
        $content[] = 'Link an article';
        array_walk($rawList, 'assembleArticleList', &$content);
        return $content;
    }
    
        function pullForChangeCollection($slug, $id){
            $result = $this->find('all',array(
                'fields'=>array(
                    'ContentCollection.id',
                    'ContentCollection.content_id',
                    'ContentCollection.collection_id',
                    'ContentCollection.sub_slug',
                    'ContentCollection.seq',
                    'ContentCollection.publish'
                ),
                'contain' => array(
                    'Content'=>array(
                        'fields'=>array(
                            'Content.id',
                            'Content.image_id',
                            'Content.alt',
                            'Content.title',
                            'Content.heading',
                            'Content.slug',
                            'Content.content'
                        ),
                        'ContentCollection'=>array(
                            'fields'=>array(
                                'ContentCollection.id',
                                'ContentCollection.content_id',
                                'ContentCollection.collection_id',
                            ),
                            'Collection'=>array(
                                'fields'=>array(
                                    'Collection.id',
                                    'Collection.heading',
                                    'Collection.slug',
                                    'Collection.category_id'
                                ),
                                'Category'=>array(
                                    'fields'=>array(
                                        'Category.id',
                                        'Category.name'
                                    )
                                )
                            )
                        ),
                        'Image'=>array(
                            'fields'=>array(
                                'Image.id',
                                'Image.img_file',
                                'Image.alt',
                                'Image.title'
                            )
                        )
                    )
                ),
                'conditions'=>array(
                    'Content.slug'=>$slug,
                    'ContentCollection.collection_id'=>$id
                )
            ));
            return $result;
        }

}

function assembleArticleList(&$record, $key, $content){
//    debug($record);
    $content[$record['Collection']['id'] . ':' . $record['Content']['slug'] . ':' . $record['Content']['Image']['img_file']] = $record['Content']['heading'];
}
?>