<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Article
 */
/**
 * Supplements Controller
 * 
 * Supplement data allows the attachment any number of additional parameters
 * to a Content record. Currently the only use for this data is to
 * provide text positioning and style information for Content records that 
 * belong to Collections of Category 'exhibit'. These Content exhibits have
 * the text positioned over the image.
 * 
 * Other Supplemental data could be provided for use by other Category output routines
 * 
 * The basic structual chain for Content is:
 * <pre>
 *                                                      |<--Supplement
 * Category<--Collection<--ContentCollection-->Content--|
 *                                                      |-->Image
 * </pre>
 * 
 * @package       bindery
 * @subpackage    bindery.Article
 */
class SupplementsController extends AppController {

	var $name = 'Supplements';

	function index() {
		$this->Supplement->recursive = 0;
		$this->set('supplements', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid supplement', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('supplement', $this->Supplement->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Supplement->create();
			if ($this->Supplement->save($this->data)) {
				$this->Session->setFlash(__('The supplement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The supplement could not be saved. Please, try again.', true));
			}
		}
		$images = $this->Supplement->Image->find('list');
		$collections = $this->Supplement->Collection->find('list');
		$this->set(compact('images', 'collections'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid supplement', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Supplement->save($this->data)) {
				$this->Session->setFlash(__('The supplement has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The supplement could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Supplement->read(null, $id);
		}
		$images = $this->Supplement->Image->find('list');
		$collections = $this->Supplement->Collection->find('list');
		$this->set(compact('images', 'collections'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for supplement', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Supplement->delete($id)) {
			$this->Session->setFlash(__('Supplement deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Supplement was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>