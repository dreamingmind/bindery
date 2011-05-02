<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.model
 */
class ExhibitGallery extends AppModel {
    var $name = 'ExhibitGallery';
    var $belongsTo = array(
        'Exhibit',
        'Gallery',
//        'Parent' => array(
//            'className' => 'ExhibitGallery',
//            'foreignKey' => 'parent_id',
//            'belongsTo' => 'Exhibit')
        );
    var $actsAs = array('GroupTree');
    var $displayField = 'Exhibit.heading';


    function parentNode() {
        return null;
    }

}
?>