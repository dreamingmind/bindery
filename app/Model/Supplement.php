<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * Supplement Model
 * 
 * Supplement data allows the attachment any number of additional parameters
 * to a Content record. Currently the only use for this data is to
 * provide text positioning and style information for Content records that 
 * belong to Collections of Category 'exhibit'. These Content exhibits have
 * the text positioned over the image.
 * 
 * Other Supplemental data could be provided for use by other Category output routines
 * 
 * The basic structual chain for Content is:
 * <pre>
 *                                                      |<--Supplement
 * Category<--Collection<--ContentCollection-->Content--|
 *                                                      |-->Image
 * </pre>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 */
class Supplement extends AppModel {
	var $name = 'Supplement';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
//            'Image' => array(
//                    'className' => 'Image',
//                    'foreignKey' => 'image_id',
//                    'conditions' => '',
//                    'fields' => '',
//                    'order' => ''
//            ),
//            'Collection' => array(
//                'className' => 'Collection',
//                'foreignKey' => 'collection_id',
//                'conditions' => '',
//                'fields' => '',
//                'order' => ''
//            ),
            'ContentCollection' => array(
                'className' => 'ContentCollection',
                'foreignKey' => 'content_collection_id',
            )
	);
	
	/**
	 * Given a CartItem id, find the id of the attached Supplement
	 * 
	 * @param string $id A cart item id
	 * @return string|False The supplement id or False if none
	 */
	public function id_fromCartItem($id) {
		return $this->field('id', array('cart_item_id' => $id));
	}
	
	/**
	 * Given a CartItem id, find the attached Supplement
	 * 
	 * @param string $id A cart item id
	 * @return array The supplement array or empty array
	 */
	public function record_fromCartItem($id) {
		return $this->find('first', array('conditions' => array('order_item_id' => $id)));
	}
	
	
}
?>