<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Product
 */
/**
 * Catalog Model
 * 
 * @package       bindery
 * @subpackage    bindery.Product
 */
class Catalog extends AppModel {
	var $name = 'Catalog';
	var $validate = array(
		'size' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'product_group' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'price' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'category' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'product_code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);
	var $belongsTo = array(
            'Collection' => array(
                    'className' => 'Collection',
                    'foreignKey' => 'collection_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
            ),
            'Diagram' => array(
                'className' => 'Diagram',
                'foreignKey' => 'product_group'
            )
	);
        
        /**
         * Master list of what options carry cost for products
         * 
         * This array guides construction of the 'catalog' object on the page.
         * 'catalog' is the javascript object that guides pricing and caveat
         * elements on the page, providing the user with context and feedback
         * 
         * If an option carries a cost, it must be included here and 
         * js handlers must be attached to its input to integrate it on the page
         *
         * @var array 
         */
        var $allCostOptions = array(
                'Journal' => array('product', 'belt', 'title'),
                'Reusable_Journal' => array('product', 'belt', 'title', 'bookbody'),
                'Notebook' => array('product', 'belt', 'title', 'penloop'),
                'Portfolio' => array('product', 'belt', 'title', 'penloop'),
                'Top_Opening' => array('product', 'belt', 'title', 'penloop'),
                'Mini_Notebook' => array('product'),
                'Book_Body' => array('product'),
                'Notebook_Pages' => array('product')
            );

        /**
         * Return the list of setlist attribute values for every product category
         * 
         * These will be the option inputs to reveal when a given product category
         * is clicked in the product grid interface 
         * 
         * @return array The array of options indexed by product category
         */
        function getAllProductCategoryOptions(){
            $allOptions = array(
                'Book_Body' => 'endpaper order',
                'Journal' => 'belt titling endpaper instructions order',
                // reusable gets endpaper because there are selects for a bookbody in its option list
//                'Reusable_Journal' => 'belt titling liners instructions bookbody order endpapers',
                'Reusable_Journal' => 'belt titling liners instructions order pagecount',
                'Notebook' => 'belt titling liners notbookpockets instructions order penloop',
                'Portfolio' => 'belt titling liners portfoliopocket instructions order penloop',
                'Top_Opening' => 'belt titling liners portfoliopocket instructions order penloop',
                'Notebook_Pages' => 'Ruled_Pages order',
                'Mini_Notebook' => 'liners pocket instructions order'
            );
            return $allOptions;
        }
        
        /**
         * Create the Catalog Object Map for on-page javascript
         * 
         * This will be the object to guide price calcs
         * and provide convenience handles to page elements
         * @param array $dataSet an array with product names as a key
         * @return array destined to be a js object to guide page display
         */
        function getCatalogMap($dataSet){
            $catalog = array();
            foreach ($dataSet['Catalog'] as $product => $data){
                if (isset($this->allCostOptions[$product])){
                    $catalog['productNames'][$product] = array(
                        'toggle' => false,
                        'table' => false,
                        'productRadios' => false,
                        'caveat' => 'materials' // the baseline caveat for all products
                    );
                    $catalog[$product] = array();
                    foreach ($this->allCostOptions[$product] as $costNode) {
                        $catalog[$product][$costNode] = array(
                            'price' => 0,
                            'handle' => false,
                            'caveat' => false);
                    }
                    
                }
            }
            return $catalog;
        }
        
        /**
         * Which products should get a diagram div
         * 
         * I could make each one carry a list of div layers
         * (and componenets) to include in the diagram
         */
        function productDiagrams(){
            $productDiagramMap = array(
                'Journal' => TRUE,
                'Reusable_Journal' => TRUE,
                'Notebook' => TRUE,
                'Portfolio' => TRUE,
                'Book_Body' => TRUE,
                'Top_Opening' => TRUE,
                'Notebook_Pages' => FALSE,
                'Mini_Notebook' => TRUE
            );
            return $productDiagramMap;
        }
        
        /**
         * A lookup table to include on reusable journal page
         * to aid in calculating a bookbody price.
		 * 
		 * Transfer in current prices from quickbooks
		 * 
		 * This query is cached
         * 
         * @return array The price lookup table
         */
        function getPrintingPrices(){
			if (!$this->printPrices = Cache::read('printprices', 'catalog')) {
				$raw = $this->find('all', array(
					'fields' => array('Catalog.product_code', 'Catalog.price'),
					'conditions' => array('Catalog.category' => 'Book_Body')
				));

			$qbCodePrices = QBModel::priceList(TRUE);

				$this->printPrice = array();
				foreach ($raw as $entry) {
					$this->printPrice[$entry['Catalog']['product_code']] = $qbCodePrices[strtoupper($entry['Catalog']['product_code'])];
				}
				Cache::write('printprices', $this->printPrice, 'catalog');
			}            
			return $this->printPrice;
//            $smallPageCost = .06;
//            $largePageCost = .08;
//            $overhead = 2;
//            return $this->printPrice =  array(
//                '588' => intval(128 * $smallPageCost)+$overhead,
//                '582' => intval(192 * $smallPageCost)+$overhead,
//                '586' => intval(256 * $smallPageCost)+$overhead,
//                '888' => intval(128 * $largePageCost)+$overhead,
//                '882' => intval(192 * $largePageCost)+$overhead,
//                '886' => intval(256 * $largePageCost)+$overhead
//                );
        }

        /**
         * Return a single setlit attribute string
         * 
         * @param string $category 
         * @return string The setlist attribute string for the given category
         */
        function getProductCategoryOptions($category){
            $allOptions = $this->getAllProductCategoryOptions();
            $result = array();
            
            if(isset($allOptions[$category])){
                $result = $allOptions[$category];
            }
            
            return $result;
        }
        
        /**
         * Data describing product part sizes to aid in diagram construction
         *
         * catalog.js requires data regarding the diagrams to be constructed
         * this returns all the data. The data is left in array form for
         * possible secondary use. The controller action catalog() makes it
         * into json for inclusion in the page.
         *   [8Cover] => Array
         *      [case] => Array
         *              [x] => 8.625
         *              [y] => 11.25
         *              [part] => case
         *              [product_group] => 8Cover
         *      [liner] => Array
         *              [x] => 8.625
         *              ...
         *
         * @param string $pname A product collection name
         * @return array 
         */
        function getDiagramData($pname){
           $raw = $this->find('all', array(
                'fields' => array(
                    'Catalog.product_group',
                    'Catalog.category',
                    'Catalog.collection_id'
                ),
//                'group' => array('Catalog.product_group'),
                'conditions' => array('Collection.heading' => $pname),
                'contain' => array(
                    'Collection' => array(
                        'fields' => array(
                            'Collection.id',
                            'Collection.heading'
                        )
                    ),
                    'Diagram' => array(
                        'fields' => array(
                            'Diagram.x',
                            'Diagram.y',
                            'Diagram.part',
                            'Diagram.product_group'
                        )
                    )
                )
            ));
            $diagramData = array();
            foreach ($raw as $group) {
                $diagramData[$group['Diagram']['product_group']][$group['Diagram']['part']] = $group['Diagram'];
            }
            
            return $diagramData;
        }

}
?>