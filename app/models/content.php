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
        
        var $actsAs = array('Sluggable'=>array(
            'label'=>'heading',
            'overwrite'=>true,
            'dups' => 'id',
            'translate' => true
        ));
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
         * The data under Collection.slug pname where Collection->Category is dispatch
         * 
         * This is a standard Cake data array and is rewritten into $collectionPages
         *
         * @var array $collectionData
         */
        var $collectionData = array();
        
        /**
         * Indexed by Content.id, shows all page, next and previous values
         * 
         * @var array $collectionNeigbors Neighbor pointers indexed by content_id
         */
        var $collectionNeighbors = array();
        
        /**
         * An array of all content records and linked data for a collection
         * 
         * This is a non-standard array
         *  [1] => Array
         *      [collection_id] => 60
         *      [id] => 498 //Content.id
         *      [heading] => Lucha Libre!
         *      [slug] => lucha-libre
         *      [content] => This material is not the traditional...way. 
         *      [alt] => Non-traditional cloth to be used in a binding project
         *      [title] => Lucha Libre!
         *      [content_collection_id] => 457
         *      [image_id] => 846
         *      [date] => 1359137576 //image exif date
         *      [img_file] => DSC01670.JPG
         *      [collections] => Array
         *          [132] => Array //collection_id
         *              [0] => materials //Collection.heading
         *              [1] => materials //Collection.slug
         *          [60] => Array
         *              [0] => Boxes
         *              [1] => boxes
         *      [neighbors] => Array
         *          [page] => 1
         *          [count] => 2
         *          [previous] => 562
         *          [previous_page] => 1
         *          [previous_count] => 1
         *          [next] => 561
         *          [next_page] => 1
         *          [next_count] => 3
         * 
         * @var array $collectionPages
         */
        var $collectionPages = array();
        
        /**
         * Filter for newsfeed search returns
         * 
         * The recentNews method will pull for a pname. But if none
         * is provided, it would pull indiscriment and inappropriated dispatches 
         * without this filter will make mark a menu level and its submenu 
         * navline slugs will be the filter set to limit returns.
         * This strategy lets recentNews to act as a submenu preview.
         *
         * @var string Slug at a menu level to filter newsfeed returns
         */
        var $recentNewsFilter = 'products';
        
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

    /**
     * Given an image_id, get the Collections that contain it
     * 
     * In addition to the returned array for the specific image_id
     * this method sets an element in the imageCollections property. 
     * Multiple calls will accumlate into the property. 
     * It's form is:
     * Array
     *  [545] => Array      //image_id
     *      [60] => Array   //collection_id
     *          [0] => Boxes
     *          [1] => boxes
     * 
     * @param integer $image_id
     * @return array collection_id indexed, heading and slug elements
     */
    function linkedCollections($image_id){
        $list = $this->find('all', array(
            'conditions'=>array('Content.image_id'=>$image_id),
            'contain' => array(
                'ContentCollection'=>array(
                    'fields'=>array(
                        'ContentCollection.collection_id'
                    ),
                    'Collection'=>array(
                        'fields'=>array(
                            'Collection.heading',
                            'Collection.slug'
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
                        $collections[$collection['collection_id']] = array(
                            $collection['Collection']['heading'],
                            $collection['Collection']['slug']
                        );
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
     * Get the data for a Newsfeed page
     * 
     * This gets a standard data array and puts it in property collectionData
     * And process the data into a non standard array in property collectionPages
     * It also makes a call to assemble collectionNeighbor property and 
     * fold that data into collectionPages too.
     * 
     * Is this any way to run a rodeo?
     *
     * @param string $pname The Collection.slug (better be a 'dispatch' collection
     * @param integer $limit Builds neighbor data, but doesn't limit the find
     */
    function pullCollection($pname, $limit) {
        $test = $this->ContentCollection->Collection->find('first', array(
            'fields'=> array('heading', 'text','slug'),
            'conditions'=> array(
                'Collection.slug' => $pname,
                'Collection.category_id' => $this->ContentCollection->Collection->Category->categoryNI['dispatch']//$category['Category']['id']
            ),
            'contain' => array(
                'ContentCollection'=> array(
                    'fields'=> array('ContentCollection.id'),
                    'Content' => array(
                        'fields' => array('Content.id', 'Content.heading', 'Content.content', 'Content.alt', 'Content.title','Content.slug'),
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
                'collection_id' => $test['Collection']['id'],
                'id'=> $content['Content']['id'],
                'heading'=>$content['Content']['heading'],
                'slug'=>$content['Content']['slug'],
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
     * Assemble neighbor data for newsfeed page/next/previous link assembly
     * 
     * $this->collectionPages also gets these blocks parsed into it
     * so each Content record has all its data and this stuff too.
     *
     * @param type $collection The collectionPages property
     * @param type $limit Number of records in a page/thumbnail set
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
    
    /**
     * Get the 'n' most recent exhibits
     * 
     * This is fairly simple because (and as long as) there is only
     * single record exhibits. Newsfeed/blog articles are more 
     * difficult to find the unique most recent
     * 
     * @param integer $limit How many recent exhibits to return
     * @param string $pname Which exhibit Collection.slug to target
     * @return array The found exhibit records
     */
    function recentExhibits($limit = null, $pname = null){        
        $limit = ($limit == null) ? 10 : $limit;
        $product_condition = 
            ($pname == null 
                || ! $pname = $this->ContentCollection->Collection->find('first',array(
                    'conditions'=>array(
                        'Collection.category_id'=>
                            $this->ContentCollection->Collection->Category->categoryNI['exhibit'],
                        'Collection.slug'=>$pname
                    ),
                    'contain'=>array(false))))
            ? ''
            : 'ContentCollection.collection_id = ' . $pname['Collection']['id'];
        return $most_recent = $this->ContentCollection->find('all',array(
            'fields'=>array('DISTINCT ContentCollection.content_id','ContentCollection.collection_id'),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array('Collection.id','Collection.category_id', 'Collection.heading', 'Collection.slug')
                ),
                'Content'=>array(
                    'fields'=>array('Content.id','Content.content','Content.heading', 'Content.slug'),
                    'Image'=>array(
                        'fields'=>array('Image.alt','Image.title','Image.img_file')
                    )
                )
            ),
            'order'=>'ContentCollection.created DESC',
            'conditions'=>array('Collection.category_id'=>
                $this->ContentCollection->Collection->Category->categoryNI['exhibit'],
                $product_condition),
            'limit'=>$limit
        ));
    }
    
    /**
     * @todo Make this pull other recent category data by passing ->categoryNI[]
     * @todo Improve the link-creation ability by getting neighbor data so the page can be known
     * @todo Can this serve as a model for getting search result sets? 
     * Pull data for the $limit more recent Content entries on distinct Content.headings
     *    [0] => Array
     *      [Content] => Array
     *              [heading] => Catching up after the holidays
     *              [id] => 481
     *              [slug] => catching-up-after-holidays
     *              [content] => Here are the liners...
     *              [created] => 2013-01-11 12:15:38
     *      [Image] => Array
     *              [id] => 828
     *              [title] => Catching up after the holidays
     *              [alt] => Liners for a portfolio trimmed up a...
     *              [img_file] => DSC01566.JPG
     *      [ContentCollection] => Array
     *              [0] => Array
     *                      [content_id] => 481
     *                      [collection_id] => 61
     *                      [publish] => 1
     *                      [Collection] => Array
     *                              [id] => 61
     *                              [category_id] => 1469
     *                              [heading] => Portfolios
     *                              [slug] => portfolios
     * 
     * @param int $limit How many records to pull, default 10
     * @return array The data, most recent dispatch entries, each on a different Content.heading
     */
   function recentNews($limit=null, $pname = null){
        $limit = ($limit == null) ? 10 : $limit;
        // if no pname
        // OR if a search on slug==pname returns false
        // condition is 'only collections that are menu choices under "Products"'
        if($pname==null || !$this->ContentCollection->Collection->findByslug($pname)){
            $products = $this->query("select route from navlines where id IN 
                (select navline_id from navigators where parent_id = 
                    (select id from navigators where navline_id = 
                        (select id from navlines where route = '{$this->recentNewsFilter}')))");
            $inlist = '';
            $comma = '';
            foreach($products as $product){
                $inlist .= "$comma'{$product['navlines']['route']}'";
                $comma = ',';
            }
            $inlist = "IN($inlist)";
            $product_condition = 'Collection.slug ' . $inlist;
        } else {
            $pname = $this->ContentCollection->Collection->findByslug($pname);
            $product_condition = 'ContentCollection.collection_id = ' . $pname['Collection']['id'];
        }
        // ---------------------------------------------
        // This pulls the most recent 50 Content.ids that are 'dispatch' Category
        // It's assumed that this range will include 10 unique Content.headings
        // This list of ids will be formatted (id1,id2,id3...) for use 
        // later in a WHERE x IN () statement
        $id_list = $this->ContentCollection->find('all',array(
            'fields'=>array(
                'ContentCollection.content_id',
                'ContentCollection.collection_id',
                'ContentCollection.publish'
            ),
            'contain'=>array(
                'Collection'=>array(
                    'fields'=>array(
                        'Collection.id',
                        'Collection.category_id'
                    )
                ),
                'Content'),
            'conditions'=>array(
                'Collection.category_id'=>
                $this->ContentCollection->Collection->Category->categoryNI['dispatch'],
                $product_condition,
                'ContentCollection.publish'=>1),
            'limit'=>$limit,
            'group'=>'Content.slug',
            'order'=>'ContentCollection.modified DESC'
            
        ));
        
        $in = $c = '';
        foreach($id_list as $record){
            $in .= $c.$record['ContentCollection']['content_id'];
            $c = ',';
        } 
        // the IN () list is done and stored in $in
        // ---------------------------------------------

        // ---------------------------------------------
        // This will construct the subquery to isolate
        // the unique (on Content.heading) records
        // to the MOST RECENT entry of that Content.heading
//        $dbo = $this->getDataSource();
//        $subQuery = $dbo->buildStatement(
//            array(
//                'fields' => array('MAX(`c2`.`modified`)'),
//                'table' => $dbo->fullTableName('contents'),
//                'alias' => 'c2',
//                'limit' => null,
//                'offset' => null,
//                'joins' => array(),
//                'conditions' => array('`Content`.`heading`  = `c2`.`heading`'),
//                'order' => null,
//                'group' => null
//            ),
//            $this->alias
//        );
//        $subQuery = ' `Content`.`modified` = (' . $subQuery . ') ';
//        $subQueryExpression = $dbo->expression($subQuery);

        // ---------------------------------------------
        
        $this->recent_news = $this->find('all', array(
            'fields'=>array(
                'Content.heading',
                'Content.id',
                'Content.slug',
                'Content.content',
                'Content.created',
                'Content.modified'
            ),
            'group'=>array('Content.heading'),
            'order'=>array('Content.modified DESC'),
            'limit'=>$limit,
            'contain'=>array(
                'Image'=>array(
                    'fields'=>array(
                        'Image.id',
                        'Image.title',
                        'Image.alt',
                        'Image.img_file'
                    ),
                ),
                'ContentCollection'=>array(
                    'fields'=>array(
                        'ContentCollection.content_id',
                        'ContentCollection.collection_id',
                        'ContentCollection.publish'
                    ),
                    'Collection'=>array(
                        'fields'=>array(
                            'Collection.id',
                            'Collection.category_id',
                            'Collection.heading',
                            'Collection.slug'
                        ),
                        'conditions'=>array(
                            'Collection.category_id'=>
                            $this->ContentCollection->Collection->Category->categoryNI['dispatch'])
                    )
                )
            ),
            'conditions'=>array(
//                $subQueryExpression,
                "Content.id IN ($in)"
            )
        ));
      
//        foreach($news as $record){
//            $this->recent_news_list[$record['Content']['slug']]=$record['Content']['heading'];
//        }
        return $this->recent_news;
    }


    /**
     * Query using the user's conditions and return the processed results
     * 
     * Request the raw search, then return the grouped results
     * group under Category.name - Content.slug indexes
     * Only one of each Content.slug is kept but the count found is recorded
     * 
     * [dispatch] => Array //Collection's Category.name
            [unbacked-cloth] => Array //Content.slug
                [Content] => Array
                    fields => data
                [Image] => Array
                    fields => data
                [ContentCollection] => Array
                    [0] => Array
                        fields => data
                            [Collection] => Array
                                fields => data
                [count] => 3 //number of Content found on search with this Content.slug 

     * @param array $conditions Cake conditions array for the query
     * @return false|array False or the found records
     */
    
    function siteSearch($conditions){
        
     $raw_search = $this->siteSearchRaw($conditions);
     
     if($raw_search){
         $categories = $this->ContentCollection->Collection->Category->categoryIN;
         foreach($categories as $name){
             $result_groups[$name] = false;
         }
         
         foreach($raw_search as $result){
             $slot = $categories[$result['ContentCollection'][0]['Collection']['category_id']];
             if(isset($result_groups[$slot][$result['Content']['slug']]['count'])){
                 $result_groups[$slot][$result['Content']['slug']]['count'] += 1;
             } else {
                 $result_groups[$slot][$result['Content']['slug']] = $result;
                 $result_groups[$slot][$result['Content']['slug']]['count'] = 1;
             }
         }
         return $result_groups;
     }
     return $raw_search;
    }

    /**
     * Query using the user's conditions and return the results
     * 
     * @param array $conditions Cake conditions array for the query
     * @return false|array False or the found records
     */
    function siteSearchRaw($conditions){
        
     return $this->find('all', array(
        'contain'=>array(
            'Image',
            'ContentCollection'=>array(
                'fields'=>array(
                    'ContentCollection.id',
                    'ContentCollection.seq',
                    'ContentCollection.content_id',
                    'ContentCollection.collection_id',
                    'ContentCollection.publish'
                ),
                'Collection'=>array(
                    'fields'=>array(
                        'Collection.id',
                        'Collection.category_id',
                        'Collection.heading',
                        'Collection.slug'
                    )
                )
            )),
            'conditions'=>$conditions
        ));
    }
}
?>
