<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
/**
 * Products Controller
 * 
 * @package       bindery
 * @subpackage    bindery.controller
 */
class ProductsController extends AppController {
	var $name = 'Products';
        var $uses = array('ExhibitGallery');
	var $helpers = array('Paginator', 'Phpthumb');//('Html', 'Nested', 'Javascript');
    var $paginate = array(
        'limit' => 8,
        'order' => array(
        'ExhibitGallery.lft' => 'asc'
        )
    );

    /**
     *
     * @var string $product The product as extracted from the URL
     */
    var $product = false;

    /**
     *
     * @var integer $page The thumbnail navigation page currently indicated in the URL
     */
    var $page = false;

    /**
     *
     * @var integer $id The id extracted from the URL
     */
    var $id = false;

	function beforeFilter() {
            parent::beforeFilter();
            $this->Auth->allow('*');
            $this->product = (isset($this->params['pname']) && $this->params['pname'] != null)
                    ? $this->params['pname']
                    : false;
            $this->set('product', $this->product);
            $this->page = (isset($this->params['named']['page']) && $this->params['named']['page'] != null)
                    ? $this->params['named']['page']
                    : false;
            $this->set('page', $this->page);
            $this->id = (isset($this->params['id']) && $this->params['id'] != null)
                    ? $this->params['id']
                    : false;
            $this->set('id', $this->id);
	}

        /**
         * View action, default landing for all products
         *
         * ******** TO DO ***********
         * setup lookup for splash page content
         * work out 'no splash' alternative display
         *
         */
	function view() {
            $this->productExhibits = $this->paginate('ExhibitGallery', array('Gallery.label like'=> "%{$this->product}%"));
            $this->set('productExhibits', $this->productExhibits);
//debug($this->ExhibitGallery->getAssociated ());
//debug($this->ExhibitGallery->getColumnTypes());
//debug($this->ExhibitGallery->Gallery->getColumnTypes());
//debug($this->ExhibitGallery->Exhibit->getColumnTypes());
            if(isset($this->splashRoute) && $this->splashRoute) {
                $splashContent = $this->Navigator->Navline->find('first',array(
                    'conditions'=>array('route'=>$this->splashRoute),
                    'contain' => array('Content.content')));
                if (isset($splashContent['Content']['content'])) {
                    App::import('Controller','Contents');
                    $contents = new ContentsController();
                    $this->splashContent = $contents->decode($splashContent['Content']['content']);
                    $this->set('splashContent',$this->splashContent);
                }
//                debug($splashContent);
//                debug($this->splashRoute);
//                debug($this->productExhibits);
            }
            
	}

        function art() {
            $this->view('Someproduct');
            $this->render('view');
        }

        /**
         * Product Gallery action, default handling of all product galleries
         *
         * ******** TO DO ***********
         * is this truely only product exhibts? who does art exhibits?
         * work out query strategy for 'no id' condition (menu gallery click)
         * don't neglect exhibit detail picture sets (links added to text?)
         *
         * @param integer $id id of the exhibit to render
         */
        function gallery(){
            $this->set('productExhibits', $this->paginate('ExhibitGallery', array('Gallery.label like'=> "%{$this->product}%")));

            if (!$this->id) {
                $this->id = $this->selectExhibit();
            }
            if ($this->id) {
            $record = $this->ExhibitGallery->find('first',array(
                'conditions'=>array('Exhibit.id'=>$this->id),
                'contains'=> array(
                    'Gallery.Label',
                    'Exhibit.image_file',
                    'Exhibit.heading',
                    'Exhibit.prose_t',
                    'Exhibit.id',
                    'Exhibit.top_val,',
                    'Exhibit.left_val',
                    'Exhibit.height_val',
                    'Exhibit.width_val',
                    'Exhibit.headstyle',
                    'Exhibit.pgraphstyle',
                    'Exhibit.alt',
                    'ExhibitGallery.id')));
            $this->set('record',$record);                
            }
//<div id="detail">
//<img src='../_i/gallery/scaled/DSCN4776.jpg' alt='' />
//
//<style type='text/css' media='screen'><!--
//    #proseblock {
//        position: absolute;
//        z-index: 5;
//        top: 35px;
//        left: 435px;
//        width: 170px;
//        height: 420px;
//    }/n--></style>
//<div id='proseblock'>
//<span class='drksubhead'>Basic Notebook</span>
//<br />
//<br />
//<span class='drkparagraph'>This is a typical full leather notebook. Notice the horizontal back pocket and pen loop. Terra cotta goat and forest green liners, a classic Hugh Stump color combination. Also notice the <a href="#" onClick="MM_openBrWindow('glossary.html#blind','glossary','scrollbars=yes,width=250,height=300')">blind</a> debossed initials in the lower right corner, a popular option.<br><br></span>
//</div>
//</div> <!-- end of dtail -->

        } 

        /**
         * Select a member from the current product gallery
         *
         * The id will be
         * Will return  an id or set a flash message and return false
         *
         * ********* TO DO *********
         * returning a random element like this requires
         * calculation of the correct gallery page for viewing
         *
         * @return integer/boolean id of random exhibit from gallery or false
         */
        function selectExhibit() {
            $records = $this->ExhibitGallery->find('all',array(
                 'conditions'=> array('Gallery.label LIKE'=> "%{$this->product}%"),
                 'contain'=>array('Exhibit.id', 'Gallery.label')
            ));
            //return ($records[0]['Exhibit']['id']);
            if ($records && count($records)>0){
                //$this->Session->setFlash('Getting a random element');
                return ($records[rand(0, count($records))-1]['Exhibit']['id']);
            }
            $this->Session->setFlash('No gallery entries found. Please try again');
            return false;
            //debug($records);

        }

}


?>