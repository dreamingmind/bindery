<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP DrawbridgeAppModel
 * @author jasont
 */
class DrawbridgeAppModel extends AppModel {
    
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
    }
    
    public function beforeSave($options = array()) {
        parent::beforeSave($options);
    }
    
}
