<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.model
 */
/**
 * Content Model
 * 
 * @package       bindery
 * @subpackage    bindery.model
 * 
 * @property Image $Image
 * @property ExhibitSupliment $ExhibitSupliment
*/
class Content extends AppModel {
	var $name = 'Content';
	var $validate = array(
		'navline_id' => array(
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
            'Image' => array(
                'className' => 'Image',
                'foreignKey' => 'image_id'
            ));
        

        
//        var $hasOne = array('ExhibitSupliment');
        var $hasMany = array(
            'ContentCollection' => array(
                'className' => 'ContentCollection',
                'foreignKey' => 'content_id'
            )

        );    
        
        var $displayField = 'heading';
    
        /**
         * An array of arrays showing collections containing an image
         * $imageCollections[image_id] = array(
         *      'id' => collection name
         * )
         *
         * @var array $imageCollection The collections containing an image
         */
        var $imageCollections = array();
        
        /**
         * An array of all content records and linked data for a collection
         * [0] => Array
         *        (
         *            [content_id] => 474
         *            [content_collection_id] => 303
         *            [image_id] => 887
         *            [date] => 1326395478
         *            [img_file] => DSC01055.JPG
         *            [collections] => Array
         *                (
         *                    [60] => Boxes
         *                    [61] => portfolios
         *                    [78] => PhotoCentral
         *                )
         *
         *        )
         * @var array $collection
         */
        var $collectionPages = array();
        
        /**
         *
         * @var array $collectionNeigbors Neighbor pointers indexed by content_id
         */
        var $collectionNeighbors = array();
        
        var $collectionData = array();
        
    /**
     * Pull the list of Content linked to an Image record
     *
     * @param integer $id The id of the Image record 
     * @return array The list of Content linked to an Image (id => heading)
     */
    function linkedContent($id){
        
        $list = $this->find('list',array(
            'fields'=>array('Content.id','Content.heading'),
            'conditions'=>array('Content.image_id'=>$id)
        ));
        $list = array(0=>' ', 1=>'New')+$list;
        return $list;
    }

    function linkedCollections($id){
        $list = $this->find('all', array(
            'conditions'=>array('Content.image_id'=>$id),
            'contain' => array(
                'ContentCollection'=>array(
                    'fields'=>array(
                        'ContentCollection.collection_id'
                    ),
                    'Collection'=>array(
                        'fields'=>array(
                            'Collection.heading'
                        )
                    )
                )
            )
        ));
        
        if ($list){
            foreach($list as $index => $content){
//                    debug($content);
                foreach($content['ContentCollection'] as $collection){
//                    debug($collection);
                    if(isset($collection['Collection']['heading'])){
                        $collections[$collection['collection_id']] = $collection['Collection']['heading'];
                    }
                }
//                debug($collections);
                $this->imageCollections[$content['Content']['image_id']] = isset($collections) ? $collections : array();
            }
        }
//        debug($list);
//        if($collections){
//            $this->imageCollections[$list[0]['Content']['image_id']][$collection['collection_id']] = $collections;
//        }
//        debug($collections);
        return $collections;
    }
    
    /**
     *
     * @param type $pname
     * @param type $limit 
     */
    function pullCollection($pname, $limit) {
        $test = $this->ContentCollection->Collection->find('first', array(
            'fields'=> array('heading', 'text'),
            'conditions'=> array(
                'Collection.slug' => $pname,
                'Collection.category_id' => $this->ContentCollection->Collection->Category->categoryNI['dispatch']//$category['Category']['id']
            ),
            'contain' => array(
                'ContentCollection'=> array(
                    'fields'=> array('ContentCollection.id'),
                    'Content' => array(
                        'fields' => array('Content.id', 'Content.heading', 'Content.content', 'Content.alt', 'Content.title'),
                        'Image' => array(
                            'fields' => array(
                                'Image.id', 'Image.img_file', 'Image.date', 'Image.alt', 'Image.title'
                            ),
                            'order' => array(
                                'Image.date DESC'
                            )
                        )
                    )
                )
            )
        ));
//        debug($test);die;
        $this->collectionData = $test['Collection'];
//        debug($test['ContentCollection']);die;
        foreach($test['ContentCollection'] as $index => $content){
//            $image_id = (isset($content['Content']['image_id'])) ? $content['Content']['image_id'] : '';

            $collection[] = array(
                'id'=> $content['Content']['id'],
                'heading'=>$content['Content']['heading'],
                'content'=> $content['Content']['content'],
                'alt'=>(!is_null($content['Content']['alt']) && $content['Content']['alt']!='') 
                    ? $content['Content']['alt'] 
                    : $content['Content']['Image']['alt'],
                'title'=>(!is_null($content['Content']['title']) && $content['Content']['title']!='') 
                    ? $content['Content']['title'] 
                    : (isset($content['Content']['Image']['title']))
                        ?$content['Content']['Image']['title']
                        :'Missing title',
                'content_collection_id' => $content['id'],
                'image_id'=> $content['Content']['image_id'],
                'date'=>(isset($content['Content']['Image']['date']))?$content['Content']['Image']['date']:0,
                'img_file'=>(isset($content['Content']['Image']['img_file']))?$content['Content']['Image']['img_file']:'Missing file',
                'collections' => $this->linkedCollections($content['Content']['image_id'])
            );
        }

        $collection = sortByKey($collection, 'date', 'desc');
        
        $this->collectionPages = $collection;
        $this->listNeighbors($this->collectionPages, $limit);
    }
    
    /**
     *
     * @param type $collection
     * @param type $limit 
     */
    function listNeighbors($collection, $limit){
            $max = count($collection)-1;

            foreach ($collection as $index => $locus) {
//                debug($index);
//                debug(intval($index/$limit));
                $neighbors[$locus['id']]['page'] = intval($index/$limit)+1;
                $neighbors[$locus['id']]['count'] = $index+1;
                if ($index == 0) {
                    $neighbors[$locus['id']]['previous'] = $collection[$max]['id'];
                    $neighbors[$locus['id']]['previous_page'] = intval($max/$limit)+1;
                    $neighbors[$locus['id']]['previous_count'] = $max+1;
                } else {
                    $neighbors[$locus['id']]['previous'] = $collection[$index-1]['id'];
                    $neighbors[$locus['id']]['previous_page'] = intval(($index-1)/$limit)+1;
                    $neighbors[$locus['id']]['previous_count'] = $index;
                }
                if ($index == $max) {
                    $neighbors[$locus['id']]['next'] = $collection[0]['id'];
                    $neighbors[$locus['id']]['next_page'] = 1;
                    $neighbors[$locus['id']]['next_count'] = 1;
                } else {
                    $neighbors[$locus['id']]['next'] = $collection[$index+1]['id'];
                    $neighbors[$locus['id']]['next_page'] = intval(($index+1)/$limit)+1;
                    $neighbors[$locus['id']]['next_count'] = $index+2;
                }
                
                $this->collectionPages[$index]['neighbors'] = $neighbors[$locus['id']];
            }
            
        $this->collectionNeighbors = $neighbors;
        
    }
}
?>
