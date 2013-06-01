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
 * Materials Model
 * 
 * @package       bindery
 * @subpackage    bindery.Product
 */
class Material extends AppModel {
	var $name = 'Material';
	var $primaryKey = 'id';
	var $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'category' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'file_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
        
        var $virtualFields = array(
            'fn'=>'file_name',
            'ti'=>'title'
        );
        
        function pullLeather(){
            // 	{"id":"0","fn":"bbluelthr","ti":"Bright Blue"},
            return $this->flatten($this->find('all',array(
                'fields'=>array(
                    'id',
                    'fn',
                    'ti'
                ),
                'conditions'=>array(
                    'category'=>'leather'
                )
            )));
        }
        
        function pullCloth(){
            return $this->flatten($this->find('all',array(
                'fields'=>array(
                    'id',
                    'fn',
                    'ti'
                ),
                'conditions'=>array(
                    'category'=>'cloth'
                )
            )));
        }
        
        function pullImitation(){
            return $this->flatten($this->find('all',array(
                'fields'=>array(
                    'id',
                    'fn',
                    'ti'
                ),
                'conditions'=>array(
                    'category'=>'imitation'
                )
            )));
        }
        
        function flatten($data){
            if($data){
                foreach($data as $record){
                    $result[] = $record['Material'];
                }
                return $result;
            }
            return $data;
        }
}
?>