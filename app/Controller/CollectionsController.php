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
			$this->Session->setFlash(__('Invalid collection'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('collection', $this->Collection->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->Collection->create();
			if ($this->Collection->save($this->request->data)) {
				$this->Session->setFlash(__('The collection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Collection->Category->find('list');
		$this->set(compact('categories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid collection'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->Collection->save($this->request->data)) {
				$this->Session->setFlash(__('The collection has been saved'));
//                    debug($this->request->data);die;
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The collection could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->Collection->read(null, $id);
		}
		$categories = $this->Collection->Category->find('list');
		$this->set(compact('categories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for collection'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Collection->delete($id)) {
			$this->Session->setFlash(__('Collection deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Collection was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        function editCollection($id=null){
            if (!$id && empty($this->request->data)) {
                $this->Session->setFlash(__('Invalid content'));
            }
            
            $this->Session->setFlash('');
            $packet = array();
            
            if (!empty($this->request->data)) {
                $this->request->params = unserialize($this->request->data['params']);
                $this->passedArgs = unserialize($this->request->data['passedArgs']);
    //            debug($this->request->params);//die;
                $message = ($this->Collection->save($this->request->data['Collection']))
                    ? 'Collection record saved'
                    : 'Collectin record save failed';
                $this->Session->setFlash($message);
//                $this->redirect('/'.$this->request->request->url.'/#');
            }
            
            if(empty($this->request->data)){
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