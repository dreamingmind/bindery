<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
/**
 * Navlines Controller
 * 
 * @package       bindery
 * @subpackage    bindery.controller

 */
class NavlinesController extends AppController {


	var $name = 'Navlines';
        var $paginate = array(
            'limit' => 50,
            'order' => array(
                'Navline.name' => 'asc'
            )
        );


	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allowedActions = array('*');
	}

        function index() {
		$this->Navline->recursive = 0;
		$this->set('navlines', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid navline', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('navline', $this->Navline->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Navline->create();
			if ($this->Navline->save($this->data)) {
				$this->Session->setFlash(__('The navline has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The navline could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid navline', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Navline->save($this->data)) {
				$this->Session->setFlash(__('The navline has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The navline could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Navline->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for navline', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Navline->delete($id)) {
			$this->Session->setFlash(__('Navline deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Navline was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>