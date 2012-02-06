<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.model
 */
/**
 * Content Model
 * 
 * @package       bindery
 * @subpackage    bindery.model
 * 
 * @property Image $Image
 * @property ExhibitSupliment $ExhibitSupliment
*/
class Content extends AppModel {
	var $name = 'Content';
	var $validate = array(
		'navline_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
            'Navline' => array(
                    'className' => 'Navline',
                    'foreignKey' => 'navline_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
            ),
            'Image' => array(
                'className' => 'Image',
                'foreignKey' => 'image_id'
            )	);
        
        var $hasOne = array('ExhibitSupliment');
        var $hasMany = array(
            'ContentCollection' => array(
                'className' => 'ContentCollection',
                'foreignKey' => 'content_id'
            )

        );    
        
        var $displayField = 'heading';
    
        /**
         * An array of arrays showing collections containing an image
         * $imageCollections[image_id] = array(
         *      'id' => collection name
         * )
         *
         * @var array $imageCollection The collections containing an image
         */
        var $imageCollections = array();
        
    /**
     * Pull the list of Content linked to an Image record
     *
     * @param integer $id The id of the Image record 
     * @return array The list of Content linked to an Image (id => heading)
     */
    function linkedContent($id){
        
        $list = $this->find('list',array(
            'fields'=>array('Content.id','Content.heading'),
            'conditions'=>array('Content.image_id'=>$id)
        ));
        $list = array(0=>' ', 1=>'New')+$list;
        return $list;
    }

    function linkedCollections($id){
        $list = $this->find('all', array(
            'conditions'=>array('Content.image_id'=>$id),
            'contain' => array(
                'ContentCollection'=>array(
                    'fields'=>array(
                        'ContentCollection.collection_id'
                    ),
                    'Collection'=>array(
                        'fields'=>array(
                            'Collection.heading'
                        )
                    )
                )
            )
        ));
        
        if ($list){
            foreach($list[0]['ContentCollection'] as $collection){
                if(isset($collection['Collection']['heading'])){
                    $collections[$collection['collection_id']] = $collection['Collection']['heading'];
                }
            }
        }
        if($collections){
            $this->imageCollections[$list[0]['Content']['image_id']][$collection['collection_id']] = $collections;
        }
        return $collections;
    }
    
}
?>