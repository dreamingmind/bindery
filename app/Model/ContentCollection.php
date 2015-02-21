<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.Article
 */

/**
 * ContentCollection Model
 * 
 * This is the join table between Collections and Content.
 * It allows a single Content record to be attached to several Collections
 * and hence be part of more than one Article.
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
 * <li>ContentCollections serve 3 major functions
 *     <ul>
 *     <li>ContentCollection.publish controlls whether the Content record is gathered as part of the Article</li>
 *     <li>ContentCollection.sub_slug serves a link to another Article. This second Artilcle can provide more 
 * detail about the Content its linked to.</li>
 *     <li>ContentCollection.collection_id provides the second piece of information to create and article. The two 
 * requirements are a shared Content.heading and a shared ContentCollection.collection.id</li>
 *     </ul>
 * </li>
 * </ul>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 * 
 */
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
        ),
        'Workshop' => array(
            'className' => 'Workshop',
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
     * The ContentCollection fields for full knowledge of this article node
     * 
     * include all links and sorting, publishing and detailing info
     *
     * @var array 'fields' element of a query param
     */
    var $bigFields = array('fields' => array(
            'ContentCollection.id',
            'ContentCollection.content_id',
            'ContentCollection.collection_id',
            'ContentCollection.sub_slug',
            'ContentCollection.seq',
            'ContentCollection.publish'
            ));

    /**
     * The linked fields for full knowledge of this article nodes Content
     * 
     * This contain provides all fields for display of a Content record
     * its Image, its use in other articles and Collections
     * This is 'the whole enchilada' for use with $this->bigFields
     *
     * @var array 'contain' fields for a query
     */
    var $bigContain = array(
        'Content' => array(
            'fields' => array(
                'Content.id',
                'Content.image_id',
                'Content.alt',
                'Content.title',
                'Content.heading',
                'Content.slug',
                'Content.content',
                'Content.created'
            ),
            'ContentCollection' => array(
                'fields' => array(
                    'ContentCollection.id',
                    'ContentCollection.content_id',
                    'ContentCollection.collection_id',
                ),
                'Collection' => array(
                    'fields' => array(
                        'Collection.id',
                        'Collection.heading',
                        'Collection.slug',
                        'Collection.category_id'
                    ),
                    'Category' => array(
                        'fields' => array(
                            'Category.id',
                            'Category.name'
                        )
                    )
                )
            ),
            'Image' => array(
                'fields' => array(
                    'Image.id',
                    'Image.img_file',
                    'Image.alt',
                    'Image.title'
                )
            )
        )
    );

    /**
     * Minimum fields for a query param. Links only
     *
     * @var array ContentCollection link fields only
     */
    var $smallFields = array('fields' => array(
            'ContentCollection.id',
            'ContentCollection.collection_id',
            'ContentCollection.content_id'));

    /**
     * Minimum 'contain' fields for a query
     * 
     * Useful only for drop-list contstrucion or 
     * super simple picture/text article link construction
     * No Collection name or Image alt data
     *
     * @var array Minimum 'contain' fields for a query
     */
    var $smallContain = array(
        'Collection' => array(
            'fields' => array(
                'Collection.id',
                'Collection.category_id'
            )
        ),
        'Content' => array(
            'fields' => array(
                'Content.id',
                'Content.slug',
                'Content.heading',
                'Content.image_id'
            ),
            'Image' => array(
                'fields' => array(
                    'id',
                    'img_file')
            )
        )
    );

    /**
     * Basic 'contain' fields for a query
     * 
     * Useful for link-block construction
     * Provides text/slug and ids for Collection and Content
     * as well as Content.content and Image alt/title data
     * But it's shallow. No knowledge of additional 
     * Content use is provided.
     *
     * @var array Basic 'contain' fields for a query
     */
    var $linkContain = array(
        'Collection' => array(
            'fields' => array(
                'Collection.id',
                'Collection.heading',
                'Collection.slug',
                'Collection.category_id'
            ),
            'Category'
        ),
        'Content' => array(
            'fields' => array(
                'Content.id',
                'Content.heading',
                'Content.slug',
                'Content.content',
                'Content.image_id',
                'Content.created'
            ),
            'Image' => array(
                'fields' => array(
                    'Image.id',
                    'Image.img_file',
                    'Image.alt',
                    'Image.title'
                )
            )
        )
    );

	var $contain;
	
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
    function recentCollections($limit = null) {
        $limit = ($limit == null) ? 10 : $limit;

        $recentCollections = $this->find('all', array(
            'fields' => array(
                'DISTINCT Collection.heading', 'Collection.id', 'Collection.category_id'
            ),
            'order' => 'ContentCollection.created DESC',
            'limit' => $limit
                ));

        $this->recentCollections = array(' ');

        foreach ($recentCollections as $entry) {
            $collection_name = $this->Collection->Category->categoryIN[$entry['Collection']['category_id']];
            $this->recentCollections[$entry['Collection']['id']] =
                    "{$entry['Collection']['heading']} ($collection_name)";
        }
        return $this->recentCollections;
    }

    /**
     * Given a limit and Category, pull link data for the most recent articles
     * 
     * Default params will return the 8 most recent blog articles
     * 
     * @todo make this return the first Content in the article sequence so I can control the link image by crafting the article
     * @return array Data to build links to the most recent articles in a Category
     */
    function recentBlog($limit = 8, $category = 'dispatch') {
        $this->contain($this->linkContain);
        $this->contain['Content']['group'] = 'Content.slug';
        $this->contain['Contnet']['order'] = 'Content.created DESC';

        $fields = $this->bigFields;
        $fields['fields'][] = 'ContentCollection.created';
        $fields['fields'][] = 'Content.created';

        $order = array('order' => array(
                'ContentCollection.created DESC',
                'ContentCollection.seq ASC'));
        $limit = array('limit' => $limit);
        $group = array('group' => 'Content.slug');

        $conditions = array('conditions' => array(
                'Collection.category_id' => $this->Collection->Category->categoryNI[$category]
                ));
        return $this->find('all', $fields + $conditions + $order + $limit + $group
        );
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
    function pullArticleList($category = 'dispatch') {
        $this->contain($this->smallContain);
        $this->order = array('Content.slug ASC');
        $rawList = $this->find('all', $this->smallFields + array(
            'group' => 'Content.slug',
            'conditions' => array(
                'Collection.category_id' => $this->Collection->Category->categoryNI[$category]
            )
                ));
        $content[] = 'Link an article';
        array_walk($rawList, 'assembleArticleList', $content);
        return $content;
    }

    /**
     * Given a Collection.id and Content.slug pull an article
     * 
     * This gives data for for the change_collection tool
     * But could serve elsewhere.
     * 
     * @param type $slug A Content.slug
     * @param integer $id A Collection.id
     * @return array All the data for an article
     */
    function pullForChangeCollection($slug, $id) {
        $conditions = array('conditions' => array(
                'Content.slug' => $slug,
                'ContentCollection.collection_id' => $id
                ));
        $this->contain($this->bigContain);
        $result = $this->find('all', $this->bigFields + $conditions);
        return $result;
    }

    /**
     * Given a slug pull a link for an article in that Collection.slug
     * 
     * Landing on an art page that has no Collection Content
     * We want links for other Collections deeper in the menu nest
     * This will return one link for a slug if it exists
     * 
     * @param string $slug A possibly Collection slug
     * @return array One data packet for a link block
     */
    function nodeMemeber($slug) {
        //I might want to Order this to get the first/title image
        $conditions = array('conditions' => array(
                'Collection.category_id' => $this->Collection->Category->categoryNI['art'],
                'Content.slug' => $slug
                ));
        $this->contain($this->linkContain);
        $fields = $this->smallFields;
        return $this->find('first', $fields + $conditions);
    }

    /**
     * Pull data for a link given a ContentCollection.id
     * 
     * Finding a detail-article link in a ContentCollection
     * record that link will be a ContentCollection.id
     * This will pull data so we can construct a link to
     * that detail article
     * 
     * @param integer $id ContentCollection.id
     * @return array One data packet for a link block
     */
    function pullArticleLink($id) {
        //I might want to Order this to get the first/title image
        $conditions = array('conditions' => array(
                'ContentCollection.id' => $id
                ));
        $this->contain($this->linkContain);
        $fields = $this->bigFields;
        return $this->find('first', $fields + $conditions);
    }

    /**
     * Pull data for a link of an article that has a detail
     * 
     * This will find the article that refers to id
     * as a detail article.
     * 
     * @param integer $id ContentCollection.id
     * @return array One data packet for a link block
     */
    function pullParentLink($id) {
        //I might want to Order this to get the first/title image
        $conditions = array('conditions' => array(
                'ContentCollection.sub_slug' => $id
                ));
        $this->contain($this->linkContain);
        $fields = $this->bigFields;
        return $this->find('all', $fields + $conditions);
    }

    /**
     * Given a collection_id get links to $limit articles on the collection
     * 
     * @param integer $collection_id The collection to focus on
     * @return array Packet of links to the articles in the collection
     */
    function pullRelatedArticles($collection_id) {
        $conditions = array('conditions' => array(
                'ContentCollection.collection_id' => $collection_id
                ));
//        $this->contain($this->linkContain);
        $this->contain($this->linkContain);
        $fields = $this->bigFields;
        return $this->find('all', $fields + $conditions + array(
                    'group' => 'Content.slug'
                ));
//        return $relatedArticles;
    }

    /**
     * Return some batch of Content records sorted by article order
     * 
     * These are pulled from ContentCollection context so there may be
     * more be a variety of results.
     * $condition can look at 
     *      ContentCollection
     *      Collection
     *      Content
     * 
     * @param array $conditions The ContentCollection conditions for the query
     * @return boolean|array A batch of Content/Image records or false
     */
    function findWorkshopTarget($conditions = null) {
        if ($conditions == null) {
            return false;
        }
        return $this->find('all', array(
                    'fields' => array(
                        'ContentCollection.id',
                        'ContentCollection.content_id',
                        'ContentCollection.collection_id',
                        'ContentCollection.sub_slug'),
                    'contain' => array(
                        'Workshop' => array(
                            'fields' => array('Workshop.id', 'Workshop.category_id', 'Workshop.slug', 'Workshop.heading')
                        ),
                        'Content' => array(
                            'fields' => array('Content.id', 'Content.content', 'Content.heading', 'Content.modified', 'Content.slug'),
                            'Image' => array(
                                'fields' => array('Image.alt', 'Image.title', 'Image.img_file',
                                    'Image.created', 'Image.date', 'Image.id')
                            )
                        )
                    ),
                    'order' => array(
                        'ContentCollection.seq ASC',
                        'ContentCollection.id ASC'
                    ),
                    'conditions' => $conditions
                ));
    }

}

function assembleArticleList($record, $key, $content) {
//    debug($record);
    $content[$record['ContentCollection']['id']] = $record['Content']['heading'];
}

?>