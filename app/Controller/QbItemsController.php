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
			$this->Auth->allow('import');
//		}		
    }

	/**
	 * Import quickbooks business data to support customer and product features on the site
	 */
	public function import() {
		if($this->request->is('POST')){
			$path = $this->request->data['QbItems']['QBFile']['tmp_name'];
			$source = new File($path);
			$source->open('r');
			$this->QbItems->import($source->handle);
			Cache::clearGroup('catalog', 'catalog');
			Cache::clearGroup('qb', 'qb');
		}
		
	}
	
}

?>
