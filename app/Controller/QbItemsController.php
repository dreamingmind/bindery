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
		$source = new File(APP . 'webroot/files/all.iff');
		$source->open('r');
		$dest = $this->QbItems->import($source->handle);
		$this->set('source', $dest);
	}
	
	public function import() {
		if($this->request->is('POST')){
			$path = $this->request->data['QbItems']['QBFile']['tmp_name'];
			$source = new File($path);
			$source->open('r');
			$this->QbItems->import($source->handle);
		}
		
	}
	
}

?>
