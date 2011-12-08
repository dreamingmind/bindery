<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
/**
 * ContentsController
 * 
 * Handles splash page content
 * @package       bindery
 * @subpackage    bindery.controller
*/
class ContentsController extends AppController {

	var $name = 'Contents';
                
        function beforeFilter() {
            parent::beforeFilter();
            $this->set('navline', $this->Content->Navline->find('list',
                    array('order'=>'route', 'fields'=> array(
                        'Navline.id','Navline.route'
                    ))));
        }

	function index() {
		$this->Content->recursive = 0;
		$this->set('contents', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'content'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('content', $this->Content->read(null, $id));
	}

	function add() {
                $this->set('navline', $this->Content->Navline->find('list',array('order'=>'name')));
		if (!empty($this->data)) {
			$this->Content->create();
			if ($this->Content->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'content'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'content'));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(sprintf(__('Invalid %s', true), 'content'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Content->save($this->data)) {
				$this->Session->setFlash(sprintf(__('The %s has been saved', true), 'content'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(sprintf(__('The %s could not be saved. Please, try again.', true), 'content'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Content->read(null, $id);
                        $this->set('decode',$this->decode($this->data['Content']['content']));
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(sprintf(__('Invalid id for %s', true), 'content'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Content->delete($id)) {
			$this->Session->setFlash(sprintf(__('%s deleted', true), 'Content'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(sprintf(__('%s was not deleted', true), 'Content'));
		$this->redirect(array('action' => 'index'));
	}
        
        function decode($text) {
            $search = array(
                '/(======)(.+)(======)/',
                '/(=====)(.+)(=====)/',
                '/(====)(.+)(====)/',
                '/(===)(.+)(===)/',
                '/(==)(.+)(==)/',
                '/(=)(.+)(=)/',
                '/(-p)(.+)(\n)/',
                '/(-p)(.+)(\z)/');
            $replace = array(
                '<h6>$2</h6>',
                '<h5>$2</h5>',
                '<h4>$2</h4>',
                '<h3>$2</h3>',
                '<h2>$2</h2>',
                '<h1>$2</h1>',
                "<p>$2</p>\n",
                "<p>$2</p>\n");
            return "<div class='splash>\n".preg_replace($search, $replace, $text)."</div>\n";
        }
}
?>