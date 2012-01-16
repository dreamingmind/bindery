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
        
    function linkedContent($id){
        
        $list = $this->find('list',array(
            'fields'=>array('Content.id','Content.heading'),
            'conditions'=>array('Content.image_id'=>$id)
        ));
        $list = array(0=>' ', 1=>'New')+$list;
        return $list;
    }

}
?>