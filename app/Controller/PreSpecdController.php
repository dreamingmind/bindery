<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP PreSpecdsController
 * @author dondrake
 */
class PreSpecdController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
//		if ($this->Auth->user('Group.name') == 'Administrator') {
			$this->Auth->allow('index');
//		}		
    }

	public function index($id = '816') {
		dmDebug::ddd($this->PreSpecd->linked($id), 'result array');
	}

}
