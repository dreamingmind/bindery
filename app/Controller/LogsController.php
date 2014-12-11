<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');

/**
 * CakePHP LogsController
 * @author jasont
 */
class LogsController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
//		if ($this->Auth->user('Group.name') == 'Administrator') {
			$this->Auth->allow('index', 'read', 'clear');
//		}		
    }

//    public function isAuthorized($user) {
//        return $this->authCheck($user, $this->accessPattern);
//    }

	public function index() {
		$d = new Folder(LOGS);
		$tree = $d->tree();
		$out = $tree[1];
		
		// sort the log files into groups
		foreach ($out as $path) {
			if(substr($path, -4, 4) == '.log') {
//				debug($path);				
				$x = explode('/', $path);
				$group = preg_replace('/[\d|\.]*/', '', $x[count($x)-1]);
//				debug($group);
				$list[$group][] = $path;
			}
		}
		$this->set('out', $list);
	}
	
	public function read($param) {
//		debug($param);
		$a = str_replace('-', '/', $param);
//		debug($a);
//		die;
		$f = new File(LOGS.$a);
		$out = $f->read();
		$this->set('out', $out);
	}
	
	public function clear($path) {
		$a = str_replace('-', '/', $path);

		$f = new File(LOGS.$a);
		$out = $f->write("Cleared by {$this->Auth->user('id')} on " . date('r', time()) . "\n");
		$this->redirect($this->referer());
	}

}
