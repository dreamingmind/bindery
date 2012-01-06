<?php
class ContentCollection extends AppModel {
	var $name = 'ContentCollection';

	var $belongsTo = array(
		'Content', 'Collection'
		);
        
        function recentCollections() {
//            $categories = $this->find('all',array(
//                'fields'=>array('DISTINCT Collection.category')
//            ));
//            debug($categories);die;
            $recentCollections = $this->find('all',array(
                'fields'=>array(
                    'Collection.id', 'Collection.heading', 'Collection.category'
                ),
                'order'=>'ContentCollection.created DESC',
                'limit'=>10
            ));
                    
            foreach($recentCollections as $entry){
                $this->recentCollections[$entry['Collection']['id']] = 
                    "{$entry['Collection']['heading']} ({$entry['Collection']['category']})";
            }
            return $this->recentCollections;
        }
        
        }
?>