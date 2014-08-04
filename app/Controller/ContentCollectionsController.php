<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * ContentCollections Controller
 * 
 * This is the join table between Collections and Content.
 * It allows a single Content record to be attached to several Collections
 * and hence be part of more than one Article.
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
 * <li>ContentCollections serve 3 major functions
 *     <ul>
 *     <li>ContentCollection.publish controlls whether the Content record is gathered as part of the Article</li>
 *     <li>ContentCollection.sub_slug serves a link to another Article. This second Artilcle can provide more 
 * detail about the Content its linked to.</li>
 *     <li>ContentCollection.collection_id provides the second piece of information to create and article. The two 
 * requirements are a shared Content.heading and a shared ContentCollection.collection.id</li>
 *     </ul>
 * </li>
 * </ul>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 * 
*/
class ContentCollectionsController extends AppController {

	var $name = 'ContentCollections';

	function index() {
		$this->ContentCollection->recursive = 0;
		$this->set('contentCollections', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid content collection'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contentCollection', $this->ContentCollection->read(null, $id));
	}

	function add() {
		if (!empty($this->request->data)) {
			$this->ContentCollection->create();
			if ($this->ContentCollection->save($this->request->data)) {
				$this->Session->setFlash(__('The content collection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content collection could not be saved. Please, try again.'));
			}
		}
		$detailCollections = $this->ContentCollection->DetailCollection->find('list');
		$contents = $this->ContentCollection->Content->find('list');
		$collections = $this->ContentCollection->Collection->find('list');
		$this->set(compact('detailCollections', 'contents', 'collections'));
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid content collection'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			if ($this->ContentCollection->save($this->request->data)) {
				$this->Session->setFlash(__('The content collection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The content collection could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->ContentCollection->read(null, $id);
		}
		$detailCollections = $this->ContentCollection->DetailCollection->find('list');
		$contents = $this->ContentCollection->Content->find('list');
		$collections = $this->ContentCollection->Collection->find('list');
		$this->set(compact('detailCollections', 'contents', 'collections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for content collection'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ContentCollection->delete($id)) {
			$this->Session->setFlash(__('Content collection deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Content collection was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>