<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.com)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Security
 */
/**
 * Aros Controller
 * 
 * Provides basic crud and tree management of the Aros Model
 * 
 * @package       bindery
 * @subpackage    bindery.Security
 */
class ArosController extends AppController {

	var $name = 'Aros';
        
        var $components = array(
            'TreeCrud' => array(
                'displayField' => 'Aro.alias'
                )
            );
        var $helpers = array(
            'TreeCrud'
        );
        
        var $layout = 'noThumbnailPage';
        
        function beforeRender() {
            parent::beforeRender();
        }

//    function beforeFilter() {
//        parent::beforeFilter();
//        $this->{$this->modelClass}->virtualFields = array ('indexed_name' => 'CONCAT(Aro.id, ": ", Aro.alias)');
//        debug($this->{$this->modelClass}->_schema);
//        //$modelObj->virtualFields = array ('name' => "CONCAT($modelObj->primaryKey, \": \", $modelObj->displayField)");
//        //$this->Aro->virtualFields = array ('indexed_name' => 'CONCAT(Aro.id, ": ", Aro.alias)');
//    }

        function index() {
		$this->Aro->recursive = 0;
		$this->set('aros', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'aro'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('aro', $this->Aro->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Aro->create();
			if ($this->Aro->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'aro'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'aro'));
			}
		}
		//$parentAros = $this->Aro->ParentAro->find('list');
		$acos = $this->Aro->Aco->find('list');
		//$this->set(compact('parentAros', 'acos'));
		$this->set('acos');
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'aro'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Aro->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'aro'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'aro'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Aro->read(null, $id);
		}
		//$parentAros = $this->Aro->ParentAro->find('list');
		$acos = $this->Aro->Aco->find('list');
		//$this->set(compact('parentAros', 'acos'));
		$this->set('acos');
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s'), 'aro'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Aro->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted'), 'Aro'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted'), 'Aro'));
		$this->redirect(array('action' => 'index'));
	}

            /**
             * 
             */
	function manage_tree($id=null) {
            $this->css[] = 'tree_admin';
            $this->TreeCrud->tree_crud();
        }

        function fix() {
            $this->Aro->recover('tree');
            $this->redirect(array('controller'=>'aros', 'action'=>'manage_tree'));
        }


}
?>