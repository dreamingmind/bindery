<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.model
 */
/**
 * ImagesController
 * 
 * @package       bindery
 * @subpackage    bindery.model
 * @property Content $Content
 * @property Upload $Upload
 */
class Image extends AppModel {
    var $name = 'Image';
    var $displayField = 'img_file';
    //The Associations below have been created with all possible keys, those that are not needed can be removed

//    var $hasMany = array(
//            'Dispatch' => array(
//                    'className' => 'Dispatch',
//                    'foreignKey' => 'image_id',
//                    'dependent' => false,
//                    'conditions' => '',
//                    'fields' => '',
//                    'order' => '',
//                    'limit' => '',
//                    'offset' => '',
//                    'exclusive' => '',
//                    'finderQuery' => '',
//                    'counterQuery' => ''
//            ),
//            'Exhibit' => array(
//                    'className' => 'Exhibit',
//                    'foreignKey' => 'image_id',
//                    'dependent' => false,
//                    'conditions' => '',
//                    'fields' => '',
//                    'order' => '',
//                    'limit' => '',
//                    'offset' => '',
//                    'exclusive' => '',
//                    'finderQuery' => '',
//                    'counterQuery' => ''
//            )
//    );
    var $hasOne = 'Content';

    /*
     * Modified version of Meio Upload Behavior
     * The modification changes the directory structure,
     * adds configuration control for more phpThumb options
     * and possibly adds support for multiple file uploads (unconfirmed)
     * 
     * img_file is the name of the required field to accept the image. The name will be stored here
     * dir must be reset for dispatches and exhibits
     * $this->Image->actsAs['Upload']['img_file']['dir'] = 'img/exhibits'
     * is the way to reset the value from a linked controller
     * $this->actsAs['Upload']['img_file']['dir'] = 'img/exhibits'
     * is assumed to be the method from inside this Class
     */
    var $actsAs = array(
        'Upload' => array(
            'img_file' => array(
                'dir' => 'img/images',
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

}
?>