<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Product
 */
App::uses('AppController', 'Controller');

/**
 * Catalogs Controller
 * 
 * @package       bindery
 * @subpackage    bindery.Product
 */
class CatalogsController extends AppController {

    var $name = 'Catalogs';
    var $uses = array('Catalog', 'Material', 'Design');
    var $helpers = array('TableParser', 'Number');

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
            'catalog',
            'order',
			'editCatalogItem'
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
            $this->Session->setFlash(__('Invalid catalog'));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('catalog', $this->Catalog->read(null, $id));
    }

    function add() {
        if (!empty($this->request->data)) {
            $this->Catalog->create();
            if ($this->Catalog->save($this->request->data)) {
                $this->Session->setFlash(__('The catalog has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The catalog could not be saved. Please, try again.'));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__('Invalid catalog'));
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->request->data)) {
            if ($this->Catalog->save($this->request->data)) {
                $this->Session->setFlash(__('The catalog has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The catalog could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Catalog->read(null, $id);
        }
    }

    function delete($id = null) {
        if (!$id) {
            $this->Session->setFlash(__('Invalid id for catalog'));
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Catalog->delete($id)) {
            $this->Session->setFlash(__('Catalog deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Catalog was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

	/**
	 * 
	 * @param type $product_group
	 */
    function catalog($product_group = null) {
//		dmDebug::ddd($this->request->data, 'trd');
//		debug($this->request->params);
		if (is_null($product_group)) {
			$product_group = $this->request->params['pname'];
		}		
//        debug($this->Catalog->getPrintingPrices());die;
        if(isset($this->request->data)){
//            debug($this->request->data);die;
        }
        $this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
        $this->scripts[] = 'product_diagram';
        
        // get the table data for pname
        $tableSet = ($this->Catalog->Collection->getPriceTable($product_group));
		if (empty($tableSet['Catalog'])) {
			$tableSet['Catalog'] = array();
			$leatherOptions = $clothOptions = $endpaperOptions = $setlists = $diagramMap = $costOptions = $js = '';
		} else {
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
			$diagramData = 'var diagramData = ' . json_encode($this->Catalog->getDiagramData($product_group));
			$pagePricing = 'var pagePricing = ' . json_encode($this->Catalog->getPrintingPrices());
			$js = "$catalog\r$diagramData\r$pagePricing\r$caveat";
		}

        $this->set(compact('tableSet', 'leatherOptions', 'clothOptions', 'endpaperOptions', 'setlists',
                'product_group', 'diagramMap', 'costOptions', 'js'));
//		debug('catalog');
    }
	
	/**
	 * Edit a Custom or Generic product that's been placed in the shopping cart
	 * 
	 * These two product groups were ordered from catalogs/catalog page forms 
	 * so, when editing them we come back to this context to do the job
	 * 
	 * @param string $id CartItem id
	 * @param string $pname the product name that will control catalog()
	 */
	public function editCatalogItem($id, $product_group) {
		$this->helpers['Cart'] = array('className' => 'CartEditEntry');
		
		$this->viewClassOverride('CartEditView');
		
		$this->request->data = $this->Purchases->sourceFormData($id);
		$this->request->data['CartItem']['id'] = $id;
		$this->set('cartProduct', $this->Purchases->product->product());
		
		
		$this->catalog($product_group);
		$this->render('catalog');
	}

	/**
     * Save product specs for later and add product to shopping cart
	 * 
	 * This is assumed to be deprecated ========================================================= !!!!!!!!!!!!!!!!!!!!!!!!!! deprecated?
     * 
     * Return an HTML fragemnt. This was an AJAX call
     */
//    function order($dat = 'my data'){
////		dmDebug::ddd($this->request->data, 'trd');
////		dmDebug::logVars($dat, 'provided argument');
//        $this->layout = 'ajax';
//        $product = $this->request->data; //pick off the pertinent array elements here
////        $this->SpecdProducts->memorizeSpecs($product);
////        $result = $this->addToCart($product);
//        $result = true;
//        if (isset($this->request->data)) {
//			// this is the only use of $this->Design and is assumed to be deprecated
////            $data = array(
////                'Design' => array(
////                    'data' => serialize($this->request->data)
////                )
////            );
////            if ($this->Design->save($data)) {
////                $message = 'Success';
////            } else {
////                $message = 'Failure';
////            }
////            debug($message);
//            //prepare SUCCESS return message
//            $this->set('data', $this->request->data);
//            $result = $this->Purchases->add();
//            $websitecode = $result['WEBSITECODE'];
//            $emaillink = $result['EMAILLINK'];
//            $this->set('emaillink', $emaillink);
////            $this->redirect($emaillink, );
//        } else {
//            //prepare FAILURE return message
//            $this->set('data', $this->request->data);
//        }
//    }

	/**
	 * Collect option lists for product specification
	 */
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

	public function editProduct($source, $id) {
		switch ($source) {
			case 'cart':
				$Cart = ClassRegistry::init('Cart');
				$Cart->fetchItem($id, TRUE);
				break;
			default:
				$this->Session->setFlash("The specified storage source, $source, was not found. This ordered item cannot be retrieved.", 'f_error');
				break;
		}
	}
}

?>