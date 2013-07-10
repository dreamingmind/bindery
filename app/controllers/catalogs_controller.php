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
 * Catalogs Controller
 * 
 * @package       bindery
 * @subpackage    bindery.Product
 */
class CatalogsController extends AppController {

    var $name = 'Catalogs';
    var $uses = array('Catalog', 'Material');
    var $helpers = array('TableParser', 'Number');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'catalog'
        ));
        $this->css[] = 'catalog';
    }

    function index() {
        $this->Catalog->recursive = 0;
        $this->set('catalogs', $this->paginate());
    }

    function view($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid catalog', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('catalog', $this->Catalog->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $this->Catalog->create();
            if ($this->Catalog->save($this->data)) {
                $this->Session->setFlash(__('The catalog has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The catalog could not be saved. Please, try again.', true));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->Session->setFlash(__('Invalid catalog', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Catalog->save($this->data)) {
                $this->Session->setFlash(__('The catalog has been saved', true));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The catalog could not be saved. Please, try again.', true));
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Catalog->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for catalog', true));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Catalog->delete($id)) {
            $this->Session->setFlash(__('Catalog deleted', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Catalog was not deleted', true));
        $this->redirect(array('action' => 'index'));
    }

    function catalog() {
        if(isset($this->data)){
            debug($this->data);die;
        }
        $this->layout = 'noThumbnailPage';
        $tableSet = ($this->Catalog->Collection->getPriceTable($this->params['pname']));
//        debug($tableSet);die;
//            $this->set('product',$this->Catalog->query('select yy_index, y_index, xx_index, x_index, price, product_code from catalogs where category = "'.$this->params['pname'].'"
//order by yy_index, y_index, xx_index, x_index;'));

        $this->set('tableSet', $tableSet);
        $this->set('leatherOptions', $this->Material->leatherOptionList());
        $this->set('clothOptions', $this->Material->clothOptionList());
        $this->set('endpaperOptions', $this->Material->endpaperOptionList());
//        $this->select();
        $this->set('setlists', $this->Catalog->getAllProductCategoryOptions());
//            $this->set('materials', $this->render('select'));
//            $this->render('catalog');
    }

    function select() {
        $this->css[] = 'materials';
        $this->scripts[] = 'materials';
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