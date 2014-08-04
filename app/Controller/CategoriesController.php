<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * Categories Controller
 * 
 * This is the most general classification of site Content.
 * The basic structual chain for Content is:
 * <pre>
 *                                                      |<--Supplement
 * Category<--Collection<--ContentCollection-->Content--|
 *                                                      |-->Image
 * |         |            |                  |                     |
 * | Content |            |                  |                     |
 * | Filter  |Article Sets| Article Assembly |     Article Parts   |
 * </pre>
 * <ul>
 * <li>Collections are Categorized</li>
 * <li>Major page types will only display Content of a specific Category
 *     <ul>
 *     <li>Blog and Newsfeed only allow 'dispatch' category</li>
 *     <li>Workshop only allows 'workshop' category</li>
 *     <li>Product Galleries only allow 'exhibit' category</li>
 *     <li>Art & Editions only allow 'art' category</li>
 *     </ul>
 * </li>
 * </ul>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 * 
*/
class CategoriesController extends AppController {

	var $name = 'Categories';
        
        var $layout = 'noThumbnailPage';

	function index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid category'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
                        $this->request->data['Category']['supplement_list'] = $this->processSupplementDefaults();
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid category'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
                        $this->request->data['Category']['supplement_list'] = $this->processSupplementDefaults();
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash(__('The category has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Category->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for category'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('Category deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Category was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        /**
         * Process a clean value for Category.supplement_list add/edit methods
         * 
         * The form sends 2 arrays, keys and values for 
         * default Supplement values. This makes sure every
         * key says something if it has a corresponding value
         * and throws out any empty pairs
         * as it makes one array out of the two.
         * 
         * @return string empty string or serialized array
         */
        function processSupplementDefaults(){
            $keys = $this->request->data['Category']['supplement_key'];
            $values = $this->request->data['Category']['supplement_value'];
            if(implode('', $keys).implode('', $values) == ''){
                return '';
            }
            $defaults = array();
            for($i=0; $i<count($this->request->data['Category']['supplement_key']); $i++){
                if ($keys[$i].$values[$i] != ''){
                    $defaults[($keys[$i] != '')?$keys[$i]:"noKey$i"] = $values[$i];
                }
            }
            return serialize($defaults);
        }
}
?>