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
            'catalog',
            'order'
        ));
        $this->css[] = 'catalog';
        $this->css[] = 'materials';
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
//        debug($this->Catalog->getPrintingPrices());die;
        if(isset($this->data)){
            debug($this->data);die;
        }
        $this->layout = 'noThumbnailPage';
        $this->scripts[] = 'product_diagram';
        
        // get the table data for pname
        $tableSet = ($this->Catalog->Collection->getPriceTable($this->params['pname']));
        // get the select lists for the options
        $leatherOptions =  $this->Material->leatherOptionList();
        $clothOptions =  $this->Material->clothOptionList();
        $endpaperOptions =  $this->Material->endpaperOptionList();
        $endpaperOptions =  $this->Material->clothOptionList();
        // get data listing core options for the various product categories
        $setlists =  $this->Catalog->getAllProductCategoryOptions();
        // tell the view what diagram scaffolds to include
        $diagramMap = $this->Catalog->ProductDiagrams();
        
        // prepare javascript for the page
        $caveat = 'var caveat = ' . json_encode($this->caveat);
        $catalog = 'var catalog = ' . json_encode($this->Catalog->getcatalogMap($tableSet));
        $diagramData = 'var diagramData = ' . json_encode($this->Catalog->getDiagramData($this->params['pname']));
        $pagePricing = 'var pagePricing = ' . json_encode($this->Catalog->getPrintingPrices());
        $js = "$catalog\r$diagramData\r$pagePricing\r$caveat";
        

        $this->set(compact('tableSet', 'leatherOptions', 'clothOptions', 'endpaperOptions', 'setlists',
                'diagramMap', 'costOptions', 'js'));
    }
    
    /**
     * Save product specs for later and add product to shopping cart
     * 
     * Return an HTML fragemnt. This was an AJAX call
     */
    function order($dat = 'my data'){
        $this->layout = 'ajax';
        $product = $this->data; //pick off the pertinent array elements here
//        $this->SpecdProducts->memorizeSpecs($product);
//        $result = $this->addToCart($product);
        $result = true;
        if (isset($this->data)) {
            //prepare SUCCESS return message
            $this->set('data', $this->data);
        } else {
            //prepare FAILURE return message
            $this->set('data', $dat);
        }
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