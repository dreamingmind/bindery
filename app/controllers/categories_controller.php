<?php
class CategoriesController extends AppController {

	var $name = 'Categories';
        
        var $layout = 'noThumbnailPage';

	function index() {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
                        $this->data['Category']['supplement_list'] = $this->processSupplementDefaults();
			$this->Category->create();
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
                        $this->data['Category']['supplement_list'] = $this->processSupplementDefaults();
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash(__('The category has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Category->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('Category deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Category was not deleted', true));
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
            $keys = $this->data['Category']['supplement_key'];
            $values = $this->data['Category']['supplement_value'];
            if(implode('', $keys).implode('', $values) == ''){
                return '';
            }
            $defaults = array();
            for($i=0; $i<count($this->data['Category']['supplement_key']); $i++){
                if ($keys[$i].$values[$i] != ''){
                    $defaults[($keys[$i] != '')?$keys[$i]:"noKey$i"] = $values[$i];
                }
            }
            return serialize($defaults);
        }
}
?>