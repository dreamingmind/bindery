<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');

/**
 * Description of QbItemsController
 *
 * @author dondrake
 */
class QbItemsController extends AppController {
	
public $uses = array('QbItems');

    public function beforeFilter() {
        parent::beforeFilter();
//		if ($this->Auth->user('Group.name') == 'Administrator') {
			$this->Auth->allow('index', 'read', 'clear');
//		}		
    }

	public function index() {
		$source = new File(APP . 'webroot/files/list.isf');
		$source->open('r');
		$dest = $this->QbItems->import($source->handle);
		$this->set('source', $dest);
	}
}

?>
