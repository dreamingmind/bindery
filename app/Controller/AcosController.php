<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Security
 */
/**
 * Acos Controller
 * 
 * Provide basic crud and tree management of the Acos Model
 * 
 * @package       bindery
 * @subpackage    bindery.Security
*/
class AcosController extends AppController {

	var $name = 'Acos';

        var $components = array(
            'TreeCrud' => array(
                'displayField' => 'Aco.alias'
                )
            );
        var $helpers = array(
            'TreeCrud'
        );

        var $layout = 'noThumbnailPage';

        function beforeRender() {
            parent::beforeRender();
        }

	function index() {
		$this->Aco->recursive = 0;
		$this->set('acos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'aco'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('aco', $this->Aco->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Aco->create();
			if ($this->Aco->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'aco'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'aco'));
			}
		}
		$parentAcos = $this->Aco->ParentAco->find('list');
		$aros = $this->Aco->Aro->find('list');
		$this->set(compact('parentAcos', 'aros'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s'), 'aco'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Aco->save($this->request->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved'), 'aco'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.'), 'aco'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Aco->read(null, $id);
		}
		$parentAcos = $this->Aco->ParentAco->find('list');
		$aros = $this->Aco->Aro->find('list');
		$this->set(compact('parentAcos', 'aros'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s'), 'aco'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Aco->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted'), 'Aco'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted'), 'Aco'));
		$this->redirect(array('action' => 'index'));
	}

        function manage_tree() {
            $this->css[] = 'tree_admin';
            $this->TreeCrud->tree_crud();
        }

        function fix() {
            $this->Aco->recover('tree');
            $this->redirect(array('controller'=>'acos', 'action'=>'manage_tree'));
        }
}
?>