<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * Collections Controller
 * 
 * This is a high level classification of site Content.
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
 * <li>Each Collection is a member of a Category</li>
 * <li>Collections may share the same Collection.heading but if they are in Categories, they are different Collections</li>
 * <li>The name 'Collection' refers to the roll of these records—to collect Articles
 *     <ul>
 *     <li>Articles are sets of Content records with the same Content.heading which are members of a single Collection</li>
 *     <li>Content records may share a Content.heading but if they are in different Collections they will be in different articles</li>
 *     <li>There is a join table between Collections and their Content (see Content Model for more info)</li>
 *     </ul>
 * </li>
 * </ul>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 * 
*/
class CollectionsController extends AppController {

	var $name = 'Collections';
        
//        var $layout = 'noThumbnailPage';

	function index() {
		$this->Collection->recursive = 0;
		$this->set('collections', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid collection', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('collection', $this->Collection->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Collection->create();
			if ($this->Collection->save($this->data)) {
				$this->Session->setFlash(__('The collection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.', true));
			}
		}
		$categories = $this->Collection->Category->find('list');
		$this->set(compact('categories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid collection', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Collection->save($this->data)) {
				$this->Session->setFlash(__('The collection has been saved', true));
//                    debug($this->data);die;
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Collection->read(null, $id);
		}
		$categories = $this->Collection->Category->find('list');
		$this->set(compact('categories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for collection', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Collection->delete($id)) {
			$this->Session->setFlash(__('Collection deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Collection was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
        
        function editCollection($id=null){
            if (!$id && empty($this->data)) {
                $this->Session->setFlash(__('Invalid content', true));
            }
            
            $this->Session->setFlash('');
            $packet = array();
            
            if (!empty($this->data)) {
                $this->params = unserialize($this->data['params']);
                $this->passedArgs = unserialize($this->data['passedArgs']);
    //            debug($this->params);//die;
                $message = ($this->Collection->save($this->data['Collection']))
                    ? 'Collection record saved'
                    : 'Collectin record save failed';
                $this->Session->setFlash($message);
//                $this->redirect('/'.$this->params['url']['url'].'/#');
            }
            
            if(empty($this->data)){
            $this->layout = 'ajax';
    //        $this->layout = 'noThumbnailPage';
                $packet = $this->Collection->find('first',array(
                    'recursive' => -1,
                    'conditions'=>array(
                        'Collection.id'=>$request['id'],
                        'Collection.category_id' => $request['category_id']
                    )
                ));
            $this->set('packet',$packet);
            }
        }
}
?>