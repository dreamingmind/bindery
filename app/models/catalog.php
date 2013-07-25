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
         * Return the list of setlist attribute values for every product category
         * 
         * These will be the option inputs to reveal when a given product category
         * is clicked in the product grid interface 
         * 
         * @return array The array of options indexed by product category
         */
        function getAllProductCategoryOptions(){
            $allOptions = array(
                'Book_Body' => 'endpapers order',
                'Journal' => 'belt titling endpapers instructions order',
                'Reusable_Journal' => 'belt titling liners instructions bookbody order',
                'Notebook' => 'belt titling liners notbookpockets instructions order',
                'Portfolio' => 'belt titling liners portfoliopocket instructions order',
                'Notebook_Pages' => 'Ruled_Pages order',
                'Mini_Notebook' => 'minicasematerials miniliners minipocket instructions order'
            );
            
            return $allOptions;
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