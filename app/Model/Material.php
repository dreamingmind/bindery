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
        
        function leatherOptionList(){
            // can't get conditions to work
//            $leatherOptions = $this->find('list',array(
//                'fields' => array('Material.fn', 'Material.ti'),
//                'conditons' => array('Material.category'=> 'leather'),
//                'recursive' => 0
//            ));
            $records = $this->pullLeather();
            foreach($records as $leather){
                $leatherOptions[$leather['fn']] = $leather['ti'];
            }
            return array_merge(array('Select'), $leatherOptions);
        }
        
        function clothOptionList(){
            $records = $this->pullCloth();
            foreach($records as $cloth){
                $clothOptions[$cloth['fn']] = $cloth['ti'];
            }
            return array_merge(array('Select'), $clothOptions);
        }
        
        function endpaperOptionList(){
            $records = $this->pullEndpaper();
            foreach($records as $endpaper){
                $endpaperOptions[$endpaper['fn']] = $endpaper['ti'];
            }
            return array_merge(array('Select'), $endpaperOptions);
        }
        
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
        
        function pullEndpaper(){
            // 	{"id":"0","fn":"bbluelthr","ti":"Bright Blue"},
            return $this->flatten($this->find('all',array(
                'fields'=>array(
                    'id',
                    'fn',
                    'ti'
                ),
                'conditions'=>array(
                    'category'=>'endpaper'
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