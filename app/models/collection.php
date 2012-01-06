<?php
class Collection extends AppModel {
	var $name = 'Collection';

	var $hasMany = array(
		'ContentCollection'
            );

        function allCollections(){
            $this->allCollections = $this->find('list',array(
                'fields'=> array('Collection.id','Collection.heading', 'Collection.category'),
                'order' => 'Collection.role ASC'
            ));
            return $this->allCollections;
        }

        
}
?>