<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * Category Model
 * 
 * This is the most general classification of site Content. It controls 
 * whick Articles may be displayed in the 5 site sections
 *  - Workshops
 *  - Galleries
 *  - Newsfeeds
 *  - Blog
 *  - Art
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
 * <li>Collections are Categorized</li>
 * <li>Major page types will only display Content of a specific Category
 *     <ul>
 *     <li>Workshop only allows 'workshop' Articles</li>
 *     <li>Product Galleries only allow 'exhibit' Articles</li>
 *     <li>Art & Editions only allow 'art' Articles</li>
 *     <li>Blog and Newsfeed only allow 'dispatch' Articles</li>
 *         <ul>
 *         <li>Any article of Category 'dispatch' will be included in the Blog</li>
 *         <li>Newsfeed Articles are a sub-set of 'dispatch' category articles.
 *             Only the 'dispatch' Collections who's headings match menu-tree nodes
 *             under the Product parent will be included (see the bindery.Navigation subpackage)</li>
 *     <li>'dispatch' articles can serve as a Detail Article to any other category of article
 *     </ul>
 * </li>
 * </ul>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 * 
*/
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