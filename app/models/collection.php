<?php
class Collection extends AppModel {
	var $name = 'Collection';

	var $hasMany = array(
		'ContentCollection'
            );
        
        var $belongsTo = 'Category';
        
        var $displayField = 'heading';
        
        /**
         * Return a Cake list array of all collection headings (indexed by id) grouped by category
         *
         * @return array A cake list array of collections grouped by category
         */
        function allCollections(){
            $this->allCollections = $this->find('list',array(
                'fields'=> array('Collection.id','Collection.heading', 'Collection.category'),
                'order' => 'Collection.role ASC'
            ));
            return $this->allCollections;
        }
        
        /**
         * Return an array containing all the unique categories for Collection records
         *
         * @return array An array of unique categories for Collection records in the form: array('categoryName'=>'categoryName')
         */
        function getCategories(){
            $categoryRecords = $this->find('all',array(
                'fields'=>'DISTINCT category',
                'contain'=>false
            ));
            foreach($categoryRecords as $index=>$record){
                $categories[$record['Collection']['category']] = $record['Collection']['category'];
            }
            return $categories;
        }

        
}
?>