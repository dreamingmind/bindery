<?php
class ContentCollection extends AppModel {
	var $name = 'ContentCollection';

	var $belongsTo = array(
		'Content', 
                'Collection',
                'DetailCollection'=>array(
                    'className'=>'Collection',
                    'foreignKey'=>'sub_collection'
                ));
        
        var $displayField = 'Content.heading';
        
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
        function recentCollections($limit=null) {
            $limit = ($limit==null) ? 10 : $limit;
            
            $recentCollections = $this->find('all',array(
                'fields'=>array(
                    'Collection.id', 'Collection.heading', 'Collection.category_id'
                ),
                'order'=>'ContentCollection.created DESC',
                'limit'=>$limit
            ));
            
            $this->recentCollections = array(' ');
                    
            foreach($recentCollections as $entry){
                $collection_name = $this->Collection->Category->categoryIN[$entry['Collection']['category_id']];
                $this->recentCollections[$entry['Collection']['id']] = 
                    "{$entry['Collection']['heading']} ($collection_name)";
            }
            return $this->recentCollections;
        }
                
        }
?>