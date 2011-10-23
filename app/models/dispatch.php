<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.model
 */
class Dispatch extends AppModel {
    var $name = 'Dispatch';
    var $hasAndBelongsToMany = array(
        'Gallery' => array (
            'className'=>'Gallery',
            'joinTable'=>'dispatch_galleries',
            'foreignKey'=>'dispatch_id',
            'associationForeignKey'=>'gallery_id',
            'unique'=>true,
            'conditions'=>'',
            'fields'=>'',
            'order'=>'',
            'limit'=>'',
            'offset'=>'',
//		'finderQuery'=>'SELECT d.id, d.image FROM dispatches AS d JOIN dispatch_galleries AS dg WHERE dg.gallery_id = '5' AND dg.dispatch_id = d.id',
            'deletQuery'=>'',
            'insertQuery'=>''
        )
    );
    var $hasOne = array(
        'Image' => array(
            'className'=>'Image',
            'foreignKey'=>'id'
        )
    );
    var $actsAs = array(
        'Upload' => array(
            'img_file' => array(
                'dir' => 'img/dispatches',
                'create_directory' => false,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png'),
                'allowed_ext' => array('.jpg', '.jpeg', '.png', '.JPG', '.JPEG', '.PNG'),
                'thumbnailQuality' => 100, // Global Thumbnail Quality
                'minHeight' => 54,
                'zoomCrop' => True,
                'thumbsizes' => array(
                    'x54y54'=> array ('width' => 54, 'height' => 54,'opt'=>array('q'=>100, 'zc'=>'C')),
                    'x75y56' => array ('width' => 75, 'height' => 56),
                    'x160y120' => array ('width' => 160, 'height' => 120),
                    'x320y240' => array ('width' => 320, 'height' => 240),
                    'x500y375' => array ('width' => 500, 'height' => 375),
                    'x640y480' => array ('width' => 640, 'height' => 480),
                    'x800y600' => array ('width' => 800, 'height' => 600),
                    'x1000y750' => array ('width' => 1000, 'height' => 750)
                ),
            )
        )
    );
/*	var $hasMany = array(
		'className'=>'DispatchGallery',
		'conditions'=>array('DispatchGallery.dispatch_id' => $this->id)),
		);
*/
}
?>