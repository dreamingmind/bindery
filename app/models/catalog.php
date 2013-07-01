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
                'bookbody' => 'ruling',
                'journals' => 'belt titling casematerials endpapers special',
                'notebooks' => 'belt titling casematerials linermaterials notbookpockets special',
                'portfolios' => 'belt titling casematerials linermaterials portfoliopocket special'
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
}
?>