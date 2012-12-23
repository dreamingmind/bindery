<?php
class Collection extends AppModel {
	var $name = 'Collection';

	var $hasMany = 'ContentCollection';
        
        var $belongsTo = 'Category';
        
        var $displayField = 'heading';
        
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
                
}
?>