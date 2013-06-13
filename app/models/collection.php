<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * Collection Model
 * 
 * This is a high level classification of site Articles. Each Collection will
 * have a Category and will contain many Articles.
 * 
 * The basic structual chain for Content is:
 * <pre>
 *                                                      |<--Supplement
 * Category<--Collection<--ContentCollection-->Content--|
 *                                                      |-->Image
 * |         |            |                  |                     |
 * | Content |            |                  |                     |
 * | Filter  |Article Sets| Article Assembly |     Article Parts   |
 * </pre>
 * <ul>
 * 
 * <li>Each Collection is a member of a Category</li>
 * <li>Collections may share the same Collection.heading but if they are in different Categories, they are different Collections</li>
 * <li>The name 'Collection' refers to the roll of these records—to collect Articles
 *     <ul>
 *     <li>Articles are sets of Content records with the same Content.heading which are members of a single Collection</li>
 *     <li>Content records may share a Content.heading but if they are in different Collections they will be in different articles</li>
 *     <li>There is a join table between Collections and their Content (see Content Model for more info)</li>
 *     </ul>
 * </li>
 * </ul>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 * 
*/
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
                    ),
                'Catalog' => array(
			'className' => 'Catalog',
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
                    )                );

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

        function articleTOC($category){
            $tocbase = $this->find('all',array(
                'fields'=>array(
                    'Collection.id',
                    'Collection.category_id',
                    'Collection.slug',
                    'Collection.heading'),
                'contain'=>array(
                    'ContentCollection'=>array(
                        'fields'=>array(
                            'ContentCollection.content_id',
                            'ContentCollection.collection_id',
                            'ContentCollection.publish'
                        ),
                        'Content'=>array(
                            'fields'=>array(
                                'Content.id',
                                'Content.heading',
                                'Content.slug'
                            )
                        ),
                        'conditions'=>array('ContentCollection.publish'=>1)
                    )
                ),
                'conditions'=>array(
                    'Collection.category_id'=>$this->Category->categoryNI[$category]
                ),
                'group'=>'Collection.slug'
            ));
            foreach($tocbase as $index => $collection){
                $level_id = $collection['Collection']['id'];
                $level_slug = $collection['Collection']['slug'];
                $toc['lookup'][$level_slug] = $level_id;
                $toc[$level_id] = $collection['Collection'];
                $i = 0;
                while($i < count($collection['ContentCollection'])){
                    $toc[$level_id]['Titles'][$collection['ContentCollection'][$i]['Content']['slug']] = $collection['ContentCollection'][$i]['Content']['heading'];
                    $i++;
                }
            }
            return $toc;
        }
        
        public function getPriceTable($pname){
            $result =  $this->find('all', array(
                'fields' => array(
                    'Collection.id',
                    'Collection.slug',
                    'Collection.category_id'
                ),
                'contain' => array(
                    'Category' => array(
                        'fields' => array(
                            'Category.id',
                            'Category.name'
                        )
                    ),
                    'Catalog' => array(
                        'fields' => array(
                            'Catalog.collection_id',
                            'Catalog.yy_index',
                            'Catalog.y_index',
                            'Catalog.xx_index',
                            'Catalog.x_index',
                            'Catalog.price',
                            'Catalog.product_code',
                            'Catalog.category'
                        ),
                        'order' => array(
                            'Catalog.category',
                            'Catalog.yy_index',
                            'Catalog.y_index',
                            'Catalog.xx_index',
                            'Catalog.x_index',
                        )
                    )
                ),
                'conditions' => array(
                    'Collection.slug' => $pname,
                    'Category.name' => 'exhibit'
                )
                )
            );
            
            $package = array('Collection' => $result[0]['Collection']);
            $base = array(0, $result[0]['Catalog'][0]['category']);
            foreach($result[0]['Catalog'] as $index => $category){
                if($base[1] != $category['category']){
                    $package['Catalog'][$base[1]] = array_slice($result[0]['Catalog'], $base[0], $index - $base[0]);
                    $base = array(0 => $index, 1 => $category['category']);
                }
                $package['Catalog'][$base[1]] = array_slice($result[0]['Catalog'], $base[0], $index - $base[0]);
            }
            return $package;
        }
}
?>