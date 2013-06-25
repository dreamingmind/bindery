<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Product
 */

/**
 * Materials Controller
 * 
 * @package       bindery
 * @subpackage    bindery.Product
 */
class MaterialsController extends AppController {

    var $name = 'Materials';
    var $layout = 'noThumbnailPage';

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(
                'select');
    }

    function index() {
        $this->Material->recursive = 0;
        $this->set('materials', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid material', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('material', $this->Material->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Material->create();
            if ($this->Material->save($this->data)) {
                $this->Session->setFlash(__('The material has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The material could not be saved. Please, try again.', true));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid material', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Material->save($this->data)) {
                $this->Session->setFlash(__('The material has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The material could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Material->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for material', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Material->delete($id)) {
            $this->Session->setFlash(__('Material deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Material was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    function select() {
        $this->css[] = 'materials';
        $leather = $this->Material->pullLeather();
        $cloth = $this->Material->pullCloth();
        $imitation = $this->Material->pullImitation();
        $this->set('leather', $leather ? json_encode($leather) : $leather);
        $this->set('cloth', $cloth ? json_encode($cloth) : $cloth);
        $this->set('imitation', $imitation ? json_encode($imitation) : $imitation);
//            debug(json_encode($this->viewVars['leather']));
//            debug(json_encode($this->viewVars['cloth']));
//            debug($this->viewVars['leather']);
    }

}

?>