<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP PreSpecd
 * @author dondrake
 */
class PreSpecd extends AppModel {
	
	public $useTable = 'order_items';
	
	public $hasAndBelongsToMany = array(
        'Image' =>
            array(
                'className' => 'Image',
                'joinTable' => 'content_order_items',
                'foreignKey' => 'order_item_id',
                'associationForeignKey' => 'image_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'ImageOrderItem'
            ),
		'Content' =>
            array(
                'className' => 'Content',
                'joinTable' => 'content_order_items',
                'foreignKey' => 'order_item_id',
                'associationForeignKey' => 'content_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'ContentOrderItem'
            )
    );
	
	public function linked($id = '816') {
		return $this->find('all', array(
			'conditions' => array('id' => $id),
			'contain' => array(
				'Image' => array(
					'fields' => array('id', 'alt', 'title')
				),
				'Content' => array(
					'fields' => array('id', 'heading', 'content')
				)
			)
		));
	}
}
